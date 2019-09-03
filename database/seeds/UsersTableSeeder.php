<?php
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
			'first_name' => 'James', 
			'last_name' => 'Admin', 
			'full_name' => 'James Admin',
			'email' => 'james@smartprobe.com.au', 
			'username' => 'jamesadmin',
			'password' => bcrypt('123456'),
			'role' => 'super_admin',
			'last_ip_address' => '',
			'last_login_date' => '',
			'status' => 'active',
			'organization_id' => '0',
			'created_by' => '1',
			'updated_by' => '1',
        ]);
    }
}
