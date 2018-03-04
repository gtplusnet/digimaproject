<div class="table admin">
    <table>
        <thead>
            <tr>
                <th width="150px">PROJECT</th>
                <th>TITLE</th>
                <th class="text-center" width="250">TAGS</th>
                <th class="text-center" width="100">ASSIGNEE</th>
                <th class="text-center" width="100">Q.A</th>
                <th class="text-center" width="150">DEADLINE</th>
                <th class="text-center" width="80px"></th>
                <th class="text-center" width="80px"></th>
            </tr>
        </thead>
        <tbody>
            @if($_task)
                @foreach($_task as $task)
                <tr>
                    <td>{{ strtoupper($task->project_name) }}</td>
                    <td>{{ $task->task_title }}</td>
                    <td class="text-center">{!! $task->tags !!}</td>
                    <td class="text-center">{!! $task->assignee !!}</td>
                    <td class="text-center">{!! $task->reviewee !!}</td>
                    <td class="text-center">{!! $task->deadline !!}</td>
                    <td class="text-center">
                        @if($task->working)
                            <a href="javascript:" task_id="{{ $task->task_id }}" class="view-task"><i class="fa fa-eye"></i> View</a>
                        @else
                            <a href="javascript:" task_id="{{ $task->task_id }}" class="view-task"><i class="fa fa-clock"></i> Start</a>
                        @endif    
                    </td>
                    <td>
                        <a href="javascript:" task_id="{{ $task->task_id }}" class="edit-task"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">No Result Found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>