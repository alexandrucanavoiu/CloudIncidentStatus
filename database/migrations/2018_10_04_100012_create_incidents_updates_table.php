<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentsUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('incidents_id');
            $table->unsignedInteger('incident_statuses_id');
            $table->unsignedInteger('component_statuses_id');
            $table->longText('incidents_description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('incidents_updates', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('incidents_updates', function (Blueprint $table) {
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
        Schema::dropIfExists('incidents_updates');
    }
}
