<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MatrixChecklistsItem extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'matrix_checklist_id',
		'manage_checklist_id',
		'value',
		'created_by',
		'updated_by',
	];
	
	public function matrix_checklist() {
		return $this->belongsTo('App\MatrixChecklist', 'matrix_checklist_id');
	}

	public function manage_checklist() {
		return $this->belongsTo('App\ManageChecklist', 'manage_checklist_id');
	}
}
