<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectiveActionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('corrective_actions');
		Schema::create('corrective_actions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('organization_id');
			$table->integer('user_id');
			$table->string('comment_type');
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
		Schema::dropIfExists('corrective_actions');
	}
}
