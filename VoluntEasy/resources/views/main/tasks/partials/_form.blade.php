<input type="hidden" name="actionId" id="actionId" value="{{$actionId}}">
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
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            {!! Form::formInput('description', 'Περιγραφή:', $errors,
            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group text-right">
            {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'saveAction']) !!}
        </div>
    </div>
</div>
