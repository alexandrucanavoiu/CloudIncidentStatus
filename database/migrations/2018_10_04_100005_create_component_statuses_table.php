<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('component_status_name', 255)->comment("#1 Always expanded, #2 Collapse the group by default, #3 Collapse the group, but expand if there are issues");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_statuses');
    }
}
