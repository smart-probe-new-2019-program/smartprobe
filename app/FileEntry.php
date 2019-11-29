<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FileEntry extends Model
{
	use Notifiable;

	protected $fillable = [
		'organization_id', 
		'filename', 
		'mime', 
		'path', 
		'size', 
		'created_by', 
		'updated_by'
	];
	
	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}
}
