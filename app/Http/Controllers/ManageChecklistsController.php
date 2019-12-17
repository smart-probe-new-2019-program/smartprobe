<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManageChecklist;

class ManageChecklistsController extends Controller
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
        return ManageChecklist::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllManageChecklists(Request $request)
    { 
		$organization_id = $request['organization_id'];

		$manage_checklists = ManageChecklist::with('organization','time','area','category','item');

		if($organization_id){
			$manage_checklists = $manage_checklists->where('organization_id', $organization_id);
		}
		
		$manage_checklists = $manage_checklists->orderBy('created_at','desc')->paginate(5);

		return $manage_checklists;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getManageChecklistsForDropdown()
    {
		return ManageChecklist::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChecklistItems(Request $request)
    {
		return ManageChecklist::with('item')
		->where('organization_id', $request['organization_id'])
		->where('area_id', $request['area_id'])
		->where('time_id', $request['time_id'])
		->orderBy('created_at','desc')
		->get();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklistItems(Request $request)
    {
		return ManageChecklist::with('item')
		->where('organization_id', $request['organization_id'])
		->where('area_id', $request['area_id'])
		->where('day_of_the_week', $request['day_of_the_week'])
		->orderBy('created_at','desc')
		->get();
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
			ManageChecklist::create($request->all());
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
        return ManageChecklist::with('organization','time','area','category','item')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getManageChecklist($id)
    {
        return ManageChecklist::findOrFail($id);
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
			$manage_checklist = ManageChecklist::findOrFail($id);
			$manage_checklist->update($request->all());
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
			ManageChecklist::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
