<?php

use Illuminate\Database\Seeder;

class AddCities extends Seeder
{

	private $cities = [
		'Москва',
		'Санкт-Петербург',
		'Казань',
		'Чебоксары',
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->info('Cities seeding...');
		foreach ($this->cities as $city) {
			if (\App\City::query()->where('name', $city)->exists()) {
				$this->command->info($city . ' already exists!');
			} else {
				\App\City::query()->create([
					'name' => $city
				]);
				$this->command->info($city . ' created!');
			}
		}


	}
}
