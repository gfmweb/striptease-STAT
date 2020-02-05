<?php

namespace App\Http\Controllers;

use App\Project;
use App\SubProject;
use App\City;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
	public function index()
	{
		$projects = Project::all();

		return view('projects.index')->with(['projects' => $projects]);
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

}
