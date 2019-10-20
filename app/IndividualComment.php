<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class IndividualComment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'corrective_action_id',
		'probe_id', 
		'comment',
		'created_by',
		'updated_by',
	];
	
	public function corrective_action() {
		return $this->belongsTo('App\CorrectiveAction', 'corrective_action_id');
	}

	public function probe() {
		return $this->belongsTo('App\Probe', 'probe_id');
	}
}
