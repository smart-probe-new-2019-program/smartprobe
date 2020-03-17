<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactsController extends Controller
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
		return Contact::all();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getAllContacts(Request $request)
	{
		$organization_id = $request['organization_id'];
		$location_id = $request['location_id'];
		$filter_keyword = $request['filter_keyword'];

		$contacts = Contact::with('organization', 'location');

		if ($organization_id != 'All') {
			$contacts = $contacts->where('organization_id', $organization_id);
		}

		if ($location_id != 'All') {
			$contacts = $contacts->where('location_id', $location_id);
		}

		if ($filter_keyword != 'null') {
			$contacts = $contacts->where(function ($q) use ($filter_keyword) {
				$q->where('value', 'LIKE', '%' . $filter_keyword . '%');
			});
		}

		$contacts = $contacts->orderBy('created_at', 'desc')->paginate(100);

		return $contacts;
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
		try {
			Contact::create($request->all());
			$this->status = 'success';
		} catch (\Illuminate\Database\QueryException $ex) {
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
		return Contact::findOrFail($id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getContact($id)
	{
		return Contact::findOrFail($id);
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
		try {
			$contact = Contact::findOrFail($id);
			$contact->update($request->all());
			$this->status = 'success';
		} catch (\Illuminate\Database\QueryException $ex) {
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
		try {
			Contact::find($id)->delete();
			$this->status = 'success';
		} catch (\Illuminate\Database\QueryException $ex) {
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
	}
}
