<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(AddVargo::class);
		$this->call(AddTestUser::class);
		$this->call(AddCities::class);
		$this->call(AddChannels::class);
		$this->call(AddTestPartners::class);
		$this->call(AddTestProjects::class);
	}
}
