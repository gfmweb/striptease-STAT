<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCitySlugInCitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cities', function (Blueprint $table) {
			$table->string('slug', '3')->nullable(false);
		});

		\App\City::query()->where('name', 'Москва')->update(['slug' => 'msk']);
		\App\City::query()->where('name', 'Санкт-Петербург')->update(['slug' => 'spb']);
		\App\City::query()->where('name', 'Казань')->update(['slug' => 'kzn']);
		\App\City::query()->where('name', 'Чебоксары')->update(['slug' => 'che']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cities', function (Blueprint $table) {
			$table->dropColumn('slug');
		});
	}
}
