<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProbesLog;
use App\Probe;
use Carbon\Carbon;

class ProbesLogsController extends Controller
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
        return ProbesLog::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProbesLogs(Request $request)
    { 
		return ProbesLog::with('probe')
				->orderBy('created_at','desc')->paginate(5);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProbesLogsByProbeID(Request $request)
    {
		$start = $request['start_date'] . " 00:00:00";
		$end = $request['end_date'] . " 23:59:59";
		$probe = $request['probe'];


		return ProbesLog::with('probe')
				->where('probe_id', $probe)
				->where('created_at', '>=', $start)
				->where('created_at', '<=', $end)
				->orderBy('created_at','desc')
				->paginate(25);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLatestLogs($organization)
    {	
		if($organization == 'All'){
			$latest_logs = Probe::select('id','name')->has('latest_log')->with('latest_log','max_temp_sensor_1','min_temp_sensor_1','max_temp_sensor_2','min_temp_sensor_2')->paginate(25);
		}
		else{
			$latest_logs = Probe::select('id','name')->has('latest_log')->with('latest_log','max_temp_sensor_1','min_temp_sensor_1','max_temp_sensor_2','min_temp_sensor_2')->where('organization_id', $organization)->paginate(25);
		}

		return $latest_logs;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLatestLogsByLocationID($location)
    {	
		$latest_logs = Probe::select('id','name')->has('latest_log')->with('latest_log','max_temp_sensor_1','min_temp_sensor_1','max_temp_sensor_2','min_temp_sensor_2')->where('location_id', $location)->paginate(25);
		
		return $latest_logs;
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
		$probes_logs = $request['data'];

		foreach($probes_logs as $key => $value) {
			$probe = Probe::where('serial_number', $probes_logs[$key]['probe_id'])->get()->first();
			$probes_logs[$key]['probe_id'] = $probe['id'];

			try{
				ProbesLog::create($probes_logs[$key]);
				$this->status = 'success';
			}
			catch(\Illuminate\Database\QueryException $ex){
				$this->status = 'error';
				$this->data = $ex->getMessage();	
			}
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
        return ProbesLog::with('probe')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProbesLog($id)
    {
        return ProbesLog::findOrFail($id);
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
			$probes_log = ProbesLog::findOrFail($id);
			$probes_log->update($request->all());
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
			ProbesLog::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
