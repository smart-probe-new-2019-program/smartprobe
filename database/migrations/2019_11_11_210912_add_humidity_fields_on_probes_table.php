<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHumidityFieldsOnProbesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('probes', function (Blueprint $table) {
            $table->string('humidity_warning_high')->nullable();
			$table->string('humidity_warning_low')->nullable();
			$table->string('humidity_alert_high')->nullable();
			$table->string('humidity_alert_low')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('probes', function (Blueprint $table) {
			$table->dropColumn('humidity_warning_high');
			$table->dropColumn('humidity_warning_low');
			$table->dropColumn('humidity_alert_high');
			$table->dropColumn('humidity_alert_low');
        });
    }
}
