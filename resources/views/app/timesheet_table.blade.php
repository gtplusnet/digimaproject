<table class="table table-sm">
    <thead style="background-color: #eee; color: #333; border: none;">
        <tr>
            <th class="text-center">Time In</th>
            <th class="text-center">Time Out</th>
            <th class="text-center">Task</th>
            <th class="text-center">Break</th>
            <th class="text-right">Time Spent</th>
        </tr>
    </thead>
    <tbody>
        @if(!$_timesheet)
            <tr>
                <td colspan="5" class="text-center">NO RECORD FOUND</td>
            </tr>
        @else
            @foreach($_timesheet as $timesheet)
            <tr>
                <td class="text-center">{{ $timesheet->time_in }}</td>
                <td class="text-center">{{ $timesheet->time_out }}</td>
                <td class="text-center">{{ $timesheet->task_id }}</td>
                <td class="text-center">{!! $timesheet->break_span !!}</td>
                <td class="text-right">{{ $timesheet->second_spent }}</td>
            </tr>
            @endforeach
        @endif

        <tfoot>
            <tr>
                <td colspan="3" class="text-right"></td>
                <td class="text-center"><b>{{ $total_break }}</b></td>
                <td class="text-right" style="color: red;"><b>{{ $total_second_spent }}</b></td>
            </tr>
        </tfoot>
    </tbody>
</table>
