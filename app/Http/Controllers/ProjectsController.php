<?php

namespace App\Http\Controllers;

use App\Project;
use App\SubProject;
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

	// добавить подпроект проекту
	public function addSubProject(Request $request, $id)
	{
		$subProject = new SubProject;
		$subProject->project_id = $id;
		$subProject->name       = $request->get('sub_project_name');
		$subProject->url        = $request->get('sub_project_url');
		$subProject->city_id    = $request->get('sub_project_city');
		$subProject->save();

		\Flash::success('Подпроект добавлен');

		return redirect()->route('projects.edit', $id);
	}

	// удалить подпроект
	public function deleteSubProject(Request $request, $id)
	{
		$subProject = SubProject::where('id', $request->get('sub_project_id'))->delete();

		\Flash::success('Подпроект удален');

		return redirect()->route('projects.edit', $id);
	}

	// статусы проектов
	public function targets(Request $request) {
		if (!empty($request->user)) {
			// $userSubProjects = UserSubProject::with(['subProject'])
			$targets = UserTarget::paginate(20);
		} else
			$targets = UserTarget::paginate(20);

		$projects = Project::all();
		$channels = Channel::whereNull('parent_id')->get();
		$users    = User::where('role', 1)->get();
		$statuses = Status::all();



		return view('projects.targets')->with([
			'targets'  => $targets,
			'users'    => $users,
			'projects' => $projects,
			'channels' => $channels,
			'statuses' => $statuses,
		]);
	}

}
