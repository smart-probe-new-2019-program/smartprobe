<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualCommentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('individual_comments');
		Schema::create('individual_comments', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('corrective_action_id');
			$table->integer('probe_id');
			$table->text('comment');
			$table->string('current_temperature')->nullable();
			$table->string('max_temperature')->nullable();
			$table->string('min_temperature')->nullable();
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
		Schema::dropIfExists('individual_comments');
	}
}
