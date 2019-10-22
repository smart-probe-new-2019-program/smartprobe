<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StaffDailyChecklistsItem extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'staff_daily_checklist_id',
		'manage_checklist_id',
		'value',
		'created_by',
		'updated_by',
	];
	
	public function staff_daily_checklist() {
		return $this->belongsTo('App\StaffDailyChecklist', 'staff_daily_checklist_id');
	}

	public function manage_checklist() {
		return $this->belongsTo('App\ManageChecklist', 'manage_checklist_id');
	}
}
