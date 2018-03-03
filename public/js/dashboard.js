var dashboard = new dashboard();
var digima_time = {};
var time_spent = 0;
var active_timesheet = null;
var time_spent_today = 0;
var idle = false;
var idle_time = 0;
var idle_allowed = 0;
var current_task = 0;
var ajax_task_data = {};

var converter = new showdown.Converter();

function idle_from_csharp(idlex_time)
{
	idle_time = parseInt(idlex_time / 1000);
	$(".idle-time").text(idle_time);
}

function dashboard()
{
	init();

	function init()
	{
		$(document).ready(function()
		{
			document_ready();
		});
	}

	function document_ready()
	{
		dashboard.action_load_ongoing_task_list();

		if ('topMostTrue' in window.external)
		{
			action_initialize_timer();
		}
		else
		{
			$(".status-helper").fadeOut();
			$(".timer-counter").hide();
		}
	

		add_chosen_select();
		add_event_refresh_task();
		add_event_new_task_clicked();
		add_event_view_task_clicked();
		add_event_start_working();
		add_event_stop_working();
		add_event_resume_work();
		add_event_filter_change();
		add_event_manage_members();
		add_event_view_timesheet();
		add_event_for_markdown_box();
	}

	function add_chosen_select()
	{
    	$(".chosen-select").chosen();
	}

	this.action_load_ongoing_task_list = function()
	{
		$(".modal-loader").find(".loading-text").text("Loading Ongoing Task List");
		$(".load-table-ongoing-task-list").html(html_modal_loading());

		ajax_task_data.assignee 	= $(".filter-assignee").val();
		ajax_task_data.project 		= $(".filter-project").val();
		ajax_task_data.tags 		= $(".filter-tags").val();
		ajax_task_data.search 		= $(".task-search").val();

		$.ajax(
		{
			url: 		"/app/task_table",
			data: 		ajax_task_data,
			type: 		"get",
			success: function(data)
			{
				$(".load-table-ongoing-task-list").html(data);
			}
		});
	}

	function actionAppTopMost($topmost)
	{
		if($topmost)
		{
			if ('topMostTrue' in window.external)
			{
				window.external.topMostTrue();
			}
			
		}
		else
		{
			if ('topMostFalse' in window.external)
			{
				window.external.topMostFalse();
			}
		}
	}

	function add_event_for_markdown_box()
	{
		$("body").on("click", ".markdown-change-tab", function(e)
		{
			$tab_class = $(e.currentTarget).attr("target");
			$(".markdown-change-tab").removeClass("active");
			$(e.currentTarget).addClass("active");
			$(e.currentTarget).closest(".comment-content").find(".tab-output").find(".comment-tab").hide();
			$(e.currentTarget).closest(".comment-content").find(".tab-output").find("." + $tab_class).show();

			$text = $(e.currentTarget).closest(".comment-content").find(".tab-output").find(".write-comment-textarea").val();

			if($text.trim() == "")
			{
				$text = "*Nothing to preview*";
			}

			$(e.currentTarget).closest(".comment-content").find(".tab-output").find(".preview-comment-container").html(converter.makeHtml($text));
		});
	}
	function add_event_manage_members()
	{
		$(".click-manage-members").click(function()
		{
			$(".modal-loader").find(".loading-text").text("Checking Member Status");
			$("#manage_members").find(".modal-content").html(html_modal_loading());
			$("#manage_members").modal("show");
			$("#manage_members").find(".modal-content").load("/app/member_list");
		});
	}

	function add_event_view_timesheet()
	{
		$(".click-view-timesheet").click(function()
		{
			$(".modal-loader").find(".loading-text").text("Loading Timesheet");
			$("#manage_members").find(".modal-content").html(html_modal_loading());
			$("#manage_members").modal("show");
			$("#manage_members").find(".modal-content").load("/app/timesheet");
		});
	}

	function add_event_filter_change()
	{
		$(".filter-assignee").change(function()
		{
			dashboard.action_load_ongoing_task_list();
		});

		$(".filter-oject").change(function()
		{
			dashboard.action_load_ongoing_task_list();
		});

		$(".filter-tags").change(function()
		{
			dashboard.action_load_ongoing_task_list();
		});

		$(".task-search").keydown(function(e)
		{
			if(e.which == 13)
			{
				dashboard.action_load_ongoing_task_list();
			}
		})
	}

	function add_event_resume_work()
	{
		$(".resume-work").click(function()
		{
			idle = false;
			$(".idle-cover").hide();
			action_timein(current_task);
			actionAppTopMost(false);
		});
	}

	function add_event_start_working()
	{
		$("body").on("click", ".start-working", function(e)
		{
			current_task = $(e.currentTarget).attr("task_id");
			action_timein(current_task);
		});
	}

	function add_event_stop_working()
	{
		$("body").on("click", ".stop-working", function(e)
		{
			action_timeout();
		});
	}


	function action_timein($task_id)
	{
		var ajaxdata 		= {};
		ajaxdata.task_id 	= $task_id;

		$(".start-working-loading").show();
		$(".start-working").hide();

		$.ajax(
		{
			url:"/app/time_in",
			dataType:"json",
			data: ajaxdata,
			type:"get",
			success: function(data)
			{
				dashboard.action_load_ongoing_task_list();
				$("#view_task").modal("hide");
				active_timesheet = data;
			}
		});	
	}

	function action_timeout()
	{
		$(".start-working-loading").show();
		$(".stop-working").hide();
		action_update_time_out();
		active_timesheet = null;

		$.ajax(
		{
			url:"/app/time_out",
			dataType:"json",
			type:"get",
			success: function(data)
			{
				dashboard.action_load_ongoing_task_list();
				$("#view_task").modal("hide");
			}
		});
	}

	function action_initialize_timer()
	{
		if (typeof(Storage) !== "undefined")
		{
			digima_time.hours 		= parseInt($(".timer-counter").attr("hours"));
			digima_time.minutes 	= parseInt($(".timer-counter").attr("minutes"));
			digima_time.seconds 	= parseInt($(".timer-counter").attr("seconds"));
			time_spent 				= $(".timer-counter").attr("time_spent_today");
			idle_allowed 			= $(".timer-counter").attr("idle_allowed");

			if($(".timer-counter").attr("current_task") == "")
			{
				active_timesheet	= null;
			}
			else
			{
				current_task = $(".timer-counter").attr("current_task");

				if(current_task != 0)
				{
					action_timein(current_task);
				}
			}

			setInterval(function()
			{
				action_start_clock();
			}, 1000)
			
		}
		else
		{
		    alert("Your computer doesn't support local storage.");
		    window.location.href 	= '/login';
		}
	}

	function convert_s(seconds)
	{
		var date = new Date(null);
		date.setSeconds(seconds);
		return date.toISOString().substr(11, 8);
	}
	function action_update_status_helper($text, $background, $color)
	{
		if($(".status-helper").html() != $text.trim())
		{
			$(".status-helper").html($text);
			$(".status-helper").css("background-color", $background).css("color", $color);
		}
	}
	function action_start_clock()
	{
		if(idle_time > idle_allowed && idle == false && active_timesheet)
		{
			actionAppTopMost(true);
			idle = true;
			$(".idle-cover").show();
			action_timeout();
		}

		if(!active_timesheet)
		{
			action_update_status_helper("<b>Time is NOT running.</b> You can start working by choosing a task. ", "red", "#fff");
			actionAppTopMost(true);
		}
		else
		{
			action_update_status_helper("<b>Time is now running.</b> You can now proceed with your work.", "green", "#fff");
			actionAppTopMost(false);
		}

		action_update_display_time();

		digima_time.seconds			= digima_time.seconds + 1;

		/* UPDATE TIMESHEET DURING TIMESPENT */
		if(active_timesheet)
		{
			time_spent++;
		}

		/* UPDATE TIMEOUT EVERY 20 SECONDS */
		if(time_spent % 20 == 0)
		{
			if(active_timesheet)
			{
				action_update_time_out();
			}
		}

		if(digima_time.seconds > 59)
		{
			digima_time.seconds = 0;
			digima_time.minutes = digima_time.minutes + 1;
		}

		if(digima_time.minutes > 59)
		{
			digima_time.minutes = 0;
			digima_time.hours = digima_time.hours + 1;
		}
	}

	function action_update_time_out()
	{
		var ajaxdata 			= {};
		ajaxdata.timesheet_id 	= active_timesheet;

		$.ajax(
		{
			url:"/app/update_time_out",
			data: ajaxdata,
			type:"get"
		});
	}

	function action_update_display_time()
	{
		if(digima_time.hours == 0)
		{
			$hours = 12;
			$suffix = "AM";
		}
		else if(digima_time.hours > 12)
		{
			$hours = digima_time.hours - 12;
			$suffix = "PM";
		}
		else
		{
			$hours = digima_time.hours;
			$suffix = "AM";
		}

		$show_time = digittwo($hours) + ":" + digittwo(digima_time.minutes) + ":" + digittwo(digima_time.seconds) + " " + $suffix;
		$(".idle-countdown").text($show_time);
		$(".timer-countdown").text(convert_s(time_spent));
	}

	function digittwo(myNumber)
	{
		return ("0" + myNumber).slice(-2);
	}



	function add_event_refresh_task()
	{
		$(".refresh-task").click(function()
		{
			dashboard.action_load_ongoing_task_list();
		});
	}

	function add_event_new_task_clicked()
	{
		$(".add-new-task").click(function()
		{
			$("#add_task").find(".modal-content").html(html_modal_loading());
			$('#add_task').modal("show");

			$.ajax(
			{
				url: 		"/app/add_task",
				data: 		{},
				type: 		"get",
				success: function(data)
				{
					$(".modal-loader").find(".loading-text").text("Loading Form");
					$("#add_task").find(".modal-content").html(data);
				}
			});
		});
	}

	function add_event_view_task_clicked()
	{
		$("body").on("click", ".view-task", function(e)
		{
			$('#view_task').modal("show");
			$("#view_task").find(".modal-content").html(html_modal_loading());

			$task_id = $(e.currentTarget).attr("task_id");

			$.ajax(
			{
				url: 		"/app/view_task/" + $task_id,
				data: 		{},
				type: 		"get",
				success: function(data)
				{
					$(".modal-loader").find(".loading-text").text("Loading Task Information");
					$("#view_task").find(".modal-content").html(data);
					add_event_for_view_task();
				}
			});
		});
	}

	function add_event_for_view_task()
	{
		if($(".task-detail-container").find(".no-detail").length == 0)
		{
			$text = $(".task-detail-container").find(".task-detail").text();
			$html = converter.makeHtml($text);
			$(".task-detail-container").find(".task-detail").html($html);
		}

		$(".write-comment-textarea").autoGrow();

		if ('topMostTrue' in window.external)
		{
		}
		else
		{
			$(".stop-working").hide();
			$(".start-working").hide();
		}
	}

	function html_modal_loading()
	{
		return $(".modal-loader").html();
	}
}