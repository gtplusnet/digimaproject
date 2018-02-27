<form class="form-task-add">
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
                    <input required name="task_title" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <label>Project</label>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>Philtech</option>
                        <option>Brown</option>
                    </select>
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
            <div class="col-md-6">
                <label>Deadline</label>
                <div class="form-group">
                    <input class="date-picker form-control" required name="deadline" type="text" value="{{ date('m/d/Y') }}">
                </div>
            </div>
            <div class="col-md-12">
                <label>Tags</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
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
        return false;
    })

    $(".date-picker").datepicker();

</script>