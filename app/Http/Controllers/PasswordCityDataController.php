<?php

namespace App\Http\Controllers;

use App\PasswordCity;
use App\PasswordCityData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class PasswordCityDataController extends Controller
{
	public function create()
	{
		return view('password-city-data.create');
	}

	public function list(Request $request)
	{
		$dateFrom = $request->get('dateFrom');
		$dateTo   = $request->get('dateTo');
		$list     = [];

		PasswordCity::with(
			[
				'password',
				'city',
				'data' => function (HasMany $query) use ($dateFrom, $dateTo) {
					$query
						->select(['password_city_id', 'activations'])
						->where('date_from', $dateFrom)
						->where('date_to', $dateTo);
				}
			])
			->get()
			->each(function (PasswordCity $el) use (&$list) {
				if (!$el->password || !$el->city) return null;
				// Если данных не найдено то создаем пустой набор
				if ($el->data->isNotEmpty()) {
					$activations = $el->data->first()->activations;
				} else {
					$activations = 0;
				}

				if (!isset($list[$el->password->id])) {
					$list[$el->password->id] = [
						'id'     => $el->password->id,
						'name'   => $el->password->name,
						'cities' => []
					];
				}

				$list[$el->password->id]['cities'][$el->city->slug] = [
					'cityId'         => $el->city->id,
					'passwordCityId' => $el->id,
					'activations'    => $activations,
				];

			})->filter();

		return response()->json(array_values($list));
	}

	public function save(Request $request)
	{
		$changedList = $request->get('changed', []);
		$dateFrom    = $request->get('dateFrom', '2020-01-13');
		$dateTo      = $request->get('dateTo', '2020-01-19');
		$startDate   = (new Carbon())->subDay(3)->startOfWeek();

		// Проверка на 3 дня (предыдущую неделю можно редактировать лишь спустя еще 3 дня после)
		if (Carbon::parse($dateFrom) < $startDate) {
			response()->json(['status' => 'error', 'error' => 'На эту неделю нельзя заполнять данные. Прошли сроки']);
		}

		foreach ($changedList as $changed) {
			$passwordCityData = PasswordCityData::query()
				->where('date_from', $dateFrom)
				->where('date_to', $dateTo)
				->where('password_city_id', $changed['passwordCityId'])
				->first();

			if (!$passwordCityData) {
				$passwordCityData                   = new PasswordCityData();
				$passwordCityData->password_city_id = $changed['passwordCityId'];
				$passwordCityData->date_from        = $dateFrom;
				$passwordCityData->date_to          = $dateTo;
			}

			$passwordCityData->activations = $changed['activations'];

			$passwordCityData->save();
		}

		return response()->json(['status' => 'success']);
	}
}
