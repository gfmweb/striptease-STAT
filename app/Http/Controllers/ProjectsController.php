<?php

namespace App\Http\Controllers;

use App\Channel;
use App\City;
use App\Project;
use App\Status;
use App\StatusHistory;
use App\SubProject;
use App\User;
use App\UserSubProject;
use App\UserTarget;
use Auth;
use Illuminate\Database\Eloquent\Builder;
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
		$project     = Project::query()->findOrFail($id);
		$subProjects = $project->subProjects;
		$cities      = City::all();

		return view('projects.edit')->with([
			'project'     => $project,
			'subProjects' => $subProjects,
			'cities'      => $cities,
		]);
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
	public function targets(Request $request)
	{

		$targets = UserTarget::query();

		// фильтр по юзерам
		if (!empty($request->user)) {
			$userSubProjectsIds = UserSubProject::where('user_id', $request->user)->pluck('id');
			$targets            = $targets->whereIn('user_sub_project_id', $userSubProjectsIds);
		}
		// фильтр по проектам
		if (!empty($request->project)) {
			$subProjectsIds     = SubProject::where('project_id', $request->project)->pluck('id');
			$userSubProjectsIds = UserSubProject::whereIn('sub_project_id', $subProjectsIds)->pluck('id');
			$targets            = $targets->whereIn('user_sub_project_id', $userSubProjectsIds);
		}
		// фильтр по городам
		if (!empty($request->city)) {
			$subProjectsIds     = SubProject::where('city_id', $request->city)->pluck('id');
			$userSubProjectsIds = UserSubProject::whereIn('sub_project_id', $subProjectsIds)->pluck('id');
			$targets            = $targets->whereIn('user_sub_project_id', $userSubProjectsIds);
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
		$channels = Channel::all();
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

	// проекты пользователя
	public function myProjects()
	{
		$userSubProjects = Auth::user()
			->userSubProjects()
			->with(['subProject', 'subProject.project', 'subProject.city'])
			->withCount('userTargets')
			->get();

		$subProjects = $userSubProjects->map(function (UserSubProject $userSubProject) {
			return [
				'project'       => $userSubProject->subProject->project,
				'name'          => $userSubProject->subProject->name,
				'city'          => $userSubProject->subProject->city,
				'id'            => $userSubProject->subProject->id,
				'url'           => $userSubProject->subProject->url,
				'fullUrl'       => $userSubProject->subProject->fullUrl,
				'appointedAt'   => $userSubProject->created_at,
				'channelsCount' => $userSubProject->user_targets_count,
			];
		});

		return view('projects.my-projects')->with([
			'subProjects' => $subProjects,
		]);
	}

	public function myProjectChannels(Request $request, $subProjectId)
	{
		$userSubProject = Auth::user()
			->userSubProjects()
			->with(['subProject', 'subProject.project', 'subProject.city', 'userTargets', 'userTargets.channel', 'userTargets.lastHistory'])
			->where('sub_project_id', $subProjectId)
			->first();

		$statuses = Status::all();

		return view('projects.my-project-channels')->with([
			'userSubProject' => $userSubProject,
			'statuses'       => $statuses
		]);
	}

	public function myProjectChannelsEdit(Request $request, $subProjectId)
	{
		$userSubProject = UserSubProject::with(['userTargets', 'subProject'])
			->where('sub_project_id', $subProjectId)
			->where('user_id', Auth::id())
			->first();

		$subProject   = $userSubProject->subProject;
		$alreadyExist = $userSubProject->userTargets->map(function (UserTarget $userTarget) {
			return $userTarget->channel_id;
		})->all();

		$channels = Channel::listForSelect(function (Builder $query) use ($alreadyExist) {
			$query->whereNotIn('id', $alreadyExist);
		});

		return view('projects.my-project-channels-edit')->with([
			'subProject' => $subProject,
			'channels'   => $channels,
			'status_id'  => 1,
		]);
	}

	public function myProjectChannelsUpdate(Request $request, $subProjectId)
	{
		$channelIds = $request->get('channels');
		if (!empty($channelIds)) {
			$userSubProject = UserSubProject::query()
				->where('sub_project_id', $subProjectId)
				->where('user_id', Auth::id())
				->first();

			$newUserTargets = [];
			foreach ($channelIds as $channelId) {
				UserTarget::query()->create([
					'user_sub_project_id' => $userSubProject->id,
					'channel_id'          => $channelId
				]);
			}

			\Flash::success('Каналы успешно добавлены');
		}

		return response()->redirectToRoute('my-projects.channels', $subProjectId);
	}

	// обновление таргета пользователя
	public function myProjectTargetUpdate(Request $request)
	{
		$target            = UserTarget::where('id', $request->get('target_id'))->first();
		$target->status_id = $request->get('target_status');
		// статус "взят в работу" таргету проставляем только один раз
		if ($request->get('target_status') == 2 && empty($target->started_at)) $target->started_at = now();
		// статус "moderated_at" обновляется каждый раз при установке статуса "идут показы"
		if ($request->get('target_status') == 4) $target->moderated_at = now();
		$target->save();

		// история смены статусов
		$history                 = new StatusHistory();
		$history->status_id      = $request->get('target_status');
		$history->user_target_id = $request->get('target_id');
		$history->comment        = $request->get('target_comment');
		$history->save();

		\Flash::success('Статус проекта обновлен');

		return redirect()->back();
	}

}
