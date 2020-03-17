<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('alarm_logs');
        Schema::create('alarm_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('probe_id');
			$table->string('type');
			$table->string('action');
			$table->string('status');
			$table->text('response');
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
        Schema::dropIfExists('alarm_logs');
    }
}
