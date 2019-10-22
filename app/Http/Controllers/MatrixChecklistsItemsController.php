<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MatrixChecklistsItem;

class MatrixChecklistsItemsController extends Controller
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
        return MatrixChecklistsItem::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllMatrixChecklistsItems(Request $request)
    { 
		return MatrixChecklistsItem::with('matrix_daily_checklist','manage_checklist')
		->orderBy('created_at','desc')->paginate(5);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklistsItemsForDropdown()
    {
		return MatrixChecklistsItem::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklistsItemsByMatrixChecklistsID($id)
    {
		return MatrixChecklistsItem::with('matrix_checklist','manage_checklist','manage_checklist.organization','manage_checklist.area','manage_checklist.time','manage_checklist.item')->where('matrix_checklist_id', $id)->get();
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
			$matrix_checklists_id = $request['matrix_checklists_id'];
			$checked_items = $request['checkedItems'];
			$unchecked_items = $request['uncheckedItems'];
			$created_by = $request['created_by'];
			$updated_by = $request['updated_by'];
			
			foreach($checked_items as $key => $value) {
				$matrix_checklists_item = new MatrixChecklistsItem;
				$matrix_checklists_item->matrix_checklist_id = $matrix_checklists_id;
				$matrix_checklists_item->manage_checklist_id = $checked_items[$key]['id'];
				$matrix_checklists_item->value = 'Checked';
				$matrix_checklists_item->created_by = $created_by;
				$matrix_checklists_item->updated_by = $updated_by;

				$matrix_checklists_item->save();
			}

			foreach($unchecked_items as $key => $value) {
				$matrix_checklists_item = new MatrixChecklistsItem;
				$matrix_checklists_item->matrix_checklist_id = $matrix_checklists_id;
				$matrix_checklists_item->manage_checklist_id = $unchecked_items[$key]['id'];
				$matrix_checklists_item->value = 'Unchecked';
				$matrix_checklists_item->created_by = $created_by;
				$matrix_checklists_item->updated_by = $updated_by;

				$matrix_checklists_item->save();
			}
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
        return MatrixChecklistsItem::with('matrix_checklist','manage_checklist')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMatrixChecklistItem($id)
    {
        return MatrixChecklistsItem::findOrFail($id);
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
			$matrix_checklists_item = MatrixChecklistsItem::findOrFail($id);
			$matrix_checklists_item->update($request->all());
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
			MatrixChecklistsItem::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
