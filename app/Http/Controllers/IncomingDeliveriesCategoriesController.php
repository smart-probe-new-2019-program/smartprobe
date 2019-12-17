<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncomingDeliveriesCategory;

class IncomingDeliveriesCategoriesController extends Controller
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
        return IncomingDeliveriesCategory::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingDeliveriesCategories(Request $request)
    { 
		$organization_id = $request['organization_id'];

		$incoming_deliveries_categories = IncomingDeliveriesCategory::with('organization');

		if($organization_id){
			$incoming_deliveries_categories = $incoming_deliveries_categories->where('organization_id', $organization_id);
		}
		
		$incoming_deliveries_categories = $incoming_deliveries_categories->orderBy('created_at','desc')->paginate(5);

		return $incoming_deliveries_categories;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesCategoriesForDropdown()
    {
		return IncomingDeliveriesCategory::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesCategoriesByOrganizationID($id)
    {
		return IncomingDeliveriesCategory::with('organization')->where('organization_id', $id)->get();
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
			IncomingDeliveriesCategory::create($request->all());
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
        return IncomingDeliveriesCategory::with('organization')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesCategory($id)
    {
        return IncomingDeliveriesCategory::findOrFail($id);
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
			$incoming_deliveries_category = IncomingDeliveriesCategory::findOrFail($id);
			$incoming_deliveries_category->update($request->all());
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
			IncomingDeliveriesCategory::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
