<div class="table">
    <table>
        <thead>
            <tr>
                <th width="60"></th>
                <th width="150px">PROJECT</th>
                <th>TITLE</th>
                <th class="text-center" width="250">TAGS</th>
                <th class="text-center" width="150">DEADLINE</th>
                <th class="text-center" width="130px"></th>
            </tr>
        </thead>
        <tbody>
            @if($_task)
                @foreach($_task as $task)
                <tr>
                    <td><input type="checkbox" disabled name=""></td>
                    <td>{{ strtoupper($task->project_name) }}</td>
                    <td>{{ $task->task_title }}</td>
                    <td class="text-center">{!! $task->tags !!}</td>
                    <td class="text-center">{!! $task->deadline !!}</td>
                    <td class="text-center">
                        @if($task->working)
                            <a href="javascript:" task_id="{{ $task->task_id }}" class="view-task"><i class="fa fa-eye"></i> View</a>
                        @else
                            <a href="javascript:" task_id="{{ $task->task_id }}" class="view-task"><i class="fa fa-clock"></i> Start</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">No Result Found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>