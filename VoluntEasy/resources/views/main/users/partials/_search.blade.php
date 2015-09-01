<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('email', 'Email', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', 'Υπεύθυνος στη μονάδα:', $errors, ['class' => 'form-control input-sm searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
            <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός</button>
        </div>
    </div>
</div>

