<form class="form-task-add">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-briefcase"></i> Add New Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <input required minlength="5" name="task_title" type="text" class="form-control" placeholder="Title of Task">
                </div>
            </div>

            <div class="col-md-12">
                <div class="comment-content">
                    <div class="tab-content">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active markdown-change-tab" target="write-comment">Write</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link markdown-write-mode markdown-change-tab" target="preview-comment">Preview</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-output">
                        <!-- WRITE COMMENT -->
                        <div class="comment-tab write-comment">
                            <textarea name="task_detail" class="write-comment-textarea" placeholder="Task Details"></textarea>
                            <div class="attach-file"><i class="fa fa-paperclip"></i> Attach files by clicking here.</div>
                        </div>
                        <!-- PREVIEW TAB -->
                        <div class="comment-tab preview-comment" style="display: none;">
                            <div class="preview-comment-container">
                                Nothing to preview
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Project</label>
                    <select name="task_project" class="form-control chosen-select">
                        @foreach($_project as $project)
                        <option value="{{ $project->project_id }}">{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Deadline Date</label>
                    <input class="date-picker form-control" required name="deadline" type="text" value="{{ date('m/d/Y') }}">
                </div>
            </div>

            <div class="col-md-4">
               
                <div class="form-group">
                    <label>Deadline Time</label>
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

            <div class="col-md-8">
                <div class="form-group">
                    <label>Assignee</label>
                    <select name="assignee[]" multiple data-placeholder="Select assignee" class="multipleSelect form-control chosen-select" >
                        @foreach($_member as $member)
                        <option value="{{ $member->member_id }}" {{ $session_member->member_id == $member->member_id ? 'selected' : '' }}>{{ $member->username }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Quality Checker</label>
                    <select name="quality_checker" class="form-control chosen-select">
                        @foreach($_member as $member)
                            @if($member->member_admin == 1)
                                <option value="{{ $member->member_id }}" {{ $session_member->member_id == $member->member_id ? 'selected' : '' }}>{{ $member->username }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

             <div class="col-md-12">
                <div class="form-group">
                    <label>Tags</label>
                    <select name="tags[]" multiple data-placeholder="Select tags" class="multipleSelect form-control chosen-select">
                        @foreach($_tags as $tag)
                        <option value="{{ $tag->tag_id }}">{{ $tag->tag_label }}</option>
                        @endforeach
                    </select>
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
    });

    $(".write-comment-textarea").autoGrow();
    $(".date-picker").datepicker();
    $(".chosen-select").chosen();
</script>