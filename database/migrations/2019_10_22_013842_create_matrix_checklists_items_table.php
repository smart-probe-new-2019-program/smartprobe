<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatrixChecklistsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('matrix_checklists_items');
        Schema::create('matrix_checklists_items', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('matrix_checklist_id');
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
        Schema::dropIfExists('matrix_checklists_items');
    }
}
