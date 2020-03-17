<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'organization_id',
		'location_id', 
		'type',
		'value',
		'created_by',
		'updated_by'
	];
	
	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function location() {
		return $this->belongsTo('App\Location', 'location_id');
	}
}
