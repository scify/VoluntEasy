<input type="hidden" name="actionId" class="actionId" value="{{$action->id}}">
<input type="hidden" name="taskId" class="taskId" value="">

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::formInput('name', trans('entities/tasks.name').':', $errors, ['class' => 'form-control name',
            'required' => 'true']) !!}
            <p class="text-danger name_err" style="display:none;">{{ trans('entities/tasks.fillField') }}</p>
        </div>
    </div>
    {{--
    <div class="col-md-4">
        <div class="form-group">
            <label>{{ trans('entities/tasks.status') }}:</label>
            <select class="form-control m-b-sm" id="status" name="status">
                @foreach($taskStatuses as $status)
                <option value="{{ $status->id }}">{{ $status->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
    --}}
    <div class="col-md-4">
        <div class="form-group">
            <label>{{ trans('entities/tasks.expires') }}:</label>
            {!! Form::formInput('due_date', '', $errors, ['class' => 'form-control date due_date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date]) !!}

        </div>
    </div>
    <div class="col-md-4">
        <label>{{ trans('entities/tasks.priority') }}:</label>
        <select class="form-control m-b-sm priorities" name="priority">
            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
            <option value="3">{{ trans($lang.'priority-high')}}</option>
            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
            <option value="1">{{ trans($lang.'priority-low')}}</option>
        </select>

        <p class="text-danger" class="name_err" style="display:none;">{{ trans('entities/tasks.fillField') }}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('description', trans('entities/tasks.description').':', $errors,
            ['class' => 'form-control description', 'type' => 'textarea', 'size' => '2x3']) !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>
                {!! Form::formInput('assignToTask','', $errors, ['class' => 'form-control assignToTask '.$mode, 'type' => 'radio', 'value'  => 'user', 'checked' => 'false']) !!} {{trans('entities/tasks.assignToUser')}}
            </label>
        </div>
        <div class="form-group">
            <select class="form-control m-b-sm taskUserSelect {{$mode}}" name="taskUserSelect" disabled>
                @foreach($usersToAssign as $id=>$user)
                    <option value="{{$id}}">{{ $user }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">

            <label>
                {!! Form::formInput('assignToTask', ''  , $errors, ['class' => 'form-control assignToTask '.$mode, 'type' => 'radio', 'value'  => 'volunteer', 'checked' => 'false']) !!} {{trans('entities/tasks.assignToVolunteer')}}
            </label>
        </div>
        <div class="form-group">
            <select class="form-control m-b-sm taskVolunteerSelect {{$mode}}" name="taskVolunteerSelect" disabled>
                @foreach($volunteersToAssign as $id=>$volunteer)
                    <option value="{{$id}}">{{ $volunteer }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
