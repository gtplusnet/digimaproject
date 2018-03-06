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
use stdClass;
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
    	$data["time_spent_today"] 	= Tbl_timesheet::where("timesheet_date", date("Y-m-d"))->where("member_id", $this->member->member_id)->sum("second_spent");
        $data["_member"]            = Tbl_member::get();
        $data["_project"]           = Tbl_project::get();
        $data["_tags"]              = Tbl_tags::get();

        return view("app.dashboard", $data);
    }

    public function timesheet()
    {
        $data["page"]               = "Timesheet";
        $data["_member"]            = Tbl_member::get();

        return view("app.timesheet", $data);
    }
    public function timesheet_table(Request $request)
    {
        $data["page"]               = "Timesheet";
        $__timesheet                = null;
        $_timesheet                 = Tbl_timesheet::where("timesheet_date", date("Y-m-d", strtotime($request->date_filter)))->where("member_id", $request->member_id)->where("second_spent", "!=", 0)->orderBy("time_in", "asc")->get();
        $total_second_spent         = Tbl_timesheet::where("timesheet_date", date("Y-m-d", strtotime($request->date_filter)))->where("member_id", $request->member_id)->where("second_spent", "!=", 0)->sum("second_spent");

        $previous_time_out          = null;
        $total_break                = 0;
        $ctr                        = 0;

        foreach($_timesheet as $key => $timesheet)
        {
            if($previous_time_out == null)
            {
                $break_span         = "00:00";
                $total_break        = 0;
            }
            else
            {
                $datetime1      = new DateTime('2009-10-11 ' . $previous_time_out);
                $datetime2      = new DateTime('2009-10-11 ' . $timesheet->time_in);
                $interval       = $datetime1->diff($datetime2);
                $break_span     = $interval->format("%H:%I");
                $total_break    += intval($interval->format("%s")) + intval($interval->format("%i")) * 60 + intval($interval->format("%H") * 3600);

                if($break_span != "00:00")
                {
                    $__timesheet[$ctr]                   = new stdClass();
                    $__timesheet[$ctr]->time_in          = Carbon::parse($previous_time_out)->format("h:i A");
                    $__timesheet[$ctr]->time_out         = Carbon::parse($timesheet->time_in)->format("h:i A");
                    $__timesheet[$ctr]->second_spent     = $interval->format("%H:%I:%S");
                    $__timesheet[$ctr]->time_detail      = "BREAK / IDLE";
                    $ctr++;
                }
            }

            $__timesheet[$ctr]                  = $timesheet;
            $__timesheet[$ctr]->time_in         = Carbon::parse($timesheet->time_in)->format("h:i A");
            $__timesheet[$ctr]->time_out        = Carbon::parse($timesheet->time_out)->format("h:i A");
            $__timesheet[$ctr]->second_spent    = Helper::convertSeconds($timesheet->second_spent);
            $previous_time_out                  = $timesheet->time_out;
            $ctr++;
        }

        $data["_timesheet"]                     = $__timesheet;
        $data["total_second_spent"]             = Helper::convertSeconds($total_second_spent);
        $data["total_break"]                    = Helper::convertSeconds($total_break);
        return view("app.timesheet_table", $data);
    }

    public function member_list()
    {
        $data["page"]       = "Member List";
        $__member           = null;
        $_member            = Tbl_member::orderBy("last_work_time", "desc")->get();

        foreach($_member as $key => $member)
        {
            $task                           = Tbl_task::where("task_id", $member->member_task)->first();

            if($task)
            {
                $working                    = "<a href='javascript:' class='view-task' task_id='" . $task->task_id . "'>" . $task->task_title . "</a>";
            }
            else
            {
                $working                    = "NONE YET";
            }

            $second_spent                   = Tbl_timesheet::where("timesheet_date", date("Y-m-d"))->where("member_id", $member->member_id)->sum("second_spent");

            $__member[$key]                 = $member;
            $__member[$key]->last_online    = Helper::onlineAgo($member->last_work_time);
            $__member[$key]->today_render   = Helper::convertSeconds($second_spent);
            $__member[$key]->working        = $working;

            $undertime                      = 28800 - $second_spent;
            $estimated_time_out             = date("h:i A", time() + $undertime);

            if($undertime > 0)
            {
                $__member[$key]->undertime              = "<span style='color: red;'>" . Helper::convertSeconds($undertime) . "</span>";
                $__member[$key]->estimated_time_out     = "<span>" . $estimated_time_out . "</span>";
                $__member[$key]->today_render           = "<span style='color: red;'>" . $__member[$key]->today_render . "</span>";
            }
            else
            {
                $undertime                              = $undertime * -1;
                $__member[$key]->undertime              = Helper::convertSeconds(0);
                $__member[$key]->estimated_time_out     = "<span>Time Complete</span>";
                $__member[$key]->today_render           = "<span style='color: green;'>" . $__member[$key]->today_render . "</span>";
            }

           
        }

        $data["_member"]    = $__member;

        return view("app.member_list", $data);
    }

    public function task_table(Request $request)
    {
    	$__task 			= null;
    	$_task 				= Tbl_task::project()->assignedBy()->orderBy("task_deadline");

        $_task->where("task_status", $request->status);

        if($request->assignee != 0)
        {
            $_task->filterAssignee($request->assignee);
        }

        if($request->project != 0)
        {
            $_task->where("task_project", $request->project);
        }

        if($request->reviewee == 1)
        {
            $_task->where("task_reviewee", $this->member->member_id);
        }

        if($request->tags != 0)
        {
            $_task->filterTags($request->tags);
        }

        if($request->search != "")
        {
            $_task->where("task_title", "LIKE", "%" . $request->search . "%");
        }

        $_task              = $_task->get();

    	foreach($_task as $key => $task)
    	{
            $reviewee                       = Tbl_member::where("member_id", $task->task_reviewee)->value("username");

    		$__task[$key] 					= $task;
    		$__task[$key]->deadline 		= Helper::timeUntil($task->task_deadline);
    		$__task[$key]->tags 			= Tags::get($task->task_id);
    		$__task[$key]->working 			= $this->member->member_task == $task->task_id ? true : false;
            $__task[$key]->assignee         = Self::parseAssigneeList($task->task_id);
            $__task[$key]->reviewee         = $reviewee == "" ? "NONE" : $reviewee;
    	}

    	$data["_task"] 		= $__task;

        if($this->member->member_admin == 1)
        {
            return view("app.task_table_admin", $data);
        }
        else
        {
            return view("app.task_table", $data);
        }
    }

    public static function parseAssigneeList($task_id)
    {
        $_assignee = Tbl_task_assignee::where("task_id", $task_id)->member()->get();

        $__assignee = null;

        foreach($_assignee as $key => $assignee)
        {
            $__assignee[$key] = $assignee->username;
        }

        if($__assignee)
        {
            return implode(", ", $__assignee);
        }
        else
        {
            return "NO ASSIGNEE";
        }

        
    }

    public function add_task()
    {
    	$data["_project"] 	= Tbl_project::get();
    	$data["_tags"] 		= Tbl_tags::get();
        $data["_member"]    = Tbl_member::get();
    	return view("app.add_task", $data);
    }
    public function edit_task($task_id)
    {
        $data["_project"]   = Tbl_project::get();

        $__tags             = null;
        $_tags              = Tbl_tags::get();

        foreach($_tags as $key => $tags)
        {
            $__tags[$key]               = $tags;
            $__tags[$key]->selected     = Tbl_task_tags::where("task_id", $task_id)->where("tag_id", $tags->tag_id)->value("task_tag_id");
        }

        $data["_tags"]      = $__tags;

        $__member           = null;
        $_member            = Tbl_member::get();

        foreach($_member as $key => $member)
        {
            $__member[$key]             = $member;
            $__member[$key]->assignee   = Tbl_task_assignee::where("task_id", $task_id)->where("task_assigned_to", $member->member_id)->value("task_assignee_id");
        }

        $data["_member"]    = $__member;

        $data["task"]       = Tbl_task::where("task_id", $task_id)->first();
        return view("app.edit_task", $data);
    }

    public function add_task_submit(Request $request)
    {
    	/* INSERT TASK */
    	$insert_task["task_title"] 			= $request->task_title;
    	$insert_task["task_detail"] 		= ($request->task_detail == "" ? "" : $request->task_detail);
    	$insert_task["task_deadline"] 		= Carbon::parse($request->deadline . $request->deadline_time)->format("Y-m-d H:i:s");
    	$insert_task["task_project"] 		= $request->task_project;
    	$insert_task["task_assigned_by"]	= $this->member->member_id;
        $insert_task["task_reviewee"]       = $request->reviewee;
    	$task_id = Tbl_task::insertGetId($insert_task);

        /* INSERT TASK TAGS */
        if($request->assignee)
        {
            foreach($request->assignee as $key => $assignee_id)
            {
                $insert_assignee[$key]["task_id"]             = $task_id;
                $insert_assignee[$key]["task_assigned_to"]    = $assignee_id;
            }

            Tbl_task_assignee::insert($insert_assignee);
        }

    	/* INSERT TASK TAGS */
    	if($request->tags)
    	{
	    	foreach($request->tags as $key => $tag_id)
	    	{
	    		$insert_tags[$key]["task_id"] 	= $task_id;
	    		$insert_tags[$key]["tag_id"] 	= $tag_id;
	    	}

	    	Tbl_task_tags::insert($insert_tags);
    	}

    	return json_encode($request->all());
    }

    public function edit_task_submit(Request $request, $task_id)
    {
        /* INSERT TASK */
        $insert_task["task_title"]          = $request->task_title;
        $insert_task["task_detail"]         = ($request->task_detail == "" ? "" : $request->task_detail);
        $insert_task["task_deadline"]       = Carbon::parse($request->deadline . $request->deadline_time)->format("Y-m-d H:i:s");
        $insert_task["task_project"]        = $request->task_project;
        $insert_task["task_assigned_by"]    = $this->member->member_id;
        $insert_task["task_reviewee"]       = $request->reviewee;

        Tbl_task::where("task_id", $task_id)->update($insert_task);

        Tbl_task_assignee::where("task_id", $task_id)->delete();

        /* INSERT TASK TAGS */
        if($request->assignee)
        {
            foreach($request->assignee as $key => $assignee_id)
            {
                $insert_assignee[$key]["task_id"]             = $task_id;
                $insert_assignee[$key]["task_assigned_to"]    = $assignee_id;
            }

            Tbl_task_assignee::insert($insert_assignee);
        }


        Tbl_task_tags::where("task_id", $task_id)->delete();

        /* INSERT TASK TAGS */
        if($request->tags)
        {
            foreach($request->tags as $key => $tag_id)
            {
                $insert_tags[$key]["task_id"]   = $task_id;
                $insert_tags[$key]["tag_id"]    = $tag_id;
            }

            Tbl_task_tags::insert($insert_tags);
        }

        return json_encode($request->all());
    }
    public function view_task($task_id)
    {
    	$task 				= Tbl_task::project()->where("task_id", $task_id)->first();
    	$task->tags  		= Tags::get($task->task_id);
    	$task->deadline 	= Helper::timeUntil($task->task_deadline);
    	$task->task_detail 	= ($task->task_detail == '' ? '<div class="no-detail"><i class="fa fa-info-circle"></i> NO DETAILS REGARDING THIS TASK</div>' : $task->task_detail);
    	$task->working 		= $this->member->member_task == $task->task_id ? true : false;
     	$data["task"] 	    = $task;

    	return view("app.view_task", $data);
    }

    public function time_in(Request $request)
    {
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
    	$update["member_task"] 		= 0;
    	$update["last_work_time"] 	= Carbon::now();
    	Tbl_member::where("member_id", $this->member->member_id)->update($update);

    	echo json_encode("success");
    }

    public function manual_time(Request $request)
    {
        $insert["timesheet_date"]   = Carbon::parse($request->timesheet_date);
        $insert["time_in"]          = Carbon::parse($request->time_in);
        $insert["time_out"]         = Carbon::parse($request->time_out);
        $insert["member_id"]        = $request->member_id;
        $insert["task_id"]          = 1;
        $insert["time_detail"]      = $request->time_detail;

        $datetime1                  = new DateTime('2009-10-10 '. $request->time_in);
        $datetime2                  = new DateTime('2009-10-10' . $request->time_out);
        $interval                   = $datetime1->diff($datetime2);
        $hours                      = intval($interval->format("%h")) * 3600;
        $minutes                    = intval($interval->format("%i")) * 60;
        $seconds                    = intval($interval->format("%s"));
        $insert["second_spent"]     = $hours + $minutes + $seconds;

        $timesheet_id               = Tbl_timesheet::insertGetId($insert);

        echo json_encode($timesheet_id);
    }

    public function update_time_out(Request $request)
    {
        $update_timeout["last_work_time"]   = Carbon::now();
        Tbl_member::where("member_id", $this->member->member_id)->update($update_timeout);

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

    function update_task_status(Request $request)
    {
        $task                       = Tbl_task::where("task_id", $request->task_id)->first();

        if($task->task_reviewee == 0 && $request->task_status == "review")
        {
            $request->task_status   = "done";
        }

        $update["task_status"]      = $request->task_status;
        Tbl_task::where("task_id", $request->task_id)->update($update);

        echo json_encode("success");
    }

    public function count_for_review()
    {
        return json_encode(Tbl_task::where("task_reviewee", $this->member->member_id)->where("task_status", "review")->count());
    }

    public function review()
    {
        $data["page"]   = "Review";
        return view("app.review", $data);
    }

	public function logout()
	{
		session()->forget("login");
		return redirect("/login");
	}
}