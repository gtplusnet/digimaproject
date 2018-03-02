<form method="post" class="form-save-timesheet">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-address-book"></i> Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <select name="member_id" class="form-control choose-member-timesheet">
                    @foreach($_member as $member)
                    <option {{ $session_member->member_id == $member->member_id ? 'selected' : '' }} value="{{ $member->member_id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4" style="margin-bottom: 10px;">
                <input name="timesheet_date" class="form-control text-center date-picker choose-timesheet-date" type="text" value="{{ date('m/d/Y') }}">
            </div>

            <div class="col-md-12 load-table-timesheet">

            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    load_table_timesheet();
    event_change_date();
    event_save_manual_time();

    function event_save_manual_time()
    {
        $(".form-save-timesheet").submit(function()
        {
            if(confirm("Are you sure you want to manually add this time?"))
            {
                $(".save-timesheet-button").html("<i class='fa fa-spinner fa-pulse'></i>");
                $(".save-timesheet-button").attr("disabled", "disabled");

                $.ajax(
                {
                    url:"/app/manual_time",
                    dataType:"json",
                    data: $(".form-save-timesheet").serialize() ,
                    type:"post",
                    success: function(data)
                    {
                        load_table_timesheet();

                    }
                });
            }

            return false;
        });
    } 

    function event_change_date()
    {
        $(".choose-timesheet-date").change(function()
        {
            load_table_timesheet();
        });

        $(".choose-member-timesheet").change(function()
        {
            load_table_timesheet();
        });
    }

    function load_table_timesheet()
    {
        var ajax_timesheet_data = {};
        $(".load-table-timesheet").html("<div style='padding: 30px; color: #ddd;' class='text-center'><i class='fa fa-spinner fa-pulse'></i> Loading Time Logs</div>");

        ajax_timesheet_data.date_filter     = $(".choose-timesheet-date").val();
        ajax_timesheet_data.member_id       = $(".choose-member-timesheet").val();

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