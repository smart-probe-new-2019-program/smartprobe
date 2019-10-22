<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class IncomingDelivery extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'organization_id',
		'item_id', 
		'user_id',
		'supplier_id',
		'category_id',
		'type_of_product_id', 
		'tested_time',
		'package_intact',
		'batch_number',
		'comment', 
		'corrective_action_id',
		'probe_id',
		'current_temperature',
		'current_temperature_unit',
		'status',
		'created_by',
		'updated_by',
	];
	
	public function organization() {
		return $this->belongsTo('App\Organization', 'organization_id');
	}

	public function item() {
		return $this->belongsTo('App\IncomingDeliveriesItem', 'item_id');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function supplier() {
		return $this->belongsTo('App\Supplier', 'supplier_id');
	}

	public function category() {
		return $this->belongsTo('App\IncomingDeliveriesCategory', 'category_id');
	}

	public function type_of_product() {
		return $this->belongsTo('App\IncomingDeliveriesTypeOfProduct', 'type_of_product_id');
	}

	public function corrective_action() {
		return $this->belongsTo('App\IncomingDeliveriesCorrectiveAction', 'corrective_action_id');
	}

	public function probe() {
		return $this->belongsTo('App\Probe', 'probe_id');
	}
}
