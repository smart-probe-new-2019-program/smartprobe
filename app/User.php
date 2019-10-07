<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'first_name', 
		'last_name', 
		'full_name',
		'email', 
		'username',
		'password',
		'role',
		'organization_id',
		'location_id',
		'last_ip_address',
		'last_login_date',
		'status',
		'created_by',
		'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
	];
	
	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function location() {
		return $this->belongsTo('App\Location', 'location_id');
	}
}
