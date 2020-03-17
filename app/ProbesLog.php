<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProbesLog extends Model
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'probe_id',
		'temperature_high',
		'temperature_low',
		'status_1',
		'status_2',
		'trip_1',
		'trip_2',
		'voltage',
		'latitude',
		'longitude',
		'humidity_min',
		'humidity_max',
		'product_code',
		'setpoint',
		'range',
		'actual_temperature',
		'action',
		'created_by',
		'updated_by',
	];

	public function probe()
	{
		return $this->belongsTo('App\Probe', 'probe_id');
	}
}
