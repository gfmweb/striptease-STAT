<?php

namespace App\Http\Controllers;

use App\City;
use App\SubProject;
use App\Tag;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubProjectsController extends Controller
{
	public function list(Request $request)
	{
		$cityIds = $request->get('cityIds');
		$project = $request->get('project');
		$onlyMy  = !!$request->get('my', false);
		$partnerIds  = $request->get('partnerIds', []);

		if (!empty($request->get('field'))) {
			SubProject::$listForSelectField = $request->get('field');
		}

		$list = SubProject::listForSelect(function (Builder $query) use ($cityIds, $project, $onlyMy, $partnerIds) {
			$query->with('project');
			// Фильтр по городу
			if ($cityIds) {
				$query->whereIn('city_id', $cityIds);
			}
			// Фильтр по проекту
			if ($project && $project !== 'all') {
				$query->where('project_id', $project);
			}
			// Фильтр по партнеру
			if ($partnerIds && $partnerIds !== 'all') {
				$query->whereHas('userSubProject', function (Builder $builder) use($partnerIds) {
					$builder->whereIn('user_id', $partnerIds);
				});
			}
			// Фильтр по своим подпроектам
			if ($onlyMy) {
				$query->whereHas('userSubProject', function (Builder $builder) {
					$builder->where('user_id', Auth::id());
				});
			}
		});

		return response()->json($list);
	}


	public function store(Request $request, $project_id)
	{
		$subProject             = new SubProject();
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
		$tags       = Tag::listForSelect();

		return view('projects.subproject.edit')->with([
			'project'    => $project,
			'subProject' => $subProject,
			'cities'     => $cities,
			'tags'       => $tags,
		]);
	}

	public function update(Request $request, $project_id, $sub_project_id)
	{
		$subProject             = SubProject::query()->findOrFail($sub_project_id);
		$subProject->project_id = $project_id;
		$subProject->fill($request->all());
		$subProject->tags()->sync($request->tags);
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
