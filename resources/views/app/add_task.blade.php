<form class="form-task-add">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus-circle"></i> ADD NEW TASK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <label>Task Title</label>
                <div class="form-group">
                    <input required minlength="5" name="task_title" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <label>Project</label>
                <div class="form-group">
                    <select name="task_project" class="form-control" id="exampleFormControlSelect1">
                        @foreach($_project as $project)
                        <option value="{{ $project->project_id }}">{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label>Deadline</label>
                <div class="form-group">
                    <input class="date-picker form-control" required name="deadline" type="text" value="{{ date('m/d/Y') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label>Deadline Time</label>
                <div class="form-group">
                    <select name="deadline_time" class="form-control">
                        <option>06:00 AM</option>
                        <option>07:00 AM</option>
                        <option>08:00 AM</option>
                        <option>09:00 AM</option>
                        <option>10:00 AM</option>
                        <option>11:00 AM</option>
                        <option>12:00 PM</option>
                        <option>01:00 PM</option>
                        <option>02:00 PM</option>
                        <option>03:00 PM</option>
                        <option>04:00 PM</option>
                        <option>05:00 PM</option>
                        <option selected>06:00 PM</option>
                        <option>07:00 PM</option>
                        <option>08:00 PM</option>
                        <option>09:00 PM</option>
                        <option>10:00 PM</option>
                        <option>11:00 PM</option>
                        <option>12:00 AM</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label>Tags</label>
                <div class="row">
                    <div style="margin-left: 20px;">
                        @foreach($_tags as $tag)
                        <div style="display: inline-block; margin-right: 10px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="_tag[{{ $tag->tag_id }}]" id="tag_{{ $tag->tag_id }}">
                                <label class="form-check-label" for="tag_{{ $tag->tag_id }}">
                                    <div>{{ $tag->tag_label }}</div>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label>Attachment</label>
                <div class="custom-file">
                    <input name="attachment" type="file" class="custom-file-input">
                    <label class="custom-file-label" for="validatedCustomFile"></label>
                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <span class="saving invisible"><i class="fa fa-spinner fa-pulse"></i> Saving</span>
        <button type="submit" class="btn btn-primary submit-button"><i class="fa fa-save"></i> Save New Task</button>
    </div>
</form>

<script type="text/javascript">
    $(".form-task-add").submit(function()
    {
        $(".saving").removeClass("invisible");
        $(".submit-button").attr("disabled", "disabled");

        $.ajax(
        {
            url: "/app/add_task",
            dataType: "json",
            data: $(".form-task-add").serialize(),
            type: "post",
            success: function(data)
            {
                dashboard.action_load_ongoing_task_list();
                $("#add_task").modal("hide");
            },
            error: function(data)
            {
                $(".saving").addClass("invisible");
                $(".submit-button").removeAttr("disabled");
            }
        });

        return false;
    })

    $(".date-picker").datepicker();

</script>