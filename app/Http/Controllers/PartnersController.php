<?php

namespace App\Http\Controllers;

use App\Mail\NewSubProjectForPartnerMail;
use App\Project;
use App\SubProject;
use App\User;
use App\UserSubProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Hash;
use Mail;
use Auth;

class PartnersController extends Controller
{
	public function index()
	{
		if (Auth::user()->isSuperAdmin()) {
			$partners = User::all();
		} else {
			$partners = User::onlyPartners()->get();
		}

		return view('partners.index')->with(['partners' => $partners]);
	}

	public function edit($id)
	{
		$partner = User::query()->findOrFail($id);

		// подпроекты партнера
		$userSubProjects = $partner->subProjects;

		// список id тех подпроектов, которые уже есть у юзера
		$userSubProjectsIds = [];
		foreach ($userSubProjects as $userSubProject) $userSubProjectsIds[] = $userSubProject->id;

		// все проекты и подпроекты (для возможности добавления их партнеру)
		$projects    = Project::all();
		$subProjects = SubProject::whereNotIn('id', $userSubProjectsIds)->get();

		return view('partners.edit')
			->with([
				'partner'         => $partner,
				'projects'        => $projects,
				'subProjects'     => $subProjects,
				'userSubProjects' => $userSubProjects,
			]);
	}

	public function create()
	{
		$partner  = new User();
		$partners = User::all()->pluck('name', 'id')->toArray();
		$partners = ['' => 'Укажите канал'] + $partners;

		return view('partners.create')->with(['partner' => $partner, 'partners' => $partners]);
	}

	public function update(Request $request, $id)
	{
		/** @var User $partner */
		$partner = User::query()->findOrFail($id);
		$partner->fill($request->except('password'));
		if ($request->filled('password')) {
			$partner->password =  Hash::make($request->get('password'));
		}
		$partner->save();

		\Flash::success('Партнер успешно изменен');

		return redirect()->route('partners.index');
	}


	public function store(Request $request)
	{
		$partner = new User();
		$partner->fill($request->all());
		$partner->password = Hash::make($request->get('password'));
		$partner->save();

		\Flash::success('Партнер успешно создан');

		return redirect()->route('partners.index');
	}

	public function destroy($id)
	{
		/** @var User $partner */
		$partner = User::query()->findOrFail($id);
		$partner->delete();

		\Flash::success('Партнер успешно удален');

		return redirect()->route('partners.index')->getTargetUrl();
	}


	// добавление проекта пользователю
	public function addUserSubProject(Request $request, $id)
	{
		/** @var User $user */
		/** @var SubProject $subProject */
		/** @var UserSubProject $userSubProject */

		$user       = User::query()->findOrFail($id);
		$subProject = SubProject::query()->findOrFail($request->get('sub_project_id'));

		$userSubProject                 = new UserSubProject;
		$userSubProject->user_id        = $id;
		$userSubProject->sub_project_id = $request->get('sub_project_id');
		$userSubProject->save();

		// Отправка письма
		Mail::to($user)->send(new NewSubProjectForPartnerMail($subProject));

		\Flash::success('Проект добавлен партнеру');

		return redirect()->route('partners.edit', $id);
	}


	public function list(Request $request)
	{
		$cityIds       = $request->get('cityIds');
		$subProjectIds = $request->get('subProjectIds');

		$list = User::listForSelect(function (Builder $query) use ($cityIds, $subProjectIds) {
			$query->onlyPartners();
			if ($subProjectIds) {
				$query->whereHas('subProjects', function (Builder $query) use ($cityIds, $subProjectIds) {
					$query->whereIn('sub_projects.id', $subProjectIds);
					if ($cityIds) {
						$query->whereIn('city_id', $cityIds);
					}
				});
			}
		});

		return response()->json($list);
	}

}
