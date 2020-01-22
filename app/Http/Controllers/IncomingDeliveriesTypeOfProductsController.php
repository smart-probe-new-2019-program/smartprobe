<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncomingDeliveriesTypeOfProduct;

class IncomingDeliveriesTypeOfProductsController extends Controller
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
        return IncomingDeliveriesTypeOfProduct::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingDeliveriesTypeOfProducts(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$filter_keyword = $request['filter_keyword'];

		$incoming_deliveries_type_of_products = IncomingDeliveriesTypeOfProduct::with('organization');

		if($organization_id != 'All'){
			$incoming_deliveries_type_of_products = $incoming_deliveries_type_of_products->where('organization_id', $organization_id);
		}

		if($filter_keyword != 'null'){
			$incoming_deliveries_type_of_products = $incoming_deliveries_type_of_products->where(function($q) use ($filter_keyword) {
				$q->where('name', 'LIKE', '%'.$filter_keyword.'%');
			});
		}
		
		$incoming_deliveries_type_of_products = $incoming_deliveries_type_of_products->orderBy('created_at','desc')->paginate(100);

		return $incoming_deliveries_type_of_products;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesTypeOfProductsForDropdown()
    {
		return IncomingDeliveriesTypeOfProduct::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesTypeOfProductsByOrganizationID($id)
    {
		return IncomingDeliveriesTypeOfProduct::with('organization')->where('organization_id', $id)->get();
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
			IncomingDeliveriesTypeOfProduct::create($request->all());
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
        return IncomingDeliveriesTypeOfProduct::with('organization')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getIncomingDeliveriesTypeOfProduct($id)
    {
        return IncomingDeliveriesTypeOfProduct::findOrFail($id);
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
			$incoming_deliveries_type_of_product = IncomingDeliveriesTypeOfProduct::findOrFail($id);
			$incoming_deliveries_type_of_product->update($request->all());
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
			IncomingDeliveriesTypeOfProduct::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
