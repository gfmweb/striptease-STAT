<?php
namespace App\Reports\DigestReport;

use App\Helpers\CalcHelper;
use App\Helpers\TextHelper;
use App\Digest;
use App\DigestData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class DigestReport
{
	/**
	 * @var Collection
	 */
	public $items;

	/**
	 * @var array
	 */
	public $params;

	public function __construct(array $params)
	{
		$this->makeParams($params);
		$this->build();
	}

	public function makeParams($params)
	{
		$this->params = [
			'city' => $params['city'] ?? '',
		];

		$this->params['dateFrom'] = Carbon::parse($params['dateFrom'] ?? 0);
		$this->params['dateTo']   = empty($params['dateTo']) ? now() : Carbon::parse($params['dateTo']);
	}

	public function build()
	{
		$this->items = collect();

		// Запрос
		$dataQuery = Digest::with(
			[
				'group',
				'data' => function (HasMany $query) {
					$query->whereNested(function($query){
						$query
							->whereBetween('date_from', [$this->params['dateFrom'], $this->params['dateTo']])
							->orWhereBetween('date_to', [$this->params['dateFrom'], $this->params['dateTo']]);
					});
					// Если указан фильтр по городу то дополняем условием
					if (!empty($this->params['city'])) {
						$query->where('city_id', $this->params['city']);
					}
					/*$sql = str_replace_array('?', $query->getBindings(), $query->toSql());
					dd($sql);*/
				},
			]);

		// выборка
		$digests = $dataQuery->get();

		$items = [];
		foreach ($digests as $digest) {
			$items[$digest->group->id][$digest->id]['group_id']   = $digest->group->id;
			$items[$digest->group->id][$digest->id]['group_name'] = $digest->group->name;
			$items[$digest->group->id][$digest->id]['id']         = $digest->id;
			$items[$digest->group->id][$digest->id]['name']       = $digest->name;
			$data = [];
			foreach ($digest->data as $digestData) {
				$items[$digest->group->id][$digest->id]['data_raw'][] = $digestData->onlyValues();
				$data[] = $digestData->onlyValues();
			}
			// суммирование значений
			$items[$digest->group->id][$digest->id]['data'] = CalcHelper::sumValues($data);
		}

		$this->items = $items;
	}

	/** Суммарный показатель $field
	 * @param $field
	 * @return mixed
	 */
	public function sum($field)
	{
		return $this->items->sum($field);
	}

	/** Суммарный показатель CPL
	 * @return float|int
	 */
	public function cplSum()
	{
		return CalcHelper::cpl($this->items->sum('leads'), $this->items->sum('cost'));
	}


	/** Суммарный показатель конверсии
	 * @return float|int
	 */
	public function conversionSum()
	{
		return CalcHelper::percent($this->items->sum('activations'), $this->items->sum('leads'));
	}


}