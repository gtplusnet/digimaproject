<form class="form-task-add">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-address-book"></i> Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-sm" style="font-size: 14px;">
            <thead style="background-color: #eee; color: #333; border: none; font-size: 14px;">
                <tr>
                    <th class="text-center">Username</th>
                    <th class="text-center">Last<br>Online</th>
                    <th class="text-center">Estimated<br>Time Out</th>
                    <th class="text-center">Today Render</th>
                    <th class="text-center" width="300px">Working On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($_member as $member)
                <tr>
                    <td class="text-center"><b>{{ '@' . strtolower($member->username) }}</b></td>
                    <td class="text-center">{!! $member->last_online !!}</td>
                    <td class="text-center">{!! $member->estimated_time_out !!}</td>
                    <td class="text-center">{!! $member->today_render !!}</td>
                    <td class="text-center">{!! $member->working !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
