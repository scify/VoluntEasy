<input type="hidden" name="actionId" id="actionId" value="{{$action->id}}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα task:', $errors, ['class' => 'form-control',
            'required' => 'true']) !!}
            <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <p>Κατάσταση:</p>
            <input type="radio" name="status" id="complete" value="complete">
            <label for="complete">Ολοκληρωμένο</label><br/>
            <input type="radio" name="status" id="incomplete" value="incomplete" checked>
            <label for="incomplete">Μη ολοκληρωμένο</label>
        </div>
    </div>
    <div class="col-md-3">
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
