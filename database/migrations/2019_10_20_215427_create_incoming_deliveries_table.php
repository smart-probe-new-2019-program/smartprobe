<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('incoming_deliveries');
        Schema::create('incoming_deliveries', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('organization_id');
			$table->integer('item_id');
			$table->integer('user_id');
			$table->integer('supplier_id');
			$table->integer('category_id');
			$table->integer('type_of_product_id');
			$table->string('tested_time');
			$table->string('package_intact');
			$table->string('batch_number');
			$table->text('comment');
			$table->integer('corrective_action_id');
			$table->integer('probe_id');
			$table->string('current_temperature');
			$table->string('current_temperature_unit');
			$table->string('status');
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
        Schema::dropIfExists('incoming_deliveries');
    }
}
