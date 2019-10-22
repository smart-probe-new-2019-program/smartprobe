<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCookChillChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('cook_chill_checks');
        Schema::create('cook_chill_checks', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('supplier_id');
			$table->integer('type_of_food_id');
			$table->string('start_time');
			$table->string('end_time');
			$table->string('batch_number');
			$table->text('comment');
			$table->integer('organization_id');
			$table->integer('probe_id');
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
        Schema::dropIfExists('cook_chill_checks');
    }
}
