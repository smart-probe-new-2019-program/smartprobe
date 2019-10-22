<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffDailyChecklistsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('staff_daily_checklists_items');
        Schema::create('staff_daily_checklists_items', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('staff_daily_checklist_id');
			$table->integer('manage_checklist_id');
			$table->string('value');
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
        Schema::dropIfExists('staff_daily_checklists_items');
    }
}
