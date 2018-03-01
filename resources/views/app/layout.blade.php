<!DOCTYPE html>
<html>
    <head>
        <title>Digima Timer</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app_layout.css ">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    </head>
    <body>
        <div class="idle-cover" style="display: none;">
            <button class="btn btn-danger resume-work"><strong><i class="fa fa-exclamation-triangle"></i> You were tagged as IDLE.</strong><br>Click HERE to resume work now.<br></button>
        </div>
        <div class="status-helper"></div>
        <div class="timer-counter" idle_allowed="{{ $session_member->member_idle_allowed }}" current_task="{{ $session_member->member_task }}" time_spent_today="{{ $time_spent_today }}" hours="{{ date('H') }}" minutes="{{ date('i') }}" seconds="{{ date('s') }}">
            <div class="timer-countdown-label">TIME SPENT TODAY</div>
            <div class="timer-countdown">00:00:00</div>
            <div class="idle-countdown">00:00:00 AM</div>
            <div style="display: none;" class="idle-time">0</div>
            <button class="time-button"><i class="fa fa-user-circle"></i> {{ strtoupper($session_member->first_name) }} {{ strtoupper($session_member->last_name) }}</button>
            <button class="logout-button" onclick="location.href='/logout'">LOGOUT</button>
        </div>
        <div class="task-container">
            <div class="title">
                @if($session_member->member_admin == 1)
                <div class="text"><i class="fa fa-tasks"></i> TASK LIST</div>
                @else
                <div class="text"><i class="fa fa-tasks"></i> ONGOING TASK</div>
                @endif
                <div class="button">
                    <button type="button" class="btn btn-primary refresh-task"><i class="fa fa-sync"></i> REFRESH TASK</button>
                    <button type="button" class="btn btn-primary main add-new-task"><i class="fa fa-plus"></i> ADD NEW TASK</button>
                </div>
            </div> 
            <div class="task-filters">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <select class="form-control filter-assignee">
                            <option value="0">All Employee</option>
                            @foreach($_member as $member)
                            <option {{ $member->member_id == $session_member->member_id ? 'selected' : '' }} value="{{ $member->member_id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2" style="padding-left: 5px;">
                        <select class="form-control filter-project">
                            <option value="0">All Project</option>
                            @foreach($_project as $project)
                            <option value="{{ $project->project_id }}">{{ $project->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2" style="padding-left: 5px;">
                        <select class="form-control filter-tags">
                            <option value="0">All Tags</option>
                            @foreach($_tags as $tags)
                            <option value="{{ $tags->tag_id }}">{{ ucfirst($tags->tag_label) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control task-search" placeholder="Search title of task...">
                    </div>
                </div>
            </div>
            <div class="load-table-ongoing-task-list">

            </div>
        </div>
        <!-- TASK INFORMATION -->
        <div class="modal" id="view_task" tabindex="-1" role="dialog">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content task-view">
                </div>
            </div>
        </div>

        <!-- ADD NEW TASK -->
        <div class="modal " id="add_task" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-add-task">
                </div>
            </div>
        </div>

        <div style="display: none;" class="modal-loader">
            <div class="loader">
                <div class="loading-icon"><i class="fas fa-circle-notch fa-spin"></i></div>
                <div class="loading-text">Loading Form</div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="/js/dashboard.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </body>
</html>