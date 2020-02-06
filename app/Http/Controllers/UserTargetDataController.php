<?php

namespace App\Http\Controllers;

use App\SubProject;
use App\UserSubProject;
use App\UserTarget;
use App\UserTargetData;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserTargetDataController extends Controller
{
	public function index()
	{
		return response()->view('user-target-data.index');
	}

	public function create()
	{

		/** @var Collection $dataSubProjects */
		$dataSubProjects = \Auth::user()
			->subProjects()
			->with('project')
			->get()
			->map(function (SubProject $el) {
				return [
					'id'   => $el->id,
					'name' => $el->fullName
				];
			});

		return view('user-target-data.create', [
			'dataSubProjects' => $dataSubProjects->toJson(),
		]);
	}

	public function list(Request $request)
	{
		$dateFrom     = $request->get('dateFrom');
		$dateTo       = $request->get('dateTo');
		$subProjectId = $request->get('subProjectId');

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

			$userTargetData->coverage    = $values['coverage'];
			$userTargetData->transition  = $values['transition'];
			$userTargetData->clicks      = $values['clicks'];
			$userTargetData->leads       = $values['leads'];
			$userTargetData->activations = $values['activations'];
			$userTargetData->price       = $values['price'];


			$userTargetData->save();
		}

		return response()->json(['status' => 'success']);
	}
}
