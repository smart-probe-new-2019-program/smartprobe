<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Organization extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name', 
		'description', 
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
}
