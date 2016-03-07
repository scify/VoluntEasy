<input type="hidden" name="taskId" class="taskId" value="">
<input type="hidden" name="actionId" class="actionId" value="{{$action->id}}">
<input type="hidden" name="subTaskId" class="subTaskId" value="">

<div class="row">
    <div class="col-md-4">
        {!! Form::formInput('subtask-name', 'Όνομα sub-task:', $errors, ['class' => 'form-control name', 'required' =>
        'true']) !!}

        <p class="text-danger subtask-name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Λήγει στις:</label>
            {!! Form::formInput('subtask-due_date', '', $errors, ['id' => 'subtask-due_date', 'class' => 'form-control
            date due_date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date])
            !!}

        </div>
    </div>
    <div class="col-md-4">
        <label>Προτεραιότητα:</label>
        <select class="form-control m-b-sm subtask-priorities" name="subtask-priorities">
            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
            <option value="3">{{ trans($lang.'priority-high')}}</option>
            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
            <option value="1">{{ trans($lang.'priority-low')}}</option>
        </select>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('subtask-description', 'Περιγραφή sub-task:', $errors,
            ['class' => 'form-control description', 'type' => 'textarea', 'size' => '2x5']) !!}
        </div>
    </div>
</div>


<div class="row todos" style="display:none;">
    <div class="col-md-12">
        <h4><i class="fa fa-check-square-o"></i> To-do <br/><small>Πατήστε το enter για να αποθηκευτεί το to-do</small></h4>

        <form action="javascript:void(0);">
            <input type="text" class="form-control add-task" placeholder="Νέο to-do...">
        </form>
        <div class="todo-list">
        </div>
    </div>
</div>
