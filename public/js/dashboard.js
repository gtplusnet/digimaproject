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
		add_event_new_task_clicked();
		add_event_view_task_clicked();
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