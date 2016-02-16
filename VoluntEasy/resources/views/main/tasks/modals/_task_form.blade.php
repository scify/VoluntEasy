<input type="hidden" name="actionId" id="actionId" value="{{$action->id}}">

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα task:', $errors, ['class' => 'form-control',
            'required' => 'true']) !!}
            <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
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
            {!! Form::formInput('due_date', '', $errors, ['id' => 'due_date', 'class' => 'form-control date', 'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date]) !!}

        </div>
    </div>
    <div class="col-md-4">
        <label>Προτεραιότητα:</label>
        <select class="form-control m-b-sm" id="priorities" name="priority">
            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
            <option value="3">{{ trans($lang.'priority-high')}}</option>
            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
            <option value="1">{{ trans($lang.'priority-low')}}</option>
        </select>

        <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('comments', 'Περιγραφή:', $errors,
            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
        </div>
    </div>
</div>
