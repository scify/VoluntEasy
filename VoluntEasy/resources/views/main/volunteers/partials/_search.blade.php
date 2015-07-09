<!-- Main filters -->
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα', $errors, ['class' => 'form-control input-sm']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('last_name', 'Επώνυμο', $errors, ['class' => 'form-control input-sm']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('email', 'Email', $errors, ['class' => 'form-control input-sm']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
            <button type="submit" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός</button>

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
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('address', 'Διεύθυνση', $errors, ['class' => 'form-control input-sm']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('city', 'Πόλη', $errors, ['class' => 'form-control input-sm', 'id' => 'city', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('country', 'Χώρα', $errors, ['class' => 'form-control input-sm', 'id' => 'country', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('phoneNumber', 'Τηλέφωνο', $errors, ['class' => 'form-control input-sm']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('fax', 'Fax', $errors, ['class' => 'form-control input-sm']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="age">Ηλικιακό Εύρος:</label>
                    <span id="age" style="font-weight:bold;"></span>
                    {!! Form::hidden('age-range', '18-50', ['id' => 'age-range']) !!}
                    <div id="age-slider-range"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('gender_id', 'Φύλο:', $errors, ['class' => 'form-control input-sm', 'type' => 'select',
                    'value' => $genders]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('marital_status_id', 'Οικογενειακή Κατάσταση:', $errors, ['class' =>
                    'form-control input-sm', 'type' => 'select',
                    'value' => $maritalStatuses]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('education_level_id', 'Επίπεδο Εκπαίδευσης:', $errors, ['class' => 'form-control input-sm',
                    'type' =>
                    'select', 'value' => $educationLevels]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('department', 'Σχολή:', $errors, ['class' => 'form-control input-sm']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('unit_id', 'Ανήκει στη μονάδα:', $errors, ['class' => 'form-control input-sm',
                    'type' => 'select', 'value' => $units]) !!}
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
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
