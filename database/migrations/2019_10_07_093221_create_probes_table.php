<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProbesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('probes');
        Schema::create('probes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('serial_number');
			$table->string('name');
			$table->string('cooling_device');
			$table->string('temperature_unit');
			$table->string('temperature_warning_high');
			$table->string('temperature_warning_low');
			$table->string('temperature_alert_high');
			$table->string('temperature_alert_low');
			$table->string('minimum_voltage');
			$table->string('probe_type');
			$table->string('last_calibration_date')->nullable();
			$table->string('next_calibration_date')->nullable();
			$table->string('frequency_to_check_temperatures_value');
			$table->string('frequency_to_check_temperatures_unit');
			$table->string('alarm_time_value');
			$table->string('alarm_time_unit');
			$table->string('default_sensor');
			$table->integer('organization_id');
			$table->integer('location_id');
			$table->string('status');
			$table->string('is_configured');
			$table->string('is_monitored')->nullable();
			$table->string('online_monitoring_probe_id')->nullable();
			$table->string('online_monitoring_date')->nullable();
			$table->string('created_by');
			$table->string('updated_by');
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
        Schema::dropIfExists('probes');
    }
}
