<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CookChillCheck;

class CookChillChecksController extends Controller
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
        return CookChillCheck::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCookChillChecks(Request $request)
    { 
		$organization_id = $request['organization_id'];
		$user_id = $request['user_id'];
		$start_date = $request['start_date'] . ' 00:00:00';
		$end_date = $request['end_date'] . ' 23:59:59';

		$cook_chill_checks = CookChillCheck::with('user','supplier','typeOfFood','organization','probe');

		if($organization_id != 'All') {
			$cook_chill_checks = $cook_chill_checks->where('organization_id', $organization_id);
		}

		if($user_id){
			$cook_chill_checks = $cook_chill_checks->where('created_by', $user_id);
		}
		
		if($start_date <= $end_date){
			$cook_chill_checks = $cook_chill_checks
			->where('created_at', '>=', $start_date)
			->where('created_at', '<=', $end_date);
		}

		$cook_chill_checks = $cook_chill_checks->orderBy('created_at','desc')->paginate(100);

		return $cook_chill_checks;
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
			CookChillCheck::create($request->all());
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
        return CookChillCheck::with('user','supplier','typeOfFood','organization','probe')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCookChillCheck($id)
    {
        return CookChillCheck::findOrFail($id);
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
			$cook_chill_check = CookChillCheck::findOrFail($id);
			$cook_chill_check->update($request->all());
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
			CookChillCheck::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
