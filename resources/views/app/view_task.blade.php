<div class="modal-header">
    <h5 class="modal-title"><strong>{{ strtoupper($task->project_name) }}</strong> ({{ $task->task_title }})</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <!-- TASK DETAIL CONTAINER -->
        <div class="col-md-8">
            <div class="task-detail-container">
                <div class="tags-container">
                    {!! $task->tags !!}
                    <span class="deadline">Deadline ends in <strong>{!! $task->deadline !!}</strong></span>
                </div>

                <div class="task-detail preview-comment-container">{!! $task->task_detail !!}</div>
            </div>
        </div>

        <!-- TASK ACTION CONTAINER -->
        <div class="col-md-4">
            <div class="task-action-container">
                <div class="action">
                    @if($task->task_status == "pending")
                        @if($task->working)
                            <button class="stop stop-working"><i class="fa fa-stop-circle"></i> Stop Working</button>
                        @else
                            <button class="main start-working" current_date="{{ date('Y-m-d') }}" member_id="{{ $session_member->member_id }}" task_id="{{ $task->task_id }}"><i class="fa fa-play-circle"></i> Start Working</button>
                        @endif
                    @endif

                    @if($session_member->member_qa == 1 && $task->task_status == "review" && $task->task_reviewee == $session_member->member_id)
                        <button class="main submit-for-review" status="done" task_id="{{ $task->task_id }}"><i class="fa fa-star"></i> Approve as Done</button>
                    @endif

                    <button style="display: none;" class="main start-working-loading"><i class="fa fa-spinner fa-pulse"></i> Notifying Server</button>
                    
                    @if($task->task_status == "pending")
                        <button class="submit-for-review" status="review" task_id="{{ $task->task_id }}"><i class="fa fa-check"></i> Submit for Review</button>
                    @else
                        <button class="submit-for-review" status="pending" task_id="{{ $task->task_id }}"><i class="fa fa-undo"></i> Return to Pending</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- TASK DISCUSSION -->
        <div class="col-md-12">
            <div class="task-discussion">

                <!-- LOG/DISCUSSION LIST -->
                <div class="invisible-log-list" style="display: none;">
                    <!-- LOG -->
                    <div class="log">
                        <span class="icon"><i class="fa fa-plus-circle"></i></span>
                        <span class="name">Guillermo Tabligan</span>
                        <span class="action">created this task and assigned it to Rocky Celis</span>
                        <span class="time">5 hours ago.</span>
                    </div>

                    <!-- COMMENT -->
                    <div class="comment">
                        <div class="comment-image">
                            <img src="https://avatars0.githubusercontent.com/u/4501797?s=88&v=4">
                        </div>
                        <div class="comment-content">
                            <div class="callout"></div>
                            <div class="comment-message">
                                <div class="comment-header">
                                    <span class="name">Guillermo Tabligan</span>
                                    <span class="action">commented</span>
                                    <span class="time-ago">4 hours ago</span>
                                </div>
                                <div class="comment-text">No description provided.</div>
                            </div>
                        </div>
                    </div>

                    <!-- COMMENT -->
                    <div class="comment">
                        <div class="comment-image">
                            <img src="https://avatars0.githubusercontent.com/u/4501797?s=88&v=4">
                        </div>
                        <div class="comment-content">
                            <div class="callout"></div>
                            <div class="comment-message">
                                <div class="comment-header">
                                    <span class="name">Guillermo Tabligan</span>
                                    <span class="action">commented</span>
                                    <span class="time-ago">4 hours ago</span>
                                </div>
                                <div class="comment-text">Hi @kimbriel21 , i will also assign this task to @james35836 . This is customization for NTC. Will explain to him this since he is here in Mnl office. Just informing you. Thanks! :)</div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="log-list">
                </div>
                <!-- WRITE COMMENT -->
                <div class="comment-action">
                    <div class="comment-image">
                        <img src="https://avatars0.githubusercontent.com/u/4501797?s=88&v=4">
                    </div>
                    <div class="comment-content">
                        <div class="callout"></div>
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
                            <div class="comment-button">
                                <button><i class="fa fa-check"></i> Submit for Review</button>
                                <button class="main"><i class="fa fa-comment"></i> Post Comment</button>
                            </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>