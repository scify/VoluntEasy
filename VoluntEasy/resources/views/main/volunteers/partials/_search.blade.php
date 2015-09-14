<!-- Main filters -->
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('last_name', 'Επώνυμο', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('email', 'Email', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('status_id', 'Κατάσταση:', $errors, ['class' =>
            'form-control input-sm searchDropDown', 'type' => 'select',
            'value' => $statuses]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', 'Ανήκει στη μονάδα:', $errors, ['class' => 'form-control input-sm
            searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('my_volunteers', 'Μόνο οι εθελοντές μου', $errors, ['class' => 'form-control search searchCheckbox', 'type'
            => 'checkbox', 'value' => 'true', 'checked' => false]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p><a href="#" id="showFilters">Περισσότερα Φίλτρα...</a></p>
    </div>
</div>

<!-- More filters -->
<div class="row" id="filters" style="display:none;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('address', 'Διεύθυνση', $errors, ['class' => 'form-control input-sm search'])
                    !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('city', 'Πόλη', $errors, ['class' => 'form-control input-sm search', 'id' =>
                    'city', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('country', 'Χώρα', $errors, ['class' => 'form-control input-sm search', 'id' =>
                    'country', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('phoneNumber', 'Τηλέφωνο', $errors, ['class' => 'form-control input-sm search'])
                    !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('fax', 'Fax', $errors, ['class' => 'form-control input-sm search']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="age">Ηλικιακό Εύρος:</label>
                    <span id="age" style="font-weight:bold;"></span>
                    {!! Form::hidden('age-range', '10-90', ['id' => 'age-range']) !!}
                    <div id="age-slider-range"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('gender_id', 'Φύλο:', $errors, ['class' => 'form-control input-sm
                    searchDropDown', 'type' => 'select',
                    'value' => $genders]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('marital_status_id', 'Οικογενειακή Κατάσταση:', $errors, ['class' =>
                    'form-control input-sm searchDropDown', 'type' => 'select',
                    'value' => $maritalStatuses]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('education_level_id', 'Επίπεδο Εκπαίδευσης:', $errors, ['class' => 'form-control
                    input-sm searchDropDown',
                    'type' =>
                    'select', 'value' => $educationLevels]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('department', 'Σχολή:', $errors, ['class' => 'form-control input-sm search'])
                    !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('interest_id', 'Ενδιαφέροντα:', $errors, ['class' => 'form-control input-sm
                    searchDropDown',
                    'type' => 'select', 'value' => $interests]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('rating_id', 'Αξιολόγηση:', $errors, ['class' => 'form-control input-sm
                    searchDropDown',
                    'type' => 'select', 'value' => $ratings]) !!}
                </div>
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
<div class="row">
    <div class="col-md-12">
        <div class="form-group ">
            <div class="form-group ">
                <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση
                </button>
                <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός
                </button>
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
