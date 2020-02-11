<?php

namespace App\Http\Controllers;

use App\Channel;
use App\ChannelsGroup;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$channels = Channel::all();

		return view('channels.index')->with(['channels' => $channels]);
	}

	/**
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$channel  = Channel::query()->findOrFail($id);
		$groups = ChannelsGroup::listForSelect();

		return view('channels.edit')->with(['channel' => $channel, 'groups' => $groups]);
	}

	public function create()
	{
		/** @var Channel $channel */
		$channel  = new Channel();
		$groups = ChannelsGroup::listForSelect();

		return view('channels.create')->with(['channel' => $channel, 'groups' => $groups]);
	}

	/**
	 * @param Request $request
	 * @param         $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id)
	{
		$channel = Channel::query()->findOrFail($id);
		$channel->fill($request->all());
		$channel->save();

		\Flash::success('Канал успешно изменен');

		return redirect()->route('channels.index');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		$channel = new Channel();
		$channel->fill($request->all());
		$channel->save();

		\Flash::success('Канал успешно создан');

		return redirect()->route('channels.index');
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$channel = Channel::query()->findOrFail($id);
		$channel->delete();

		\Flash::success('Канал успешно удален');

		return redirect()->route('channels.index')->getTargetUrl();
	}

	public function list()
	{
		return Channel::listForSelect();
	}

}
