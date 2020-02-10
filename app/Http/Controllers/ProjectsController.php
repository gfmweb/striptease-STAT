<?php

namespace App\Http\Controllers;

use App\Project;
use App\SubProject;
use App\UserSubProject;
use App\City;
use App\User;
use App\Channel;
use App\Status;
use App\UserTarget;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
	public function index()
	{
		$projects = Project::all();
		return view('projects.index')->with([
			'projects' => $projects,
		]);
	}

	public function edit($id)
	{
		$project  = Project::query()->findOrFail($id);
		$subProjects = $project->subProjects;
		$cities = City::all();

		return view('projects.edit')->with(['project' => $project, 'subProjects' => $subProjects, 'cities' => $cities]);
	}

	public function create()
	{
		$project  = new Project();
		$projects = Project::all()->pluck('name', 'id')->toArray();
		$projects = ['' => 'Укажите Проект'] + $projects;

		return view('projects.create')->with(['project' => $project, 'projects' => $projects]);
	}

	public function update(Request $request, $id)
	{
		$project = Project::query()->findOrFail($id);
		$project->fill($request->all());
		$project->save();

		\Flash::success('Проект изменен');

		return redirect()->route('projects.index');
	}

	public function store(Request $request)
	{
		$project = new Project();
		$project->fill($request->all());
		$project->save();

		\Flash::success('Проект успешно создан');

		return redirect()->route('projects.index');
	}

	public function destroy($id)
	{
		$project = Project::query()->findOrFail($id);
		$project->delete();

		\Flash::success('Проект удален');

		return redirect()->route('projects.index')->getTargetUrl();
	}

	// статусы проектов
	public function targets(Request $request) {

		$targets = UserTarget::query();

		// фильтр по юзерам
		if (!empty($request->user)) {
			$userSubProjectsIds = UserSubProject::where('user_id', $request->user)->pluck('id');
			$targets = $targets->whereIn('user_sub_project_id', $userSubProjectsIds);
		}
		// фильтр по проектам
		if (!empty($request->project)) {
			$subProjectsIds = SubProject::where('project_id', $request->project)->pluck('id');
			$userSubProjectsIds = UserSubProject::whereIn('sub_project_id', $subProjectsIds)->pluck('id');
			$targets = $targets->whereIn('user_sub_project_id', $userSubProjectsIds);
		}
		// фильтр по городам
		if (!empty($request->city)) {
			$subProjectsIds = SubProject::where('city_id', $request->city)->pluck('id');
			$userSubProjectsIds = UserSubProject::whereIn('sub_project_id', $subProjectsIds)->pluck('id');
			$targets = $targets->whereIn('user_sub_project_id', $userSubProjectsIds);
		}
		// фильтр по каналам
		if (!empty($request->channel)) {
			$targets = $targets->where('channel_id', $request->channel);
		}
		// фильтр по статусам
		if (!empty($request->status)) {
			$targets = $targets->where('status_id', $request->status);
		}

		$targets = $targets->paginate(20);

		$projects = Project::listForSelect();
		$channels = Channel::whereNull('parent_id')->get();
		$users    = User::listForSelect();
		$statuses = Status::listForSelect();
		$cities   = City::listForSelect();

		return view('projects.targets')->with([
			'targets'  => $targets,
			'users'    => $users,
			'projects' => $projects,
			'channels' => $channels,
			'statuses' => $statuses,
			'cities'   => $cities,
		]);
	}

}
