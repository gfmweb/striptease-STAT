<?php

namespace App\Http\Controllers;

use App\Digest;
use App\DigestData;
use App\City;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class DigestDataController extends Controller
{
	public function create()
	{

		$cities = City::listForSelect();

		return view('digest-data.create')->with([
			'cities'      => $cities,
		]);;
	}

	public function list(Request $request)
	{
		$dateFrom = $request->get('dateFrom');
		$dateTo   = $request->get('dateTo');
		$list     = [];

		Digest::with(
			[
				'group',
			])
			->get()
			->each(function (Digest $el) use (&$list) {
				if (!$el->group) return null;
				// Если данных не найдено то создаем пустой набор
				if ($el->data->isNotEmpty()) {
					$data = $el->data[0];
				} else {
					$data = new DigestData;
				}

				// построение списка
				$list[$el->id] = [
					'group_id'    => $el->group->id,
					'group_name'  => $el->group->name,
					'id'          => $el->id,
					'name'        => $el->name,
					'data'        => $data,
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
			$DigestData = DigestData::query()
				->where('date_from', $dateFrom)
				->where('date_to', $dateTo)
				->where('password_city_id', $changed['DigestId'])
				->first();

			if (!$DigestData) {
				$DigestData                   = new DigestData();
				$DigestData->password_city_id = $changed['DigestId'];
				$DigestData->date_from        = $dateFrom;
				$DigestData->date_to          = $dateTo;
			}

			$DigestData->activations = $changed['activations'];

			$DigestData->save();
		}

		return response()->json(['status' => 'success']);
	}
}
