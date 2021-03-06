<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Probe;

class ProbesController extends Controller
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
        return Probe::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProbes(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$filter_keyword = $request['filter_keyword'];
		$filter_status = $request['filter_status'];
		$location_id = $request['location_id'];

		$probes = Probe::with('organization','location');

		if($organization_id != 'All'){
			$probes = $probes->where('organization_id', $organization_id);
		}

		if($location_id){
			$probes = $probes->where('location_id', $location_id);
		}

		if($filter_keyword != 'null'){
			$probes = $probes->where(function($q) use ($filter_keyword) {
				$q->where('name', 'LIKE', '%'.$filter_keyword.'%');
				$q->where('serial_number', 'LIKE', '%'.$filter_keyword.'%');
			});
		}

		if($filter_status != 'All'){
			$probes = $probes->where('status', $filter_status);
		}
		
		$probes = $probes->orderBy('created_at','desc')->paginate(100);

		return $probes;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProbesForDropdown()
    {
		return Probe::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProbesByOrganizationID($id)
    {
		return Probe::with('organization','location')->where('organization_id', $id)->get();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProbesByLocationID($id)
    {
		return Probe::with('organization','location')->where('location_id', $id)->get();
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
		if($request['next_calibration_date']){
			$request['next_calibration_date'] = date("Y-m-d", strtotime($request['next_calibration_date']));
		}
		
		if($request['online_monitoring_date']){
			$request['online_monitoring_date'] = date("Y-m-d", strtotime($request['online_monitoring_date']));
		}
		
        try{
			Probe::create($request->all());
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
        return Probe::with('organization','location')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProbe($id)
    {
        return Probe::findOrFail($id);
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
		if($request['next_calibration_date']){
			$request['next_calibration_date'] = date("Y-m-d", strtotime($request['next_calibration_date']));
		}
		
		if($request['online_monitoring_date']){
			$request['online_monitoring_date'] = date("Y-m-d", strtotime($request['online_monitoring_date']));
		}
		
        try{
			$probe = Probe::findOrFail($id);
			$probe->update($request->all());
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
			Probe::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
