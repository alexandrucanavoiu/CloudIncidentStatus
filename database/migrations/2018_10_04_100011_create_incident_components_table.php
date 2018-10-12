<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('incidents_id');
            $table->unsignedInteger('components_id');
            $table->integer('component_statuses_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('incident_components', function (Blueprint $table) {
            $table->foreign('incidents_id')->references('id')->on('incidents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident_components');
    }
}
