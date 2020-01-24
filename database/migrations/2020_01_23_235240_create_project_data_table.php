<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('channel_id');
            $table->integer('sub_project_id');
            $table->integer('coverage');
            $table->integer('transition');
            $table->integer('clicks');
            $table->integer('leads');
            $table->integer('activations');
            $table->decimal('price', 6,2);
            $table->date('date_from');
            $table->date('date_to');
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
        Schema::dropIfExists('project_data');
    }
}
