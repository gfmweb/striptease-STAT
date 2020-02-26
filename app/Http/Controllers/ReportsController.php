<?php

namespace App\Http\Controllers;

use App\Reports\MainReport\MainReport;
use App\Reports\PasswordsReport\PasswordsReport;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mainReport(Request $request)
	{
		return response()->view('reports.main.index');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function mainReportData(Request $request)
	{
		$params = [
			'channelIds'    => $request->get('channelIds', []),
			'subProjectIds' => $request->get('subProjectIds', []),
			'partnerIds'    => $request->get('partnerIds', []),
			'tagIds'        => $request->get('tagIds', []),
			'dateFrom'      => $request->get('dateFrom'),
			'dateTo'        => $request->get('dateTo'),
		];

		$report = new MainReport($params);
		$report->sortBy('dateFrom');

		return view('reports.main.partials.table')->with(['report' => $report]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function passwords(Request $request)
	{
		return response()->view('reports.passwords.index');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function passwordsData(Request $request)
	{
		$params = [
			'channelIds'    => $request->get('channelIds', []),
			'subProjectIds' => $request->get('subProjectIds', []),
			'partnerIds'    => $request->get('partnerIds', []),
			'tagIds'        => $request->get('tagIds', []),
			'dateFrom'      => $request->get('dateFrom'),
			'dateTo'        => $request->get('dateTo'),
		];

		$report = new PasswordsReport($params);
		$report->sortBy('dateFrom');

		return view('reports.passwords.partials.table')->with(['report' => $report]);
	}

}
