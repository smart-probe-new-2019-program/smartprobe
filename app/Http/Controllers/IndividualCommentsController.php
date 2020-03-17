<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndividualComment;

class IndividualCommentsController extends Controller
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
		return IndividualComment::all();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getAllIndividualComments(Request $request)
	{
		return IndividualComment::with('corrective_action', 'probe')
			->orderBy('created_at', 'desc')->paginate(5);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndividualCommentsByCorrectiveActionID($id)
	{
		return IndividualComment::with('corrective_action', 'probe')
			->where('corrective_action_id', $id)
			->orderBy('created_at', 'desc')
			->get();
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
		$comments = $request['comments'];
		$corrective_action_id  = $request['corrective_action_id'];
		$created_by = $request['created_by'];
		$updated_by = $request['updated_by'];

		try {
			$individual_comment['corrective_action_id'] = $corrective_action_id;
			$individual_comment['created_by'] = $created_by;
			$individual_comment['updated_by'] = $updated_by;

			for ($i = 0; $i < count($comments); $i++) {
				$individual_comment['probe_id'] = $comments[$i]['probe_id'];
				$individual_comment['comment'] = $comments[$i]['comment'];

				IndividualComment::create($individual_comment);
				$this->status = 'success';
			}
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
		return IndividualComment::with('corrective_action', 'probe')->findOrFail($id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getIndividualComment($id)
	{
		return IndividualComment::findOrFail($id);
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
			$individual_comment = IndividualComment::findOrFail($id);
			$individual_comment->update($request->all());
			$this->status = 'success';
		} catch (\Illuminate\Database\QueryException $ex) {
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulkUpdate(Request $request)
	{
		$comments = $request['comments'];

		try {
			for ($i = 0; $i < count($comments); $i++) {
				$individual_comment = IndividualComment::findOrFail($comments[$i]['id']);
				$individual_comment->comment = $comments[$i]['comment'];
				$individual_comment->updated_by = $comments[$i]['updated_by'];
				$individual_comment->save();
				$this->status = 'success';
			}
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
			IndividualComment::find($id)->delete();
			$this->status = 'success';
		} catch (\Illuminate\Database\QueryException $ex) {
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
	}
}
