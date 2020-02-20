<?php


namespace App\Reports\MainReport;


use App\Helpers\CalcHelper;
use App\UserSubProject;
use App\UserTarget;
use App\UserTargetData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class MainReport
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
			'channelIds'    => $params['channelIds'] ?? [],
			'subProjectIds' => $params['subProjectIds'] ?? [],
			'partnerIds'    => $params['partnerIds'] ?? [],
			'tagIds'        => $params['tagIds'] ?? [],

		];

		$this->params['dateFrom'] = Carbon::parse($params['dateFrom'] ?? 0);
		$this->params['dateTo']   = empty($params['dateTo']) ? now() : Carbon::parse($params['dateTo']);
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
				'userTargets'      => function (HasMany $query) {
					$query->whereIn('channel_id', $this->params['channelIds']);
				},
				'userTargets.data' => function (HasMany $query) {
					$query
						->whereBetween('date_from', [$this->params['dateFrom'], $this->params['dateTo']])
						->orWhereBetween('date_to', [$this->params['dateFrom'], $this->params['dateTo']]);
				},
				'userTargets.channel',
				'subProject',
				'subProject.project',
				'subProject.tags',
				'subProject.city',
				'user',
			])
			->whereIn('user_id', $this->params['partnerIds'])
			->whereIn('sub_project_id', $this->params['subProjectIds']);

		// Если указан фильтр по тегам то дополняем условием
		if (!empty($this->params['tagIds'])) {
			$dataQuery->whereHas('subProject.tags', function (Builder $query) {
				$query->whereIn('tag_id', $this->params['tagIds']);
			});
		}

		// выборка
		$data = $dataQuery->get();

		// Обработка результата
		$data->each(function (UserSubProject $userSubProject) {
			$userSubProject->userTargets->each(function (UserTarget $userTarget) use ($userSubProject) {
				$userTarget->data->each(function (UserTargetData $userTargetData) use ($userTarget, $userSubProject) {
					$item                    = [
							'city'           => $userSubProject->subProject->city->name,
							'projectName'    => $userSubProject->subProject->project->name,
							'subProjectName' => $userSubProject->subProject->name,
							'url'            => $userSubProject->subProject->fullUrl,
							'shortUrl'       => $userSubProject->subProject->shortUrl,
							'partner'        => $userSubProject->user->name,
							'channel'        => $userTarget->channel->name,
							'dateFrom'       => $userTargetData->date_from,
							'dateTo'         => $userTargetData->date_to,
						] + $userTargetData->onlyValues();
					$item['cpl']             = CalcHelper::cpl($item['leads'], $item['cost']);
					$item['activationPrice'] = CalcHelper::cpl($item['activations'], $item['cost']);
					$item['conversionSum']   = CalcHelper::percent($item['activations'], $item['leads']);

					$this->items->push($item);
				});
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

	/** Суммарный показатель CPL
	 * @return float|int
	 */
	public function cplSum()
	{
		return CalcHelper::cpl($this->items->sum('leads'), $this->items->sum('cost'));
	}

	/** Суммарный показатель стоимости активации
	 * @return float|int
	 */
	public function activationPriceSum()
	{
		return CalcHelper::cpl($this->items->sum('activations'), $this->items->sum('cost'));
	}

	/** Суммарный показатель конверсии
	 * @return float|int
	 */
	public function conversionSum()
	{
		return CalcHelper::percent($this->items->sum('activations'), $this->items->sum('leads'));
	}


}