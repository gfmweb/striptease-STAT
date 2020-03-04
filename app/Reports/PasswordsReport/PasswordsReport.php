<?php


namespace App\Reports\PasswordsReport;


use App\Helpers\TextHelper;
use App\PasswordCityData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PasswordsReport
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
			'tagIds' => $params['tagIds'] ?? [],

		];

		$this->params['dateFrom'] = Carbon::parse($params['dateFrom'] ?? 0);
		$this->params['dateTo']   = empty($params['dateTo']) ? now() : Carbon::parse($params['dateTo']);
	}

	/**
	 *
	 */
	public function build()
	{
		$dataQuery = PasswordCityData::with(
			[
				'passwordCity',
				'passwordCity.password.tags',
				'passwordCity.city'
			])
			->where(function (Builder $query) {
				$query->whereBetween('date_from', [$this->params['dateFrom'], $this->params['dateTo']]);
				$query->orWhereBetween('date_to', [$this->params['dateFrom'], $this->params['dateTo']]);
			});

		// Если указан фильтр по тегам то дополняем условием
		if (!empty($this->params['tagIds'])) {
			$dataQuery->whereHas('passwordCity.password.tags', function (Builder $query) {
				$query->whereIn('tag_id', $this->params['tagIds']);
			});
		} else {
			// отсеиваем удаленные пароли
			$dataQuery->whereHas('passwordCity.password');
		}

		// выборка
		$data = $dataQuery->get();

		$this->items = $data->groupBy(function (PasswordCityData $passwordCityData) {
			$slug = $passwordCityData->passwordCity->password->id . '=' . $passwordCityData->date_from;

			return $slug;
		})->map(function (Collection $items) {
			$first = $items->first();

			return [
				'passwordName' => $first->passwordCity->password->name,
				'tags'         => TextHelper::tagsForLabel($first->passwordCity->password),
				'dateFrom'     => $first->date_from,
				'dateTo'       => $first->date_to,
				'msk'          => $items->where('passwordCity.city.slug', 'msk')->sum('activations'),
				'spb'          => $items->where('passwordCity.city.slug', 'spb')->sum('activations'),
				'kzn'          => $items->where('passwordCity.city.slug', 'kzn')->sum('activations'),
				'che'          => $items->where('passwordCity.city.slug', 'che')->sum('activations'),
			];
		});
	}
}