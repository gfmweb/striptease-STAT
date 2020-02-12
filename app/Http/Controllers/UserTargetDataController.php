<?php

namespace App\Http\Controllers;

use App\UserSubProject;
use App\UserTarget;
use App\UserTargetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class UserTargetDataController extends Controller
{
	public function create()
	{
		return view('user-target-data.create');
	}

	public function list(Request $request)
	{
		$dateFrom     = $request->get('dateFrom');
		$dateTo       = $request->get('dateTo');
		$subProjectId = $request->get('subProjectId');
		$city         = $request->get('city');

		$list = UserSubProject::with(
			[
				'userTargets',
				'userTargets.channel',
				'userTargets.data' => function (HasMany $query) use ($dateFrom, $dateTo) {
					$query
						->select(UserTargetData::$values)
						->addSelect('user_target_id')// Для связывания таблиц
						->where('date_from', $dateFrom)
						->where('date_to', $dateTo);
				}
			])
			->where('user_id', \Auth::user()->id)
			->where('sub_project_id', $subProjectId)
			->get()
			->map(function (UserSubProject $el) {
				return $el->userTargets->map(function (UserTarget $userTarget) {
					// Если данных не найдено то создаем пустой набор
					if ($userTarget->data->isNotEmpty()) {
						$data = $userTarget->data[0];
					} else {
						$data = new UserTargetData;
					}

					return [
						'userTargetId'      => $userTarget->id,
						'targetChannelName' => $userTarget->channel->name,
						'values'            => $data->onlyValues()
					];
				});
			})->collapse(1);

		return response()->json($list);
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
			$values         = $changed['values'];
			$userTargetData = UserTargetData::query()
				->where('date_from', $dateFrom)
				->where('date_to', $dateTo)
				->where('user_target_id', $changed['userTargetId'])
				->first();

			if (!$userTargetData) {
				$userTargetData                 = new UserTargetData();
				$userTargetData->user_target_id = $changed['userTargetId'];
				$userTargetData->date_from      = $dateFrom;
				$userTargetData->date_to        = $dateTo;
			}

			foreach (UserTargetData::$values as $field) {
				$userTargetData->{$field} = $values[$field];
			}

			$userTargetData->save();
		}

		return response()->json(['status' => 'success']);
	}
}
