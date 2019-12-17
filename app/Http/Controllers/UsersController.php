<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
        return User::all();
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers(Request $request)
    { 
		$organization_id = $request['organization_id'];

		$users = User::with('organization');

		if($organization_id){
			$users = $users->where('organization_id', $request['organization_id']);
		}
		
		$users = $users->orderBy('created_at','desc')->paginate(5);

		return $users;

		// $filter = $request['filter'];

		// if($filter){
		// 	return User::with('process')
		// 			->with('shift')
		// 			->with('line')
		// 			->where('first_name', 'like', '%' . $filter . '%')
		// 			->orWhere('last_name', 'like', '%' . $filter . '%')
		// 			->orderBy('created_at','desc')
		// 			->paginate(5);
		// }
		// else{
		// 	return User::with('process')
		// 			->with('shift')
		// 			->with('line')
		// 			->orderBy('created_at','desc')
		// 			->paginate(5);
		// }
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsersForDropdown()
    {
		return User::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsersByOrganizationID($id)
    {
		return User::where('organization_id', $id)->get();
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
		$request['full_name'] = $request['first_name'] . ' ' . $request['last_name'];
		$request['password'] = Hash::make($request['password']);

		try{
			User::create($request->all());
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			// if(strpos($ex->getMessage(), 'users_email_unique')){
			// 	$this->status = 'error';
			// 	$this->data = 'Duplicate Email';
			// }
			// else if(strpos($ex->getMessage(), 'users_username_unique')){
			// 	$this->status = 'error';
			// 	$this->data = 'Duplicate Username';
			// }
			// else{
			// 	$this->status = 'error';
			// 	$this->data = $ex->getMessage();
			// }

			if(strpos($ex->getMessage(), 'users_username_unique')){
				$this->status = 'error';
				$this->data = 'Duplicate Username';
			}
			else{
				$this->status = 'error';
				$this->data = $ex->getMessage();
			}
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
        // return User::with('process')
		// 			->with('shift')
		// 			->with('line')
		// 			->findOrFail($id);

		return User::with('organization','location')->findOrFail($id);
	}
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUser($id)
    {
        return User::findOrFail($id);
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
		$request['full_name'] = $request['first_name'] . ' ' . $request['last_name'];

		if($request['password']){
			$request['password'] = Hash::make($request['password']);
		}

		try{
			$user = User::findOrFail($id);
			$user->update($request->all());
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			// if(strpos($ex->getMessage(), 'users_email_unique')){
			// 	$this->status = 'error';
			// 	$this->data = 'Duplicate Email';
			// }
			// else if(strpos($ex->getMessage(), 'users_username_unique')){
			// 	$this->status = 'error';
			// 	$this->data = 'Duplicate Username';
			// }
			// else{
			// 	$this->status = 'error';
			// 	$this->data = $ex->getMessage();
			// }

			if(strpos($ex->getMessage(), 'users_username_unique')){
				$this->status = 'error';
				$this->data = 'Duplicate Username';
			}
			else{
				$this->status = 'error';
				$this->data = $ex->getMessage();
			}
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
			User::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
