<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordCityDataTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('password_city_data', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('password_city_id')->unsigned()->nullable(false);
			$table->integer('activations')->unsigned()->default(0);
			$table->date('date_from')->nullable(false);
			$table->date('date_to')->nullable(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('password_city_data');
	}
}
