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

	public function edit($id)
	{
		$project  = Project::query()->findOrFail($id);
		$projects = Project::all()->pluck('name', 'id')->toArray();
		$projects = ['' => 'Укажите Проект'] + $projects;

		return view('projects.edit')->with(['project' => $project, 'projects' => $projects]);
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

}
