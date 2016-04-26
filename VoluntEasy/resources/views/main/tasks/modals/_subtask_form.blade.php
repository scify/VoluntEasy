<input type="hidden" name="taskId" class="taskId" value="">
<input type="hidden" name="actionId" class="actionId" value="{{$action->id}}">
<input type="hidden" name="subTaskId" class="subTaskId" value="">

<div class="row">
    <div class="col-md-4">
        {!! Form::formInput('subtask-name', trans('entities/subtasks.name').':', $errors, ['class' => 'form-control
        name', 'required' =>
        'true']) !!}

        <p class="text-danger subtask-name_err" style="display:none;">{{ trans('entities/subtasks.fillField') }}</p>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>{{ trans('entities/subtasks.expiresAt') }}:</label>
            {!! Form::formInput('subtask-due_date', '', $errors, ['id' => 'subtask-due_date', 'class' => 'form-control
            date due_date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date])
            !!}

        </div>
    </div>
    <div class="col-md-4">
        <label>{{ trans('entities/subtasks.priority') }}:</label>
        <select class="form-control m-b-sm subtask-priorities" name="subtask-priorities">
            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
            <option value="3">{{ trans($lang.'priority-high')}}</option>
            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
            <option value="1">{{ trans($lang.'priority-low')}}</option>
        </select>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('subtask-description', trans('entities/subtasks.description').':', $errors,
            ['class' => 'form-control description', 'type' => 'textarea', 'size' => '2x5']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>
                {!! Form::formInput('assignToSubtask','', $errors, ['class' => 'form-control assignToSubtask '.$mode, 'type' =>
                'radio', 'value' => 'user', 'checked' => 'false']) !!} {{trans('entities/tasks.assignToUser')}}
            </label>
        </div>
        <div class="form-group">
            <select class="form-control m-b-sm subtaskUserSelect {{$mode}}" name="subtaskUserSelect" disabled>
                @foreach($usersToAssign as $id=>$user)
                <option value="{{$id}}">{{ $user }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">

            <label>
                {!! Form::formInput('assignToSubtask', '' , $errors, ['class' => 'form-control assignToSubtask '.$mode, 'type' =>
                'radio', 'value' => 'volunteer', 'checked' => 'false']) !!}
                {{trans('entities/tasks.assignToVolunteer')}}
            </label>
        </div>
        <div class="form-group">
            <select class="form-control m-b-sm subtaskVolunteerSelect {{$mode}}" name="subtaskVolunteerSelect" disabled>
                @foreach($volunteersToAssign as $id=>$volunteer)
                <option value="{{$id}}">{{ $volunteer }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
