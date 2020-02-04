<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
	public function index()
	{
		$partners = Partner::all();

		return view('partners.index')->with(['partners' => $partners]);
	}

	/*public function edit($id)
	{
		$channel  = Partner::query()->findOrFail($id);
		$channels = Partner::all()->pluck('name', 'id')->toArray();
		$channels = ['' => 'Укажите канал'] + $channels;

		return view('channels.edit')->with(['channel' => $channel, 'channels' => $channels]);
	}

	public function create()
	{
		$channel  = new Channel();
		$channels = Partner::all()->pluck('name', 'id')->toArray();
		$channels = ['' => 'Укажите канал'] + $channels;

		return view('channels.create')->with(['channel' => $channel, 'channels' => $channels]);
	}

	public function update(Request $request, $id)
	{
		$channel = Partner::query()->findOrFail($id);
		$channel->fill($request->all());
		$channel->save();

		\Flash::success('Канал успешно изменен');

		return redirect()->route('channels.index');
	}


	public function store(Request $request)
	{
		$channel = new Channel();
		$channel->fill($request->all());
		$channel->save();

		\Flash::success('Канал успешно создан');

		return redirect()->route('channels.index');
	}

	public function destroy($id)
	{
		$channel = Partner::query()->findOrFail($id);
		$channel->delete();

		\Flash::success('Канал успешно удален');

		return redirect()->route('channels.index')->getTargetUrl();
	}*/

}
