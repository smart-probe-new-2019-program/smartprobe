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
		$start = Carbon::now()->toDateString() . ' 00:00:00';
		$end = Carbon::now()->toDateString() . ' 23:59:59';

		if($organization == 'All'){
			$latest_logs = Probe::selectRaw('probes.id as probe_id, 
				probes.name as probe_name,
				MAX(CAST(probes_logs.temperature_high as DECIMAL(18,1))) as max_temperature_high,  
				MIN(CAST(probes_logs.temperature_high as DECIMAL(18,1))) as min_temperature_high, 
				MAX(CAST(probes_logs.temperature_low as DECIMAL(18,1))) as max_temperature_low, 
				MIN(CAST(probes_logs.temperature_low as DECIMAL(18,1))) as min_temperature_low')
				->join('probes_logs', function ($q) {
					$q->on('probes.id', '=', 'probes_logs.probe_id');
				});

			$latest_logs = $latest_logs->groupBy('probes.id')
						->paginate(25);
			
			foreach ($latest_logs as $key => $value) {
				$probe_id = $latest_logs[$key]['probe_id'];
				$latest_log = ProbesLog::where('probe_id', $probe_id)->orderBy('id','desc')->limit(1)->get();
				$value->latest_log = $latest_log[0];
			}
		}
		else{
			$latest_logs = Probe::selectRaw('probes.id as probe_id, 
				probes.name as probe_name,
				MAX(CAST(probes_logs.temperature_high as DECIMAL(18,1))) as max_temperature_high,  
				MIN(CAST(probes_logs.temperature_high as DECIMAL(18,1))) as min_temperature_high, 
				MAX(CAST(probes_logs.temperature_low as DECIMAL(18,1))) as max_temperature_low, 
				MIN(CAST(probes_logs.temperature_low as DECIMAL(18,1))) as min_temperature_low')
				->join('probes_logs', function ($q) {
					$q->on('probes.id', '=', 'probes_logs.probe_id');
				});

			$latest_logs = $latest_logs
						->where('probes.organization_id', $organization)
						->groupBy('probes.id')
						->paginate(25);
			
			foreach ($latest_logs as $key => $value) {
				$probe_id = $latest_logs[$key]['probe_id'];
				$latest_log = ProbesLog::where('probe_id', $probe_id)->orderBy('id','desc')->limit(1)->get();
				$value->latest_log = $latest_log[0];
			}
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
		$start = Carbon::now()->toDateString() . ' 00:00:00';
		$end = Carbon::now()->toDateString() . ' 23:59:59';
		
		$latest_logs = Probe::selectRaw('probes.id as probe_id, 
				probes.name as probe_name,
				MAX(CAST(probes_logs.temperature_high as DECIMAL(18,1))) as max_temperature_high,  
				MIN(CAST(probes_logs.temperature_high as DECIMAL(18,1))) as min_temperature_high, 
				MAX(CAST(probes_logs.temperature_low as DECIMAL(18,1))) as max_temperature_low, 
				MIN(CAST(probes_logs.temperature_low as DECIMAL(18,1))) as min_temperature_low')
				->join('probes_logs', function ($q) {
					$q->on('probes.id', '=', 'probes_logs.probe_id');
				});

			$latest_logs = $latest_logs->where('probes.location_id', $location)
						->groupBy('probes.id')
						->paginate(25);
			
			foreach ($latest_logs as $key => $value) {
				$latest_log = Probe::with('latest_log')->whereHas('latest_log')->get();
				$value->latest_log = $latest_log[0]['latest_log'];
			}
		
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
