<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Probe extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'serial_number',
		'name',
		'cooling_device',
		'temperature_unit',
		'temperature_warning_high',
		'temperature_warning_low',
		'temperature_alert_high',
		'temperature_alert_low',
		'minimum_voltage',
		'probe_type',
		'last_calibration_date',
		'next_calibration_date',
		'frequency_to_check_temperatures_value',
		'frequency_to_check_temperatures_unit',
		'alarm_time_value',
		'alarm_time_unit',
		'default_sensor',
		'organization_id',
		'location_id',
		'status',
		'is_configured',
		'is_monitored',
		'online_monitoring_probe_id',
		'online_monitoring_date',
		'created_by',
		'updated_by',
	];

	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function location() {
		return $this->belongsTo('App\Location', 'location_id');
	}
}
