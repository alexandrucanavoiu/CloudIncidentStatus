<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledMaintenancesComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_maintenances_components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('scheduled_id');
            $table->unsignedInteger('components_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('scheduled_maintenances_components', function (Blueprint $table) {
            $table->foreign('scheduled_id')->references('id')->on('scheduled_maintenances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_maintenances_components');
    }
}
