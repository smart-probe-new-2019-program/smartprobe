<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncomingDelivery;

class IncomingDeliveriesController extends Controller
{
	private $status;
	private $data;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IncomingDelivery::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingDeliveries(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$user_id = $request['user_id'];
		$start_date = $request['start_date'] . ' 00:00:00';
		$end_date = $request['end_date'] . ' 23:59:59';

		$incoming_deliveries = IncomingDelivery::with('organization','item','user','supplier','category','type_of_product','corrective_action','probe');

		if($organization_id != 'All') {
			$incoming_deliveries = $incoming_deliveries->where('organization_id', $organization_id);
		}

		if($user_id){
			$incoming_deliveries = $incoming_deliveries->where('created_by', $user_id);
		}

		if($start_date <= $end_date){
			$incoming_deliveries = $incoming_deliveries
			->where('created_at', '>=', $start_date)
			->where('created_at', '<=', $end_date);
		}
		
		$incoming_deliveries = $incoming_deliveries->orderBy('created_at','desc')->paginate(100);

		return $incoming_deliveries;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesForDropdown()
    {
		return IncomingDelivery::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesByOrganizationID($id)
    {
		return IncomingDelivery::with('organization','item','user','supplier','category','type_of_product','corrective_action','probe')->where('organization_id', $id)->get();
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
			IncomingDelivery::create($request->all());
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();	
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return IncomingDelivery::with('organization','item','user','supplier','category','type_of_product','corrective_action','probe')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDelivery($id)
    {
        return IncomingDelivery::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
			$incoming_delivery = IncomingDelivery::findOrFail($id);
			$incoming_delivery->update($request->all());
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
			IncomingDelivery::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
