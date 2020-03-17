<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CorrectiveAction;
use App\IndividualComment;
use App\Probe;
use App\ProbesLog;
use Carbon\Carbon;

class CorrectiveActionsController extends Controller
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
		return CorrectiveAction::all();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getAllCorrectiveActions(Request $request)
	{
		$organization_id = $request['organization_id'];
		$user_id = $request['user_id'];
		$start_date = $request['start_date'] . ' 00:00:00';
		$end_date = $request['end_date'] . ' 23:59:59';

		$corrective_actions = CorrectiveAction::with('organization', 'user');

		if ($organization_id != 'All') {
			$corrective_actions = $corrective_actions->where('organization_id', $organization_id);
		}

		if ($user_id) {
			$corrective_actions = $corrective_actions->where('created_by', $user_id);
		}

		if ($start_date <= $end_date) {
			$corrective_actions = $corrective_actions
				->where('created_at', '>=', $start_date)
				->where('created_at', '<=', $end_date);
		}

		$corrective_actions = $corrective_actions->orderBy('created_at', 'desc')->paginate(100);

		return $corrective_actions;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getCorrectiveActionsByOrganizationID($id)
	{
		return CorrectiveAction::with('organization', 'user')->where('organization_id', $id)->get();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getTempCheckLogs(Request $request)
	{
		$individual_comments = IndividualComment::with('corrective_action', 'probe', 'corrective_action.user');

		return $individual_comments->orderBy('created_at', 'desc')->paginate(100);
		// return CorrectiveAction::with('organization', 'user')->where('organization_id', $id)->get();
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
		$comment_type = $request['comment_type'];
		$organization_id = $request['organization_id'];
		$group_comment = $request['comment']; //this variable is for the group comment
		$comments = $request['comments']; //this array holds the probes and individual comments
		$user_id = $request['created_by'];

		try {
			$corrective_action = CorrectiveAction::create($request->all());
			$this->status = 'success';
			$this->data = $corrective_action;

			$corrective_action_id = $corrective_action->id;

			if ($comment_type == 'Group Comment') {
				//Loop through comments array to get probe ids
				foreach ($comments as $key => $value) {
					$probe_id = $value['probe_id'];
					//Get current, max, and min temperature of probe
					$actual_temperature = ProbesLog::where('probe_id', $probe_id)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->limit(1)->value('actual_temperature');
					$current_temperature = $actual_temperature;
					$max_temperature = ProbesLog::where('probe_id', $probe_id)->whereDate('created_at', Carbon::today())->max('actual_temperature');
					$min_temperature = ProbesLog::where('probe_id', $probe_id)->whereDate('created_at', Carbon::today())->min('actual_temperature');

					//Save to comments
					$individual_comment['corrective_action_id'] = $corrective_action_id;
					$individual_comment['probe_id'] = $probe_id;
					$individual_comment['comment'] = $group_comment;
					$individual_comment['current_temperature'] = $current_temperature;
					$individual_comment['max_temperature'] = $max_temperature;
					$individual_comment['min_temperature'] = $min_temperature;
					$individual_comment['created_by'] = $user_id;
					$individual_comment['updated_by'] = $user_id;

					IndividualComment::create($individual_comment);
				}
			} else {
				//Loop through comments array to get probe ids
				foreach ($comments as $key => $value) {
					$probe_id = $value['probe_id'];
					$individual_comment_value = $value['comment'];
					//Get current, max, and min temperature of probe
					$actual_temperature = ProbesLog::where('probe_id', $probe_id)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->limit(1)->value('actual_temperature');
					$current_temperature = $actual_temperature;
					$max_temperature = ProbesLog::where('probe_id', $probe_id)->whereDate('created_at', Carbon::today())->max('actual_temperature');
					$min_temperature = ProbesLog::where('probe_id', $probe_id)->whereDate('created_at', Carbon::today())->min('actual_temperature');

					//Save to comments
					$individual_comment['corrective_action_id'] = $corrective_action_id;
					$individual_comment['probe_id'] = $probe_id;
					$individual_comment['comment'] = $individual_comment_value;
					$individual_comment['current_temperature'] = $current_temperature;
					$individual_comment['max_temperature'] = $max_temperature;
					$individual_comment['min_temperature'] = $min_temperature;
					$individual_comment['created_by'] = $user_id;
					$individual_comment['updated_by'] = $user_id;

					IndividualComment::create($individual_comment);
				}
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
		return CorrectiveAction::with('organization', 'user')->findOrFail($id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getCorrectiveAction($id)
	{
		return CorrectiveAction::findOrFail($id);
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
			$corrective_action = CorrectiveAction::findOrFail($id);
			$corrective_action->update($request->all());
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
			IndividualComment::where('corrective_action_id', $id)->delete();
			CorrectiveAction::find($id)->delete();
			$this->status = 'success';
		} catch (\Illuminate\Database\QueryException $ex) {
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
	}
}
