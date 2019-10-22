<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncomingDeliveriesCorrectiveAction;

class IncomingDeliveriesCorrectiveActionsController extends Controller
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
        return IncomingDeliveriesCorrectiveAction::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingDeliveriesCorrectiveActions(Request $request)
    { 
		return IncomingDeliveriesCorrectiveAction::with('organization')
		->orderBy('created_at','desc')->paginate(5);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesCorrectiveActionsForDropdown()
    {
		return IncomingDeliveriesCorrectiveAction::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesCorrectiveActionsByOrganizationID($id)
    {
		return IncomingDeliveriesCorrectiveAction::with('organization')->where('organization_id', $id)->get();
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
			IncomingDeliveriesCorrectiveAction::create($request->all());
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
        return IncomingDeliveriesCorrectiveAction::with('organization')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesCorrectiveAction($id)
    {
        return IncomingDeliveriesCorrectiveAction::findOrFail($id);
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
			$incoming_deliveries_corrective_action = IncomingDeliveriesCorrectiveAction::findOrFail($id);
			$incoming_deliveries_corrective_action->update($request->all());
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
			IncomingDeliveriesCorrectiveAction::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
