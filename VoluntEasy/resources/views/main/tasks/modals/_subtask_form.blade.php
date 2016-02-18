<input type="hidden" name="taskId" id="taskId" value="">
<input type="hidden" name="actionId" id="actionId" value="{{$action->id}}">

<div class="row">
    <div class="col-md-4">
        {!! Form::formInput('subtask-name', 'Όνομα sub-task: *', $errors, ['class' => 'form-control']) !!}

        <p class="text-danger" id="subtask-name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Λήγει στις:</label>
            {!! Form::formInput('subtask-due_date', '', $errors, ['id' => 'subtask-due_date', 'class' => 'form-control
            date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date]) !!}

        </div>
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
            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x2']) !!}
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <p>Χρονοδιάγραμμα εργασιών εθελοντών</p>
    </div>
    <div class="workDates">
        <div class="col-md-4 workDate">
            <p>Ημέρα:</p>

            <div class="form-group">
                {!! Form::formInput('workDates[dates][]', '', $errors, ['class' => 'form-control date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date]) !!}
            </div>
        </div>
        <div class="col-md-4 workHourFrom">
            <p>Από:</p>

            <div class="form-group">
                {!! Form::formInput('workDates[hourFrom][]', '', $errors, ['class' => 'form-control time']) !!}
            </div>
        </div>
        <div class="col-md-4 workHourTo">
            <p>Έως:</p>

            <div class="form-group">
                {!! Form::formInput('workDates[hourTo][]', '', $errors, ['class' => 'form-control time']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <p><a href="#" onclick="addWorkDate()"><i class="fa fa-plus-circle"></i> Προσθήκη διαθεσιμότητας</a></p>
    </div>


</div>


<div class="row">

    <div class="col-md-12">
        <p>Προσθήκη εθελοντών</p>
        <select class="js-states form-control multiple" id="subtaskVolunteers" multiple="multiple"
                name="subtaskVolunteers[]"
                tabindex="-1"
                style="display: none; width: 100%">
            @foreach($allVolunteers as $volunteer)
                <option value="{{ $volunteer->id }}">{{ $volunteer->name}} {{$volunteer->last_name}}</option>
            @endforeach
        </select>

    </div>
</div>
