<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CookChillCheck extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'supplier_id', 
		'type_of_food_id',
		'start_time',
		'end_time', 
		'batch_number',
		'comment',
		'organization_id', 
		'probe_id',
		'created_by',
		'updated_by',
	];
	
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'supplier_id');
	}

	public function typeOfFood() {
		return $this->belongsTo('App\TypeOfFood', 'type_of_food_id');
	}

	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function probe() {
		return $this->belongsTo('App\Probe', 'probe_id');
	}
}
