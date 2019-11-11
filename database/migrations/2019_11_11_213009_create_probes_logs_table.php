<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProbesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('probes_logs');
        Schema::create('probes_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('probe_id');
			$table->string('temperature_high')->nullable();
			$table->string('temperature_low')->nullable();
			$table->string('status_1')->nullable();
			$table->string('status_2')->nullable();
			$table->string('trip_1')->nullable();
			$table->string('trip_2')->nullable();
			$table->string('voltage')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
			$table->string('humidity_min')->nullable();
			$table->string('humidity_max')->nullable();
			$table->string('product_code')->nullable();
			$table->string('setpoint')->nullable();
			$table->string('range')->nullable();
			$table->string('actual_temperature')->nullable();
			$table->string('action')->nullable();
			$table->integer('created_by');
			$table->integer('updated_by');
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
        Schema::dropIfExists('probes_logs');
    }
}
