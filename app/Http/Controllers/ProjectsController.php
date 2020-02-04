<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
	public function index()
	{
		$projects = Project::all();

		return view('projects.index')->with(['projects' => $projects]);
	}

/*	public function edit($id)
	{
		$channel  = Project::query()->findOrFail($id);
		$channels = Project::all()->pluck('name', 'id')->toArray();
		$channels = ['' => 'Укажите канал'] + $channels;

		return view('channels.edit')->with(['channel' => $channel, 'channels' => $channels]);
	}

	public function create()
	{
		$channel  = new Channel();
		$channels = Project::all()->pluck('name', 'id')->toArray();
		$channels = ['' => 'Укажите канал'] + $channels;

		return view('channels.create')->with(['channel' => $channel, 'channels' => $channels]);
	}

	public function update(Request $request, $id)
	{
		$channel = Project::query()->findOrFail($id);
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
		$channel = Project::query()->findOrFail($id);
		$channel->delete();

		\Flash::success('Канал успешно удален');

		return redirect()->route('channels.index')->getTargetUrl();
	}*/

}
