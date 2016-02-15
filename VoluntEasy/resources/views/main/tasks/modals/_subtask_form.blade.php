<input type="hidden" name="taskId" id="taskId" value="">
<input type="hidden" name="actionId" id="actionId" value="{{$action->id}}">

<div class="row">
    <div class="col-md-8">
        {!! Form::formInput('subtask-name', 'Όνομα sub-task: *', $errors, ['class' => 'form-control']) !!}

        <p class="text-danger" id="subtask-name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
    </div>
    <div class="col-md-4">
        <label>Προτεραιότητα:</label>
        <select class="form-control m-b-sm" id="subtask-priorities" name="subtask-priorities">
            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
            <option value="3">{{ trans($lang.'priority-high')}}</option>
            <option value="2">{{ trans($lang.'priority-medium')}}</option>
            <option value="1">{{ trans($lang.'priority-low')}}</option>
        </select>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('subtask-description', 'Περιγραφή sub-task:', $errors,
            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x3']) !!}
        </div>
    </div>
</div>
