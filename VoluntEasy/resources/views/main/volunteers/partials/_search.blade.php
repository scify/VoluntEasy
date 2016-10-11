<!-- Main filters -->
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', trans('entities/volunteers.name').':', $errors, ['class' => 'form-control
            input-sm search volunteer name', 'placeholder' => '...']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('last_name', trans('entities/volunteers.lastName').':', $errors, ['class' =>
            'form-control input-sm search volunteer lastName', 'placeholder' => '...']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('email', trans('entities/volunteers.email').':', $errors, ['class' => 'form-control
            input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('status_id', trans('entities/volunteers.status').':', $errors, ['class' =>
            'form-control input-sm searchDropDown', 'type' => 'select',
            'value' => $statuses]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', trans('entities/volunteers.belongsTo').':', $errors, ['class' =>
            'form-control input-sm
            searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('my_volunteers', trans('entities/volunteers.onlyMyVolunteers'), $errors, ['class' =>
            'form-control search searchCheckbox', 'type'
            => 'checkbox', 'value' => '1', 'checked' => false]) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('contract_date', trans('entities/volunteers.withContractDate'), $errors, ['class' =>
            'form-control search searchCheckbox', 'type'
            => 'checkbox', 'value' => '1', 'checked' => false]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p><a href="#" id="showFilters">{{ trans('entities/volunteers.moreFilters') }}</a></p>
    </div>
</div>

<!-- More filters -->
<div class="row" id="filters" style="display:none;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('address', trans('entities/volunteers.address').':', $errors, ['class' =>
                    'form-control input-sm search', 'id' =>'address']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('city', trans('entities/volunteers.city').':', $errors, ['class' =>
                    'form-control input-sm
                    searchDropDown getValue',
                    'type' => 'select', 'data-name' => 'city', 'value' => $cities]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('country', trans('entities/volunteers.country').':', $errors, ['class' =>
                    'form-control input-sm
                    searchDropDown getValue',
                    'type' => 'select', 'data-name' => 'country', 'value' => $countries]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('phoneNumber', trans('entities/volunteers.phoneNumber').':', $errors, ['class'
                    => 'form-control input-sm search'])
                    !!}
                </div>
            </div>
            @if(env('MODE') !== 'municipality')
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('fax', trans('entities/volunteers.fax').':', $errors, ['class' => 'form-control
                    input-sm search']) !!}
                </div>
            </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="age">{{ trans('entities/volunteers.ageRange') }}:</label>
                    <span id="age" style="font-weight:bold;"></span>
                    {!! Form::hidden('age-range', '10-90', ['id' => 'age-range']) !!}
                    <div id="age-slider-range"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('gender_id', trans('entities/volunteers.gender').':', $errors, ['class' =>
                    'form-control input-sm
                    searchDropDown', 'type' => 'select',
                    'value' => $genders]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('marital_status_id', trans('entities/volunteers.maritalStatus').':', $errors,
                    ['class' =>
                    'form-control input-sm searchDropDown', 'type' => 'select',
                    'value' => $maritalStatuses]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('interest_id', trans('entities/volunteers.interests').':', $errors, ['class' =>
                    'form-control input-sm
                    searchDropDown',
                    'type' => 'select', 'value' => $interests]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('education_level_id', trans('entities/volunteers.educationLevel').':', $errors,
                    ['class' => 'form-control
                    input-sm searchDropDown',
                    'type' =>
                    'select', 'value' => $educationLevels]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('specialty', trans('entities/volunteers.specialty').':', $errors, ['class' =>
                    'form-control input-sm search volunteer specialty', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('department', trans('entities/volunteers.department').':', $errors, ['class' =>
                    'form-control input-sm search volunteer department', 'placeholder' => '...']) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('workStatus', trans('entities/volunteers.workStatus').':', $errors, ['class' =>
                    'form-control input-sm
                    searchDropDown', 'type' => 'select',
                    'value' => $workStatuses]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('work_description', trans('entities/volunteers.workDescription').':', $errors,
                    ['class' => 'form-control input-sm search volunteer workDescription', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('participation_actions', trans('entities/volunteers.volunteeringOrg').':',
                    $errors, ['class' => 'form-control input-sm search volunteer participationΑctions', 'placeholder' =>
                    '...']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('driver_license_type_id', trans('entities/volunteers.driverLicenceType').':',
                    $errors, ['class' => 'form-control input-sm
                    searchDropDown',
                    'type' => 'select', 'value' => $driverLicenseTypes]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('additional_skills', trans('entities/volunteers.additionalSkillsHalf').':',
                    $errors, ['class' => 'form-control input-sm search volunteer additionalSkills', 'placeholder' =>
                    '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="languages">{{ trans('entities/volunteers.foreignLanguages') }}:</label>
                    <select class="js-states form-control" id="languages" multiple="multiple" name="languages[]"
                            tabindex="-1"
                            style="display: none; width: 100%">
                        @foreach($languages as $id => $lang)
                        <option value="{{ $id }}" name="lang-{{ $id }}">{{$lang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('extra_lang', trans('entities/volunteers.extraLanguages').':', $errors, ['class'
                    => 'form-control input-sm search volunteer extraLang', 'placeholder' => '...']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('computer_usage', trans('entities/volunteers.computerUsage'), $errors, ['class' =>
                    'form-control search searchCheckbox', 'type'
                    => 'checkbox', 'value' => '1', 'checked' => false]) !!}
                </div>
            </div>
            @if(env('MODE') !== 'municipality')
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('computer_usage_comments', trans('entities/volunteers.computerUsageComments').':', $errors, ['class'
                    => 'form-control input-sm search volunteer computerUsageComments', 'placeholder' => '...']) !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group ">
            <div class="form-group ">
                <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> {{
                    trans('default.search') }}
                </button>
                <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> {{
                    trans('default.clear') }}
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

    $('#languages').select2();
</script>
@append
