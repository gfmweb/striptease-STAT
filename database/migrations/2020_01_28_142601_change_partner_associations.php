<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePartnerAssociations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('partner_id');
        });

        Schema::table('sub_projects', function (Blueprint $table) {
            $table->bigInteger('partner_id')->unsigned()->nullable()->comment('Исполнитель');
        });

        \App\SubProject::query()->update(['partner_id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->bigInteger('partner_id')->unsigned()->nullable()->comment('Исполнитель');
        });

        Schema::table('sub_projects', function (Blueprint $table) {
            $table->dropColumn('partner_id');
        });
    }
}
