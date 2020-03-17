<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CorrectiveAction extends Model
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'organization_id',
		'user_id',
		'comment_type',
		'created_by',
		'updated_by',
	];

	public function organization()
	{
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
