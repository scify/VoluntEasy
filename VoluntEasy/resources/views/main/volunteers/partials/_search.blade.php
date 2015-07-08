<!-- Main filters -->
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα', $errors, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::formInput('last_name', 'Επώνυμο', $errors, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::formInput('email', 'Email', $errors, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
        </div>
        <div class="form-group ">
            <button type="submit" id="clear" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group ">
            <p><a href="#" id="showFilters">Περισσότερα Φίλτρα...</a></p>
        </div>
    </div>
</div>


<!-- More filters -->
<div class="row" id="filters" style="display:none;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('address', 'Διεύθυνση', $errors, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('city', 'Πόλη', $errors, ['class' => 'form-control', 'id' => 'city']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('country', 'Χώρα', $errors, ['class' => 'form-control', 'id' => 'country']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('phoneNumber', 'Τηλέφωνο', $errors, ['class' => 'form-control']) !!}

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="age">Ηλικιακό Εύρος:</label>
                    <input type="text" id="age" style="border:0; font-weight:bold;">
                    {!! Form::hidden('age-range', '18-45', ['id' => 'age-range']) !!}
                    <div id="age-slider-range"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('gender_id', 'Φύλο:', $errors, ['class' => 'form-control', 'type' => 'select',
                    'value' => $genders]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('marital_status_id', 'Οικογενειακή Κατάσταση:', $errors, ['class' => 'form-control', 'type' => 'select',
                    'value' => $maritalStatuses]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::formInput('volunteer_unit_status', 'Unit Status:', $errors, ['class' => 'form-control', 'type' =>
                    'select', 'value' => $volunteerStatuses]) !!}
                </div>
            </div>
        </div>
    </div>





</div>


@section('footerScripts')
<script src="{{ asset('assets/js/pages/search.js') }}"></script>

<script>
    $("#showFilters").click(function () {

        $("#filters").toggle();
    });


</script>
@append
