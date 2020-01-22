<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncomingDeliveriesItem;

class IncomingDeliveriesItemsController extends Controller
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
        return IncomingDeliveriesItem::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingDeliveriesItems(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$filter_keyword = $request['filter_keyword'];

		$items = IncomingDeliveriesItem::with('organization');

		if($organization_id != 'All'){
			$items = $items->where('organization_id', $organization_id);
		}

		if($filter_keyword != 'null'){
			$items = $items->where(function($q) use ($filter_keyword) {
				$q->where('name', 'LIKE', '%'.$filter_keyword.'%');
			});
		}
		
		$items = $items->orderBy('created_at','desc')->paginate(100);

		return $items;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesItemsForDropdown()
    {
		return IncomingDeliveriesItem::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesItemsByOrganizationID($id)
    {
		return IncomingDeliveriesItem::with('organization')->where('organization_id', $id)->get();
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
			IncomingDeliveriesItem::create($request->all());
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
        return IncomingDeliveriesItem::with('organization')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesItem($id)
    {
        return IncomingDeliveriesItem::findOrFail($id);
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
			$incoming_deliveries_item = IncomingDeliveriesItem::findOrFail($id);
			$incoming_deliveries_item->update($request->all());
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
			IncomingDeliveriesItem::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
