<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('full_name');
			$table->string('email')->unique();
			$table->string('username')->unique();
            $table->string('password');
			$table->string('role')->default('super_admin');
			$table->string('last_ip_address')->nullable();
			$table->string('last_login_date')->nullable();
			$table->string('status')->default('active');
			$table->integer('organization_id');
			$table->integer('created_by');
			$table->integer('updated_by');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
