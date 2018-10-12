<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('component_groups_id');
            $table->unsignedInteger('component_statuses_id');
            $table->string('component_name');
            $table->integer('component_description')->nullable();
            $table->string('position')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('components', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('components', function (Blueprint $table) {
            $table->foreign('component_groups_id')->references('id')->on('component_groups');
        });

        Schema::table('components', function (Blueprint $table) {
            $table->foreign('component_statuses_id')->references('id')->on('component_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
}
