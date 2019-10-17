<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ManageChecklist extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'type',
		'organization_id', 
		'time_id',
		'area_id', 
		'day_of_the_week',
		'category_id',
		'item_id',
		'created_by',
		'updated_by',
	];
	
	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function time() {
		return $this->belongsTo('App\ChecklistTime', 'time_id');
	}

	public function area() {
		return $this->belongsTo('App\ChecklistArea', 'area_id');
	}

	public function category() {
		return $this->belongsTo('App\ChecklistCategory', 'category_id');
	}

	public function item() {
		return $this->belongsTo('App\ChecklistItem', 'item_id');
	}
}
