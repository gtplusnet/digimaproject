<table class="table table-sm">
    <thead style="background-color: #eee; color: #333; border: none;">
        <tr>
            <th class="text-center" width="120">Time In</th>
            <th class="text-center" width="120">Time Out</th>
            <th class="text-center">Break</th>
            <th class="text-center" width="180">Source</th>
            <th class="text-center">Time Spent</th>
        </tr>
    </thead>
    <tbody>
        @if($session_member->member_admin == 1)
         <tr>
            <td class="text-center"><input name="time_in" class="form-control text-center" type="text" value="09:00 AM"></td>
            <td class="text-center"><input name="time_out" class="form-control text-center" type="text" value="10:00 AM"></td>
            <td class="text-center"></td>
            <td class="text-center"><input name="time_detail" class="form-control text-center" type="text" value="MANUALLY ADDED"></td>
            <td class="text-center"><button type="submit" class="btn btn-primary save-timesheet-button"><i class="fa fa-save"></i></button></td>
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
                <td class="text-center">{!! $timesheet->break_span !!}</td>
                <td class="text-center">{{ $timesheet->time_detail }}</td>
                <td class="text-center">{{ $timesheet->second_spent }}</td>
            </tr>
            @endforeach

        @endif

        <tfoot>
            <tr>
                <td colspan="2" class="text-right"></td>
                <td class="text-center" style="color: red;"><b>{{ $total_break }}</b></td>
                <td class="text-right"></td>
                <td class="text-center"><b>{{ $total_second_spent }}</b></td>
            </tr>
        </tfoot>
    </tbody>
</table>