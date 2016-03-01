<input type="hidden" name="actionId" class="actionId" value="{{$action->id}}">
<input type="hidden" name="taskId" class="taskId" value="">

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα task:', $errors, ['class' => 'form-control name',
            'required' => 'true']) !!}
            <p class="text-danger name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
        </div>
    </div>
    {{--
    <div class="col-md-4">
        <div class="form-group">
            <label>Κατάσταση:</label>
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
            <label>Λήγει στις:</label>
            {!! Form::formInput('due_date', '', $errors, ['class' => 'form-control date due_date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date]) !!}

        </div>
    </div>
    <div class="col-md-4">
        <label>Προτεραιότητα:</label>
        <select class="form-control m-b-sm priorities" name="priority">
            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
            <option value="3">{{ trans($lang.'priority-high')}}</option>
            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
            <option value="1">{{ trans($lang.'priority-low')}}</option>
        </select>

        <p class="text-danger" class="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('description', 'Περιγραφή:', $errors,
            ['class' => 'form-control description', 'type' => 'textarea', 'size' => '2x5']) !!}
        </div>
    </div>
</div>