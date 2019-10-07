<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Location extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'organization_id',
		'name', 
		'address',
		'city', 
		'country',
		'state',
		'zip_code',
		'email',
		'office_phone',
		'office_fax',
		'mobile_phone',
		'created_by',
		'updated_by',
	];
	
	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}
}
