<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Globals\Authenticator;
use App\Globals\Helper;
use App\Globals\Tags;
use Carbon\Carbon;
use App\Tbl_member;
use App\Tbl_task;
use App\Tbl_task_assignee;
use App\Tbl_task_tags;
use App\Tbl_timesheet;
use App\Tbl_project;
use App\Tbl_tags;
use DateTime;

class AppController extends Controller
{
	public $member;

	function __construct()
	{
		$this->middleware(function ($request, $next)
		{
			$member = Authenticator::checkLogin();

			if(!$member)
			{
				return redirect("/login");
			}
			else
			{
				$this->member = $member;
				view()->share("session_member", $member);
			}

			return $next($request);
		});
	}
    public function dashboard()
    {
    	$data["page"] 				= "App Dashboard";
    	$data["time_spent_today"] 	= Tbl_timesheet::where("timesheet_date", date("Y-m-d"))->sum("second_spent");
    	return view("app.dashboard", $data);
    }

    public function task_table()
    {
    	sleep(1);

    	$__task 			= null;
    	$_task 				= Tbl_task::project()->assignedBy()->orderBy("task_deadline")->get();

    	foreach($_task as $key => $task)
    	{
    		$__task[$key] 					= $task;
    		$__task[$key]->deadline 		= Helper::timeUntil($task->task_deadline);
    		$__task[$key]->tags 			= Tags::get($task->task_id);
    		$__task[$key]->working 			= $this->member->member_task == $task->task_id ? true : false;
    	}

    	$data["_task"] 		= $__task;

    	return view("app.task_table", $data);
    }


    public function add_task()
    {
    	$data["_project"] 	= Tbl_project::get();
    	$data["_tags"] 		= Tbl_tags::get();
    	sleep(1);
    	return view("app.add_task", $data);
    }
    public function add_task_submit(Request $request)
    {
    	/* INSERT TASK */
    	$insert_task["task_title"] 			= $request->task_title;
    	$insert_task["task_detail"] 		= "";
    	$insert_task["task_deadline"] 		= Carbon::parse($request->deadline . $request->deadline_time)->format("Y-m-d H:i:s");
    	$insert_task["task_project"] 		= $request->task_project;
    	$insert_task["task_assigned_by"]	= $this->member->member_id;
    	$task_id = Tbl_task::insertGetId($insert_task);

    	/* INSERT TASK ASSIGNEE */
    	$insert_assignee["task_id"] 			= $task_id;
    	$insert_assignee["task_assigned_to"] 	= $this->member->member_id;
    	Tbl_task_assignee::insert($insert_assignee);

    	/* INSERT TASK TAGS */
    	if($request->_tag)
    	{
	    	foreach($request->_tag as $key => $tags)
	    	{
	    		$insert_tags[$key]["task_id"] 	= $task_id;
	    		$insert_tags[$key]["tag_id"] 	= $key;
	    	}

	    	Tbl_task_tags::insert($insert_tags);
    	}

    	sleep(1);
    	return json_encode($request->all());
    }
    public function view_task($task_id)
    {
    	sleep(1);
    	$task 				= Tbl_task::project()->where("task_id", $task_id)->first();
    	$task->tags  		= Tags::get($task->task_id);
    	$task->deadline 	= Helper::timeUntil($task->task_deadline);
    	$task->task_detail 	= ($task->task_detail == '' ? '<div class="no-detail"><i class="fa fa-info-circle"></i> NO DETAILS REGARDING THIS TASK</div>' : $task->task_detail);
    	$task->working 		= $this->member->member_task == $task->task_id ? true : false;
     	$data["task"] 	= $task;
    	return view("app.view_task", $data);
    }

    public function time_in(Request $request)
    {
    	sleep(1);

    	$update["member_task"] 		= $request->task_id;
    	$update["last_work_time"] 	= Carbon::now();
    	Tbl_member::where("member_id", $this->member->member_id)->update($update);

    	$insert["timesheet_date"] 	= date("Y-m-d");
    	$insert["time_in"] 			= date("H:i:s");
    	$insert["time_out"] 		= date("H:i:s");
    	$insert["second_spent"] 	= 0;
    	$insert["member_id"] 		= $this->member->member_id;
    	$insert["task_id"] 			= $request->task_id;

    	$timesheet_id 				= Tbl_timesheet::insertGetId($insert);

    	return json_encode($timesheet_id);
    }

    public function time_out(Request $request)
    {
    	sleep(1);

    	$update["member_task"] 		= 0;
    	$update["last_work_time"] 	= Carbon::now();
    	Tbl_member::where("member_id", $this->member->member_id)->update($update);

    	echo json_encode("success");
    }

    public function update_time_out(Request $request)
    {
    	$timesheet_id 				= $request->timesheet_id;
    	$timesheet_info 			= Tbl_timesheet::where("timesheet_id", $timesheet_id)->first();
    	$update["time_out"] 		= date("H:i:s");
		$datetime1 					= new DateTime('2009-10-10 '. $timesheet_info->time_in);
		$datetime2 					= new DateTime('2009-10-10' . date("H:i:s"));
		$interval 					= $datetime1->diff($datetime2);
		$hours 						= intval($interval->format("%h")) * 3600;
		$minutes 					= intval($interval->format("%i")) * 60;
		$seconds 					= intval($interval->format("%s"));
    	$update["second_spent"] 	= $hours + $minutes + $seconds;

    	Tbl_timesheet::where("timesheet_id", $timesheet_id)->update($update);

    	return $update["second_spent"];
    }

	public function logout()
	{
		session()->forget("login");
		return redirect("/login");
	}
}