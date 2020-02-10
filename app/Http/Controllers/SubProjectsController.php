<?php

namespace App\Http\Controllers;

use App\SubProject;
use App\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubProjectsController extends Controller
{
	public function list(Request $request)
	{
		$cityIds = $request->get('cityIds');

		SubProject::$listForSelectField = 'fullName';

		$list = SubProject::listForSelect(function (Builder $query) use ($cityIds) {
			$query->with('project');
			if ($cityIds) {
				$query->whereIn('city_id', $cityIds);
			}
		});

		return response()->json($list);
	}

	public function store(Request $request, $project_id)
	{
		$subProject = new SubProject();
		$subProject->project_id = $project_id;
		$subProject->fill($request->all());
		$subProject->save();

		\Flash::success('Подпроект добавлен');

		return redirect()->back();
	}

	public function edit($project_id, $sub_project_id)
	{
		$subProject = SubProject::query()->findOrFail($sub_project_id);
		$project    = $subProject->project;
		$cities     = City::listForSelect();

		return view('projects.subproject.edit')->with([
			'project'     => $project,
			'subProject' => $subProject,
			'cities'      => $cities,
		]);
	}

	public function update(Request $request, $project_id, $sub_project_id)
	{
		$subProject = SubProject::query()->findOrFail($sub_project_id);
		$subProject->project_id = $project_id;
		$subProject->fill($request->all());
		$subProject->save();

		\Flash::success('Подпроект изменен');

		return redirect()->route('projects.edit', $project_id);
	}

	public function destroy(Request $request, $project_id, $sub_project_id)
	{
		$subProject = SubProject::query()->findOrFail($sub_project_id);
		$subProject->delete();

		\Flash::success('Подпроект удален');

		return redirect()->back();
	}
}
