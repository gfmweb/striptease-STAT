<?php

use Illuminate\Database\Seeder;

class AddVargo extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->info('Vargo connected...');
		if (\App\User::query()->where('name', 'Vargo')->exists()) {
			$this->command->info('Vargo already exists!');
		} else {
			$vargo           = new \App\User();
			$vargo->name     = 'Vargo';
			$vargo->login    = 'vargo';
			$vargo->password = bcrypt('7654321');
			$vargo->save();
			$this->command->info('Vargo created!');
		}

	}
}
