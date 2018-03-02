<table class="table table-sm">
    <thead style="background-color: #eee; color: #333; border: none;">
        <tr>
            <th class="text-center">Time In</th>
            <th class="text-center">Time Out</th>
            <th class="text-center">Task</th>
            <th class="text-center">Break</th>
            <th class="text-center">Source</th>
            <th class="text-right">Time Spent</th>
        </tr>
    </thead>
    <tbody>
        @if($session_member->member_admin == 1)
         <tr>
            <td class="text-center"><input class="form-control text-right" type="time" value="09:00"></td>
            <td class="text-center"><input class="form-control text-right" type="time" value="18:00"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><input class="form-control text-center" type="text" value="MANUAL ADD"></td>
            <td class="text-right"><button class="btn btn-primary">ADD</button></td>
        </tr>
        @endif

        @if(!$_timesheet)
            <tr>
                <td colspan="6" class="text-center">NO RECORD FOUND</td>
            </tr>
        @else

            @foreach($_timesheet as $timesheet)
            <tr>
                <td class="text-center">{{ $timesheet->time_in }}</td>
                <td class="text-center">{{ $timesheet->time_out }}</td>
                <td class="text-center">{{ $timesheet->task_id }}</td>
                <td class="text-center">{!! $timesheet->break_span !!}</td>
                <td class="text-center">{{ $timesheet->time_detail }}</td>
                <td class="text-right">{{ $timesheet->second_spent }}</td>
            </tr>
            @endforeach

        @endif

        <tfoot>
            <tr>
                <td colspan="3" class="text-right"></td>
                <td class="text-center" style="color: red;"><b>{{ $total_break }}</b></td>
                <td class="text-right"></td>
                <td class="text-right"><b>{{ $total_second_spent }}</b></td>
            </tr>
        </tfoot>
    </tbody>
</table>
