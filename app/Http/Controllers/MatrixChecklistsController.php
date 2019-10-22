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
		return MatrixChecklist::with('organization','user')
		->orderBy('created_at','desc')->paginate(5);
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
