<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Globals\Authenticator;
use Carbon\Carbon;
use App\Tbl_member;
use App\Tbl_task;
use App\Tbl_task_assignee;
use App\Tbl_project;
use App\Tbl_tags;

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
				$this->member 					= $member;
				view()->share("session_member", $member);
			}

			return $next($request);
		});
	}
    public function dashboard()
    {
    	$data["page"] = "App Dashboard";
    	return view("app.dashboard", $data);
    }

    public function task_table()
    {
    	sleep(1);
    	$__task 			= null;
    	$_task 				= Tbl_task::get();

    	foreach($_task as $key => $task)
    	{
    		$__task[$key] 	= $task;
    	}

    	$data["_task"] 		= $__task;
    	return view("app.task_table");
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
    	$insert_task["task_deadline"] 		= Carbon::parse($request->deadline)->format("Y-m-d H:i:s");
    	$insert_task["task_project"] 		= $request->task_project;
    	$insert_task["task_assigned_by"]	= $this->member->member_id;
    	$task_id = Tbl_task::insertGetId($insert_task);

    	/* INSERT TASK ASSIGNEE */
    	$insert_assignee["task_id"] 			= $task_id;
    	$insert_assignee["task_assigned_to"] 	= $this->member->member_id;
    	Tbl_task_assignee::insert($insert_assignee);

    	sleep(1);
    	return json_encode($request->all());
    }
    public function view_task()
    {
    	sleep(1);
    	return view("app.view_task");
    }
	public function logout()
	{
		session()->forget("login");
		return redirect("/login");
	}
}