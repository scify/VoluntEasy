<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('name', '', $errors, ['class' => 'form-control', 'placeholder' => 'Όνομα']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('last_name', '', $errors, ['class' => 'form-control', 'placeholder' => 'Επώνυμο']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('email', '', $errors, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('address', '', $errors, ['class' => 'form-control', 'placeholder' => 'Διεύθυνση']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('city', '', $errors, ['class' => 'form-control', 'placeholder' => 'Πόλη', 'id' => 'city']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('country', '', $errors, ['class' => 'form-control', 'placeholder' => 'Χώρα', 'id' => 'country']) !!}
        </div>

        <div class="form-group">
            {!! Form::formInput('phoneNumber', '', $errors, ['class' => 'form-control', 'placeholder' => 'Τηλέφωνο']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('marital_status_id', '', $errors, ['class' => 'form-control', 'type' => 'select',
            'value' => $maritalStatuses]) !!}
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
            <label for="age">Ηλικιακό Εύρος:</label>
            <input type="text" id="age" style="border:0; font-weight:bold;">
            {!! Form::hidden('age-range', '18-45', ['id' => 'age-range']) !!}
            <div id="age-slider-range"></div>
        </div>
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i></button>
        </div>
    </div>
</div>


@section('footerScripts')
<script src="{{ asset('assets/js/pages/search.js') }}"></script>
@append
