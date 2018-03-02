<form class="form-task-add">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-address-book"></i> Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4" style="margin-bottom: 10px;">
                <input class="form-control text-center date-picker choose-timesheet-date" type="text" value="{{ date('m/d/Y') }}">
            </div>

            <div class="col-md-12 load-table-timesheet">

            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    load_table_timesheet();
    event_change_date();

    function event_change_date()
    {
        $(".choose-timesheet-date").change(function()
        {
            load_table_timesheet();
        });
    }

    function load_table_timesheet()
    {
        var ajax_timesheet_data = {};
        $(".load-table-timesheet").html("<div style='padding: 30px; color: #ddd;' class='text-center'><i class='fa fa-spinner fa-pulse'></i> Loading Time Logs</div>");

        ajax_timesheet_data.date_filter = $(".choose-timesheet-date").val();

        $.ajax(
        {
            url:"app/timesheet/table",
            data: ajax_timesheet_data,
            type: "get",
            success: function(data)
            {
                $(".load-table-timesheet").html(data);
            }
        });
    }

    $(".date-picker").datepicker();
</script>