<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribesComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes_components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subscribes_id');
            $table->unsignedInteger('components_id');
            $table->timestamps();
            $table->softDeletes();
            $table->index('subscribes_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribes_components');
    }
}
