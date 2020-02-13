<?php

use App\UserTarget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;

class ClearBaseFromBadRows extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function up()
	{
		DB::transaction(function (){
			\App\SubProject::query()->whereDoesntHave('project')->delete();
			\App\UserSubProject::query()->whereDoesntHave('user')->delete();
			\App\UserSubProject::query()->whereDoesntHave('subProject')->delete();
			\App\UserTarget::query()->whereDoesntHave('userSubProject')->delete();
			\App\UserTarget::query()->whereDoesntHave('channel')->delete();
			\App\UserTargetData::query()->whereDoesntHave('userTarget')->delete();
			\App\StatusHistory::query()->whereDoesntHave('userTarget')->delete();
			\App\StatusHistory::query()->whereDoesntHave('userTarget')->delete();
			\App\StatusHistory::query()->whereDoesntHave('status')->delete();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
