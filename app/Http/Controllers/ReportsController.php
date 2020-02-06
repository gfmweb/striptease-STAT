<?php

namespace App\Http\Controllers;

use App\UserSubProject;
use App\UserTarget;
use App\UserTargetData;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function main(Request $request)
	{
		$channelIds    = $request->get('channelIds', []);
		$subProjectIds = $request->get('subProjectIds', []);
		$partnersIds   = $request->get('partnerIds', []);
		$dateFrom      = $request->get('dateFrom');
		$dateTo        = $request->get('dateTo');

		$report = collect();

		// Запрос
		$data = UserSubProject::with(
			[
				'userTargets' => function (HasMany $query) use ($channelIds) {
					$query->whereIn('channel_id', $channelIds);
				},

				'userTargets.data' => function (HasMany $query) use ($dateFrom, $dateTo) {
					$query
						->whereBetween('date_from', [$dateFrom, $dateTo])
						->orWhereBetween('date_to', [$dateFrom, $dateTo]);
				},
				'userTargets.channel',
				'subProject',
				'subProject.city',
				'user',
			])
			->whereIn('user_id', $partnersIds)
			->whereIn('sub_project_id', $subProjectIds)
			->get();
		// Обработка результата
		$data->each(function (UserSubProject $userSubProject) use ($report) {
			$userSubProject->userTargets->each(function (UserTarget $userTarget) use ($report, $userSubProject) {
				$userTarget->data->each(function (UserTargetData $userTargetData) use ($report, $userTarget, $userSubProject) {
					$report->push([
							'city'       => $userSubProject->subProject->city->name,
							'subProject' => $userSubProject->subProject->name,
							'url'        => $userSubProject->subProject->url,
							'partner'    => $userSubProject->user->name,
							'channel'    => $userTarget->channel->name,
							'dateFrom'   => $userTargetData->date_from,
							'dateTo'     => $userTargetData->date_to,
						] + $userTargetData->onlyValues());
				});
			});
		});

		return view('reports.main')->with(['report' => $report->sortBy('dateFrom')]);
	}

}
