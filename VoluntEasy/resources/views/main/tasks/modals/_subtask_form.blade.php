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
        <h4><i class="fa fa-calendar"></i> Χρονοδιάγραμμα εργασιών εθελοντών</h4>


    <table class="table table-condensed table-bordered table-striped table-striped" id="workDates">
        <thead>
        <th>Ημέρα</th>
        <th>Ώρα από</th>
        <th>Ώρα εώς</th>
        <th># εθελοντών</th>
        <th>Εθελοντές</th>
        <th>Σχόλια</th>
        </thead>
        <tbody>
        <tr class="workDates">
            <td class="workDate col-md-1">{!! Form::formInput('workDates[dates][]', '', $errors, ['class' => 'form-control date datetime',
                'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date, 'data-date-format' => 'dd/mm/yyyy']) !!}
            </td>
            <td class="workHourFrom col-md-1">{!! Form::formInput('workDates[hourFrom][]', '', $errors, ['class' => 'form-control
                time datetime']) !!}
            </td>
            <td class="workHourTo col-md-1">{!! Form::formInput('workDates[hourTo][]', '', $errors, ['class' => 'form-control
                time datetime']) !!}
            </td>
            <td class="comments col-md-1">{!! Form::formInput('workDates[volunteerSum][]', '', $errors, ['class' => 'form-control']) !!}
            </td>
            <td class="volunteers col-md-3">
                <select class="js-states form-control multiple" multiple="multiple"
                        name="workDates[subtaskVolunteers][]"
                        tabindex="-1"
                        style="display: none; width: 100%">
                    @foreach($allVolunteers as $volunteer)
                    <option value="{{ $volunteer->id }}">{{ $volunteer->name}} {{$volunteer->last_name}}</option>
                    @endforeach
                </select>
            </td>
            <td class="comments col-md-3">{!! Form::formInput('workDates[comments][]', '', $errors, ['type' => 'textarea', 'size' => '1x1', 'class' => 'form-control']) !!}
            </td>
        </tr>
        </tbody>
    </table>
    <p class="workError text-danger" style="display:none;">Συμπληρώστε όλα τα πεδία</p>

    <div class="col-md-12">
        <p><a href="#" onclick="addWorkDate()" class="add-dates"><i class="fa fa-plus-circle"></i> Προσθήκη διαθεσιμότητας</a></p>
    </div>
    </div>

</div>
