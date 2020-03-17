<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AlarmLog extends Model
{
	use Notifiable;
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'probe_id',
		'type', 
		'action',
		'status',
		'response'
	];
	
	public function probe() {
		return $this->belongsTo('App\Probe', 'probe_id');
	}
}
