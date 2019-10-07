<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('locations');
        Schema::create('locations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('organization_id');
			$table->string('name');
			$table->string('address');
			$table->string('city');
			$table->string('country');
			$table->string('state')->nullable();
			$table->string('zip_code')->nullable();
			$table->string('email');
			$table->string('office_phone')->nullable();
			$table->string('office_fax')->nullable();
			$table->string('mobile_phone')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
