<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveSoftDeleteFromAll extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function up()
	{
		DB::transaction(function () {
			\App\Channel::query()->onlyTrashed()->forceDelete();
			\App\SubProject::query()->onlyTrashed()->forceDelete();
			\App\Project::query()->onlyTrashed()->forceDelete();

			Schema::table('channels', function (Blueprint $table) {
				$table->dropSoftDeletes();
			});
			Schema::table('sub_projects', function (Blueprint $table) {
				$table->dropSoftDeletes();
			});
			Schema::table('projects', function (Blueprint $table) {
				$table->dropSoftDeletes();
			});
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function down()
	{
		DB::transaction(function () {
			Schema::table('channels', function (Blueprint $table) {
				$table->softDeletes();
			});
			Schema::table('sub_projects', function (Blueprint $table) {
				$table->softDeletes();
			});
			Schema::table('projects', function (Blueprint $table) {
				$table->softDeletes();
			});
		});
	}
}
