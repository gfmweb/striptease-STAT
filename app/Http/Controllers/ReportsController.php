<?php

namespace App\Http\Controllers;

use App\City;
use App\Reports\ChannelsReport\ChannelsReport;
use App\Reports\DigestReport\DigestReport;
use App\Reports\MainReport\MainReport;
use App\Reports\PasswordsReport\PasswordsReport;
use Auth;
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

	public function myReport(Request $request)
	{
		return response()->view('reports.my.index');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */

	// получение данные произвольных юзеров
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

		if (!empty($request->get('my'))) $params['partnerIds'] = [Auth::id()];

		$report = new MainReport($params);
		$report->sortBy('dateFrom');

		return view('reports.main.partials.table')->with(['report' => $report]);
	}

	// получение данных авторизованного юзера
	public function myReportData(Request $request)
	{
		$params = [
			'channelIds'    => $request->get('channelIds', []),
			'subProjectIds' => $request->get('subProjectIds', []),
			'partnerIds'    => [Auth::id()],
			'tagIds'        => $request->get('tagIds', []),
			'dateFrom'      => $request->get('dateFrom'),
			'dateTo'        => $request->get('dateTo'),
		];

		$report = new MainReport($params);
		$report->sortBy('dateFrom');

		return view('reports.my.partials.table')->with(['report' => $report]);
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

	public function digest(Request $request)
	{
		$cities = City::listForSelect();

		return view('reports.digest.index')->with(['cities' => $cities]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function digestData(Request $request)
	{
		$params = [
			'city'     => $request->get('city'),
			'dateFrom' => $request->get('dateFrom'),
			'dateTo'   => $request->get('dateTo'),
		];

		$report = new DigestReport($params);

		return view('reports.digest.partials.table')->with(['report' => $report]);
	}


	public function channels(Request $request)
	{
		$cities = City::listForSelect();

		return view('reports.channels.index')->with(['cities' => $cities]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function channelsData(Request $request)
	{
		$params = [
			'partnerIds'    => $request->get('partnerIds'),
			'cityIds'       => $request->get('cityIds'),
			'channelIds'    => $request->get('channelIds'),
			'subProjectIds' => $request->get('subProjectIds'),
		];

		$report = new ChannelsReport($params);

		return view('reports.channels.partials.table')->with(['report' => $report]);
	}

}
