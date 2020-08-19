<?php


namespace App\Reports\ChannelsReport;


use App\Helpers\TextHelper;
use App\UserSubProject;
use App\UserTarget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ChannelsReport
{
	/**
	 * @var Collection
	 */
	public $items;

	/**
	 * @var array
	 */
	public $params;

	/**
	 * MainReport constructor.
	 * @param array $params
	 */
	public function __construct(array $params)
	{
		$this->makeParams($params);
		$this->build();
	}

	/**
	 * @param $field
	 */
	public function sortBy($field)
	{
		$this->items = $this->items->sortBy($field);
	}

	/**
	 * @param $params
	 */
	public function makeParams($params)
	{
		$this->params = [
			'cityIds'       => $params['cityIds'] ?? [],
			'channelIds'    => $params['channelIds'] ?? [],
			'subProjectIds' => $params['subProjectIds'] ?? [],
			'partnerIds'    => $params['partnerIds'] ?? [],
		];
	}

	/**
	 *
	 */
	public function build()
	{
		$this->items = collect();
		// Запрос
		$dataQuery = UserSubProject::with(
			[
				'userTargets',
				'userTargets.channel',
				'userTargets.status',
				'subProject',
				'subProject.tags',
				'subProject.project',
				'subProject.city',
				'user',
			])
			->whereIn('user_id', $this->params['partnerIds'])
			->whereIn('sub_project_id', $this->params['subProjectIds']);

		// Если указан фильтр по городам то дополняем условием
		if (!empty($this->params['cityIds'])) {
			$dataQuery->whereHas('subProject', function (Builder $query) {
				$query->whereIn('city_id', $this->params['cityIds']);
			});
		}
		// Если указан фильтр по каналам то дополняем условием
		if (!empty($this->params['channelIds'])) {
			$dataQuery->whereHas('userTargets', function (Builder $query) {
				$query->whereIn('channel_id', $this->params['channelIds']);
			});
		}

		// выборка

		$data = $dataQuery->get();
		// Обработка результата
		$data->each(function (UserSubProject $userSubProject) {
			$userSubProject->userTargets->each(function (UserTarget $userTarget) use ($userSubProject) {
				$item = [
					'city'           => $userSubProject->subProject->city->name ?? '-',
					'projectName'    => $userSubProject->subProject->project->name ?? '-',
					'subProjectName' => $userSubProject->subProject->name ?? '-',
					'subProjectTags' => TextHelper::tagsForLabel($userSubProject->subProject),
					'url'            => $userSubProject->subProject->fullUrl,
					'shortUrl'       => $userSubProject->subProject->shortUrl,
					'partner'        => $userSubProject->user->name ?? '-',
					'channel'        => $userTarget->channel->name,
					'status'         => $userTarget->status->name ?? '-',
					'statusClass'    => $userTarget->status->class ?? '-',
				];

				$this->items->push($item);
			});
		});
	}

	/** Суммарный показатель $field
	 * @param $filed
	 * @return mixed
	 */
	public function sum($filed)
	{
		return $this->items->sum($filed);
	}
}