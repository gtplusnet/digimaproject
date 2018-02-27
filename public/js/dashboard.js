var dashboard = new dashboard();

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
		add_event_refresh_task();
		add_event_new_task_clicked();
		add_event_view_task_clicked();
	}

	this.action_load_ongoing_task_list = function()
	{
		$(".modal-loader").find(".loading-text").text("Loading Ongoing Task List");
		$(".load-table-ongoing-task-list").html(html_modal_loading());

		$.ajax(
		{
			url: 		"/app/task_table",
			data: 		{},
			type: 		"get",
			success: function(data)
			{
				$(".load-table-ongoing-task-list").html(data);
			}
		});
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
		$(".view-task").click(function()
		{
			$('#view_task').modal("show");
			$("#view_task").find(".modal-content").html(html_modal_loading());

			$task_id = 1;

			$.ajax(
			{
				url: 		"/app/view_task/" + $task_id,
				data: 		{},
				type: 		"get",
				success: function(data)
				{
					$(".modal-loader").find(".loading-text").text("Loading Task Information");
					$("#view_task").find(".modal-content").html(data);
				}
			});
		});
	}

	function html_modal_loading()
	{
		return $(".modal-loader").html();
	}
}