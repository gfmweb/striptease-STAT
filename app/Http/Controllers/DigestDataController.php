<?php

namespace App\Http\Controllers;

use App\Digest;
use App\DigestGroup;
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
			'cities' => $cities,
		]);;
	}

	public function list(Request $request)
	{
		$dateFrom = $request->get('dateFrom');
		$dateTo   = $request->get('dateTo');
		$city     = $request->get('city');
		$list     = [];

		Digest::with([
				'group',
				'data' => function (HasMany $query) use ($dateFrom, $dateTo, $city) {
					$query
						->select(DigestData::$values)
						->addSelect('digest_id') // Для связывания моделей
						->where('date_from', $dateFrom)
						->where('date_to', $dateTo)
						->where('city_id', $city);
				}
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
				$list[$el->group->id][$el->id] = [
					'group_id'   => $el->group->id,
					'group_name' => $el->group->name,
					'id'         => $el->id,
					'name'       => $el->name,
					'data'       => $data->onlyValues(),
				];
			})->filter();

		// объекты на втором уровне превращаем в массивы
		foreach ($list as $group_id => $group) $list[$group_id] = array_values($group);

		return response()->json(array_values($list));
	}

	public function save(Request $request)
	{
		$changedList = $request->get('changed', []);
		$dateFrom    = $request->get('dateFrom');
		$dateTo      = $request->get('dateTo');
		$city        = $request->get('city');

		foreach ($changedList as $changed) {
			$values         = $changed['values'];
			// обновление?
			$digestData = DigestData::query()
				->where('date_from', $dateFrom)
				->where('date_to', $dateTo)
				->where('digest_id', $changed['digestId'])
				->where('city_id', $city)
				->first();
			// новая запись
			if (!$digestData) {
				$digestData            = new DigestData();
				$digestData->digest_id = $changed['digestId'];
				$digestData->city_id   = $city;
				$digestData->date_from = $dateFrom;
				$digestData->date_to   = $dateTo;
			}

			foreach (DigestData::$values as $field) {
				$digestData->{$field} = $values[$field];
			}

			$digestData->save();
		}

		return response()->json(['status' => 'success']);
	}
}
