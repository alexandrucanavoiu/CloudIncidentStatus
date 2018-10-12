<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_maintenance_sent', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subscribes_id');
            $table->unsignedInteger('scheduled_id');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });

//        Schema::table('scheduled_maintenance_sent', function (Blueprint $table) {
//            $table->foreign('subscribes_id')->references('id')->on('subscribes');
//        });

//        Schema::table('scheduled_maintenance_sent', function (Blueprint $table) {
//            $table->foreign('scheduled_id')->references('id')->on('scheduled_maintenances')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_maintenance_sent');
    }
}
