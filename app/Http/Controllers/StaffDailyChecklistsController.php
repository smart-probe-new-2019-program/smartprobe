<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StaffDailyChecklist;
use App\StaffDailyChecklistsItem;

class StaffDailyChecklistsController extends Controller
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
        return StaffDailyChecklist::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllStaffDailyChecklists(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$user_id = $request['user_id'];
		$start_date = $request['start_date'] . ' 00:00:00';
		$end_date = $request['end_date'] . ' 23:59:59';
		
		$staff_daily_checklists = StaffDailyChecklist::with('organization','user');

		if($organization_id != 'All'){
			$staff_daily_checklists = $staff_daily_checklists->where('organization_id', $organization_id);
		}

		if($user_id){
			$staff_daily_checklists = $staff_daily_checklists->where('created_by', $user_id);
		}

		if($start_date <= $end_date){
			$staff_daily_checklists = $staff_daily_checklists
			->where('created_at', '>=', $start_date)
			->where('created_at', '<=', $end_date);
		}
		
		$staff_daily_checklists = $staff_daily_checklists->orderBy('created_at','desc')->paginate(100);

		return $staff_daily_checklists;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStaffDailyChecklistsForDropdown()
    {
		return StaffDailyChecklist::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStaffDailyChecklistsByOrganizationID($id)
    {
		return StaffDailyChecklist::with('organization','user')->where('organization_id', $id)->get();
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
			$staff_daily_checklist = StaffDailyChecklist::create($request->all());
			$this->status = 'success';
			$this->data = $staff_daily_checklist;
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
        return StaffDailyChecklist::with('organization','user')->findOrFail($id);
    }

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getStaffDailyChecklist($id)
    {
        return StaffDailyChecklist::findOrFail($id);
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
			$staff_daily_checklist = StaffDailyChecklist::findOrFail($id);
			$staff_daily_checklist->update($request->all());
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
			StaffDailyChecklistsItem::where('staff_daily_checklist_id', $id)->delete();
			StaffDailyChecklist::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
