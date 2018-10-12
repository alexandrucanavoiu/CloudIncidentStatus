<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('time_zone_interface');
            $table->string('title_app');
            $table->string('settings_logo');
            $table->integer('days_of_incidents');
            $table->integer('bulk_emails');
            $table->integer('bulk_emails_sleep');
            $table->string('queue_name_incidents');
            $table->string('queue_name_maintenance');
            $table->string('from_address');
            $table->string('from_name');
            $table->string('google_analytics_code')->nullable();
            $table->integer('allow_subscribers');
            $table->timestamps();
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
        Schema::dropIfExists('settings');
    }
}
