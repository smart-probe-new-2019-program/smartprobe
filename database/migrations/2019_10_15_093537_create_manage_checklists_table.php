<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('manage_checklists');
        Schema::create('manage_checklists', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->integer('organization_id');
			$table->integer('time_id')->nullable();
			$table->integer('area_id');
			$table->string('day_of_the_week')->nullable();
			$table->integer('category_id')->nullable();
			$table->integer('item_id');
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
        Schema::dropIfExists('manage_checklists');
    }
}
