<form class="form-task-add">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-address-book"></i> Manage Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-sm">
            <thead style="background-color: #ddd; color: #333; border: none;">
                <tr>
                    <th class="text-center">Username</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">Last Online</th>
                </tr>
            </thead>
            <tbody>
                @foreach($_member as $member)
                <tr>
                    <td class="text-center"><b>{{ '@' . strtolower($member->username) }}</b></td>
                    <td class="text-center">{{ $member->first_name }}</td>
                    <td class="text-center">{{ $member->last_name }}</td>
                    <td class="text-center">{!! $member->last_online !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>