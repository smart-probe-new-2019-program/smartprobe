<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('file_entries');
        Schema::create('file_entries', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('organization_id');
            $table->string('filename');
            $table->string('mime');
            $table->string('path');
			$table->integer('size');
			$table->integer('created_by');
			$table->integer('updated_by');
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
        Schema::dropIfExists('file_entries');
    }
}
