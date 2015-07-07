<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('name', '', $errors, ['class' => 'form-control', 'placeholder' => 'Όνομα', 'id' => 'name']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('last_name', '', $errors, ['class' => 'form-control', 'placeholder' => 'Επώνυμο', 'id' => 'last_name']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('email', '', $errors, ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email']) !!}
        </div>

        <div class="form-group">
            {!! Form::formInput('phoneNumber', '', $errors, ['class' => 'form-control', 'placeholder' => 'Τηλέφωνο', 'id' => 'phoneNumber']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('marital_status_id', '', $errors, ['class' => 'form-control', 'type' => 'select',
            'value' => $maritalStatuses, 'id' => 'marital_status_id']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('volunteer_unit_status', 'Unit Status:', $errors, ['class' => 'form-control', 'type' =>
            'select', 'value' => $volunteerStatuses]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="age">Ηλικιακό Έυρος:</label>
            <input type="text" id="age" value="!" style="border:0; font-weight:bold;">
            {!! Form::hidden('age-range', '18-45', ['id' => 'age-range']) !!}
            <div id="age-slider-range"></div>
        </div>
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i></button>
        </div>
    </div>
</div>


