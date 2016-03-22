<div class="row">
    <div class="col-md-12">
        <div class="form-group text-right">
            <select class="js-states form-control" id="userList" multiple="multiple" name="usersSelect[]" tabindex="-1"
                    style="display: none; width: 100%">
                @foreach($users as $user)
                <option value="{{ $user->id }}"
                {{ isset($userIds) && in_array($user->id, $userIds) ? 'selected' : '' }} name="user-{{$user->id}}">{{ $user->name }} {{ $user->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

