<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MatrixChecklist;
use App\MatrixChecklistsItem;

class MatrixChecklistsController extends Controller
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
        return MatrixChecklist::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllMatrixChecklists(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$user_id = $request['user_id'];
		$start_date = $request['start_date'] . ' 00:00:00';
		$end_date = $request['end_date'] . ' 23:59:59';

		$matrix_checklists = MatrixChecklist::with('organization','user');

		if($organization_id != 'All'){
			$matrix_checklists = $matrix_checklists->where('organization_id', $organization_id);
		}

		if($user_id){
			$matrix_checklists = $matrix_checklists->where('created_by', $user_id);
		}

		if($start_date <= $end_date){
			$matrix_checklists = $matrix_checklists
			->where('created_at', '>=', $start_date)
			->where('created_at', '<=', $end_date);
		}
		
		$matrix_checklists = $matrix_checklists->orderBy('created_at','desc')->paginate(100);

		return $matrix_checklists;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklistsForDropdown()
    {
		return MatrixChecklist::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklistsByOrganizationID($id)
    {
		return MatrixChecklist::with('organization','user')->where('organization_id', $id)->get();
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
			$matrix_checklist = MatrixChecklist::create($request->all());
			$this->status = 'success';
			$this->data = $matrix_checklist;
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
        return MatrixChecklist::with('organization','user')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklist($id)
    {
        return MatrixChecklist::findOrFail($id);
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
			$matrix_checklist = MatrixChecklist::findOrFail($id);
			$matrix_checklist->update($request->all());
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
			MatrixChecklistsItem::where('matrix_checklist_id', $id)->delete();
			MatrixChecklist::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
