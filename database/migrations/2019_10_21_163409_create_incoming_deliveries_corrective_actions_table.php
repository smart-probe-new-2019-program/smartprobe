<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingDeliveriesCorrectiveActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('incoming_deliveries_corrective_actions');
        Schema::create('incoming_deliveries_corrective_actions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('organization_id');
			$table->string('name');
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
        Schema::dropIfExists('incoming_deliveries_corrective_actions');
    }
}
