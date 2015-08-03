<div class="row">
    <div class="col-md-12">
        <div class="form-group text-right">
            <select class="js-states form-control" id="userList" multiple="multiple" tabindex="-1"
                    style="display: none; width: 100%">
                @foreach($users as $user)
                <option value="{{ $user->id }}"
                {{ in_array($user->id, $userIds) ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

