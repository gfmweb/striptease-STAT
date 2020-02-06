<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUserTargetDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('project_data','user_target_data');
        Schema::table('user_target_data', function (Blueprint $table) {
            $table->dropColumn('channel_id');
            $table->dropColumn('sub_project_id');
            $table->bigInteger('user_target_id')->unsigned(true)->comment('id из таблицы user_targets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('user_target_data','project_data');
        Schema::table('project_data', function (Blueprint $table) {
            $table->dropColumn('user_target_id');
            $table->bigInteger('channel_id')->unsigned(true);
            $table->bigInteger('sub_project_id')->unsigned(true);
        });
    }
}
