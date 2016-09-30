<div class="tab-content">
<!-- tab1 Ατομικά στοιχεία.-->
<div class="tab-pane active fade in" id="tab1">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('name', trans('entities/volunteers.name').':', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('last_name', trans('entities/volunteers.lastName').':', $errors, ['class' => 'form-control', 'required' => 'true'])
                !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('fathers_name', trans('entities/volunteers.fathersName').':', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('birth_date', trans('entities/volunteers.birthDate').':', $errors, ['class' => 'form-control
                        birthDate', 'id' => 'birth_date', 'required' => 'true']) !!}
                        <small class="help-block text-primary under18" style="display:none;">{{ trans('entities/volunteers.volunteerUnderage') }}
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('gender_id', trans('entities/volunteers.gender').':', $errors, ['class' => 'form-control', 'type' =>
                        'select', 'value' => $genders, 'key' => $volunteer->gender_id]) !!}
                        @else
                        {!! Form::formInput('gender_id', trans('entities/volunteers.gender').':', $errors, ['class' => 'form-control', 'type' =>
                        'select', 'value' => $genders]) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::formInput('address', trans('entities/volunteers.address').':', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('post_box', trans('entities/volunteers.postBox').':', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::formInput('city', trans('entities/volunteers.city').':', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('country', trans('entities/volunteers.country').':', $errors, ['class' => 'form-control']) !!}
            </div>
            @if(env('MODE') !== 'municipality')
            <div class="form-group">
                {!! Form::formInput('live_in_curr_country', trans('entities/volunteers.livesInCurrCountry'), $errors, ['class' => 'form-control',
                'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!} <em>{{ trans('entities/volunteers.livesInCurrCountryExpl') }}</em>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('identification_type_id', trans('entities/volunteers.idType').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $identificationTypes, 'key' =>
                        $volunteer->identification_type_id]) !!}
                        @else
                        {!! Form::formInput('identification_type_id', trans('entities/volunteers.idType').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $identificationTypes]) !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::formInput('identification_num',  trans('entities/volunteers.idNumber').':',
                        $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if(env('MODE') !== 'municipality')
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('afm', trans('entities/volunteers.afm').':',
                        $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
                @else
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('amka', trans('entities/volunteers.amka').':', $errors, ['class' =>
                        'form-control']) !!}
                    </div>
                </div>
                @endif
            </div>
            @if(env('MODE') !== 'municipality')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('marital_status_id', trans('entities/volunteers.maritalStatus').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $maritalStatuses, 'key' =>
                        $volunteer->marital_status_id]) !!}
                        @else
                        {!! Form::formInput('marital_status_id', trans('entities/volunteers.maritalStatus').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $maritalStatuses]) !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('children', trans('entities/volunteers.childNum').':', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- tab2 Στοιχεία επικοινωνίας. -->
<div class="tab-pane fade" id="tab2">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('home_tel',  trans('entities/volunteers.homeTel').':', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('work_tel',  trans('entities/volunteers.workTel').':', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('cell_tel',  trans('entities/volunteers.cellTel').':', $errors, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            @if(env('MODE') !== 'municipality')
            <div class="form-group">
                {!! Form::formInput('fax',  trans('entities/volunteers.fax').':', $errors, ['class' => 'form-control']) !!}
            </div>
            @endif
            <div class="form-group">
                {!! Form::formInput('email',  trans('entities/volunteers.email').':', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
            <div class="form-group">
                @if (isset($volunteer))
                {!! Form::formInput('comm_method_id', trans('entities/volunteers.preferredContactWay').':', $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $commMethod, 'key' => $volunteer->comm_method_id]) !!}
                @else
                {!! Form::formInput('comm_method_id', trans('entities/volunteers.preferredContactWay').':', $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $commMethod]) !!}
                @endif
            </div>
        </div>
    </div>
</div>
<!-- tab3 Εκπαίδευση και ικανότητες. -->
<div class="tab-pane fade" id="tab3">
    <div class="row m-b-lg">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('education_level_id', trans('entities/volunteers.educationLevel').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $edLevel, 'key' =>
                        $volunteer->education_level_id, 'required' => 'true']) !!}
                            @if(env('MODE') === 'municipality')
                        <div id="other_education_wrapper" class="@if(intval($volunteer->education_level_id) !== sizeof($edLevel) - 1) hide @endif">
                            <label>@lang('entities/volunteers.other_education_level'):</label>
                            <input name="other_education" class="form-control"
                                   type="text" value="{{ $volunteer->other_education }}" >
                        </div>
                            @endif
                        @else
                        {!! Form::formInput('education_level_id',  trans('entities/volunteers.educationLevel').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $edLevel, 'required' => 'true']) !!}
                            @if(env('MODE') === 'municipality')
                        <div id="other_education_wrapper" class="@if(old('other_education') === "" ||
                                old('other_education') === null) hide @endif
                                @if($errors->has('other_education')) has-error @endif">
                            <label for="other_education">@lang('entities/volunteers.other_education_level'):</label>
                            <input id="other_education" name="other_education" class="form-control" type="text"
                                   value="{{ old('other_education') }}">
                                @if($errors->has('other_education'))
                            <p class="help-block">{{ $errors->first('other_education') }}</p>
                                @endif
                        </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('specialty',  trans('entities/volunteers.specialty').':', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('department', trans('entities/volunteers.department').':', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('driver_license_type_id', trans('entities/volunteers.driverLicenceType').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $driverLicenseTypes, 'key' =>
                        $volunteer->driver_license_type_id]) !!}
                        @else
                        {!! Form::formInput('driver_license_type_id', trans('entities/volunteers.driverLicenceType').':', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $driverLicenseTypes]) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="row top-margin">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage', trans('entities/volunteers.computerUsage'), $errors, ['class' => 'form-control',
                        'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
                    </div>
                    {{-- Extras--}}
                    @if(in_array('knows_office', $extras))
                        @include($extrasPath.'._knows_office')
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage_comments', trans('entities/volunteers.computerUsageComments').':', $errors,
                        ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::formInput('additional_skills', trans('entities/volunteers.additionalSkills').':',
                        $errors,
                        ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <p>{{ trans('entities/volunteers.foreignLanguages') }}:</p>
            @foreach ($languages as $lan => $language)
            <div class="form-group">


                <p> {{ $language . ':' }}</p>
                {!! Form::label('') !!}
                @foreach ($langLevels as $lev => $level)
                <label>
                    <em>{{ $level }}</em>
                    @if (isset($volunteer) && isset($volunteer->lang_levels[$language]) &&
                    $volunteer->lang_levels[$language]==$lev)
                    {!! Form::formInput('lang['.$lan.']', '', $errors, ['class' => 'form-control languages', 'type' =>
                    'radio', 'value'
                    => $lev, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('lang['.$lan.']', '', $errors, ['class' => 'form-control languages', 'type' =>
                    'radio', 'value'
                    => $lev, 'checked' => 'false']) !!}
                    @endif
                </label>

                @endforeach

            </div>
            @endforeach
            <div class="form-group">
                <button class="btn btn-default" id="cleanLanguages">{{ trans('default.clear') }}</button>
            </div>

            <div class="form-group">
                {!! Form::formInput('extra_lang', trans('entities/volunteers.extraLanguages') , $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => trans('entities/volunteers.extraLanguagesExpl'), 'size'
                => '2x3']) !!}
            </div>
        </div>
    </div>
</div>
<!-- tab4 Εργασιακή εμπειρία και εθελοντική προσφορά. -->
<div class="tab-pane fade" id="tab4">
    <div class="row m-b-lg">
        {{-- Extras--}}
        @if(in_array('knows_office', $extras))
            @include($extrasPath.'._work_and_volunteering')
        @else
          @include('main.volunteers.partials.form_defaults._work_and_volunteering')
        @endif
    </div>
</div>
<!-- tab5 Διαθεσιμότητα. -->
<div class="tab-pane fade" id="tab5">
    <div class="row m-b-lg">
        <div class="col-md-6">
            <p>{{ trans('entities/volunteers.interestsArea') }}:</p>

            <table class="table table-condensed table-bordered">
                @foreach($interestCategories as $cat_id => $category)
                <tr>
                    <td>{{ $category->description }}</td>
                    <td>@foreach($category->interests as $interest)
                        <div class="form-group">
                            @if (isset($volunteer) && in_array($interest->id, $volunteer->interests->lists('id')->all())
                            )
                            {!! Form::formInput('interest' . $interest->id, $interest->description , $errors, ['class'
                            =>
                            'form-control',
                            'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'true']) !!}
                            @else
                            {!! Form::formInput('interest' . $interest->id, $interest->description, $errors, ['class' =>
                            'form-control',
                            'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'false']) !!}
                            @endif
                        </div>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-3">
            {{-- Extras--}}
            @if(in_array('availability', $extras))
            @include($extrasPath.'._availability')
            @else
            @include('main.volunteers.partials.form_defaults._availability')
            @endif
        </div>
        @if(env('MODE') === 'municipality')
        <div class="col-md-3">
            <p>{{ trans('entities/volunteers.availabilityTimes') }}:</p>
            <div class="form-group">
                @foreach($availabilityTimes as $timeKey => $availabilityTime)
                    <?php
                        $checked = "";
                        if(isset($volunteer)) {
                            foreach ($volunteer->availabilityTimes as $selectedTime) {
                                if(intval($selectedTime->id) === $timeKey) {
                                    $checked = "checked=\"checked\"";
                                    break;
                                }
                            }
                        }
                    ?>
                    <div class="form-item" id="availability-times-{{ $availabilityTime }}-wrapper">
                        <label class="option" for="availability_times_{{ $availabilityTime }}">
                            <input type="checkbox" name="availability_times[{{ $availabilityTime }}]"
                                  id="availability_times_{{ $availabilityTime }}" value="{{ $timeKey }}"
                                  class="form-checkbox" {{ $checked }}>
                            {{  \Lang::get('entities/volunteers.' . $availabilityTime) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
<!-- tab6 Comments -->
<div class="tab-pane fade" id="tab6">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('comments', trans('entities/volunteers.comments').':', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => trans('entities/volunteers.commentsAboutVolunteer')]) !!}
            </div>

            <div class="form-group">
                 {{-- Extras--}}
                 @if(in_array('knows_office', $extras))
                    @include($extrasPath.'._how_you_learned')
                 @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="form-group">
                    {!! Form::formInput('contract_date', trans('entities/volunteers.contractDate').':', $errors, ['class' => 'form-control
                    date', 'id' => 'contract_date']) !!}
                </div>

                <p>{{ trans('entities/volunteers.excludeFromUnits') }}:</p>

                <select class="js-states form-control" id="unitList" multiple="multiple" name="unitsSelect[]"
                        tabindex="-1"
                        style="display: none; width: 100%">

                    @foreach($units as $unit_id => $unit)
                    <option value="{{ $unit->id }}" name="unit-{{$unit->id}}"
                    {{ isset($volunteer) && in_array($unit->id, $volunteer->unitsExcludes->lists('id')->all()) ?
                    'selected'
                    :
                    '' }} >{{ $unit->description }}</option>

                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {!! Form::formInput('files[]', trans('entities/volunteers.uploadFiles').':', $errors, ['class' => 'form-control', 'type' =>
                'file', 'multiple' => 'true'])
                !!}
                <small class="help-block">{{ trans('entities/volunteers.moreThanOne') }}</small><br/>
                <small class="help-block">{{ trans('entities/volunteers.lessThan10gb') }}</small>
            </div>
            @if(isset($volunteer))
            <div class="form-group">
                @if(sizeof($volunteer->files)>0)
                <p>{{ trans('entities/volunteers.uploadedFiles') }}:</p>

                <table class="table table-condensed table-bordered">

                    @foreach($volunteer->files as $file)
                    <tr>
                        <td><i class="fa fa-file-o"></i> <a
                                href="{{ asset('assets/uploads/volunteers/'.$file->filename) }}" target="_blank">{{
                                $file->filename }}</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
<div class="row m-b-lg text-right">
    <div class="col-md-12">
        {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success']) !!}
    </div>
</div>
</div>

@section('footerScripts')
<script>

    var displayOrHideOtherEducationField = function() {
        //if selected item is the last one display the field, else hide it
        if ($(this).val() === $("#education_level_id").find("option").last().val() &&
                $("#other_education_wrapper").hasClass("hide")) {
            $("#other_education_wrapper").removeClass("hide");
        } else {
            $("#other_education_wrapper").addClass("hide");
        }
    };

    $("#daysTable").hide();


    $('#birth_date').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var birthDate = new Date(selected.date.valueOf());
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        //display message that the volunteer is underage
        if (age < 18)
            $(".under18").show();
        else if (age > 18)
            $(".under18").hide();

    });

    $('.date').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    })

    //initialize user select
    $('#unitList').select2();

    //make an input to send with the form
    $('#unitList').on("select2:select", function (e) {
        id = e.params.data.id;
        input = '<input id="unit' + id + '" name="unit' + id + '" value="' + id + '" hidden/>';
        $("#wizardForm").append(input);
    });

    //remove input when the option is unselected
    $('#unitList').on("select2:unselect", function (e) {
        id = e.params.data.id;
        $("#unit" + id).remove();
    });

    //deselect the languages radio button
    $("#cleanLanguages").click(function (e) {
        $(".languages").parent().removeClass('checked');
        $(".languages").prop('checked', false);
        e.preventDefault();
    });


    $("#availability_freqs_id").change(function () {
        var id = $("#availability_freqs_id option:selected").val();

        if (id == 1) {
            $("#daysTable").hide();
            $("#dailyFrequencies").fadeIn();
        } else {
            $("#dailyFrequencies").hide();
            $("#daysTable").fadeIn();
        }
    });

    //listener on education_level_id changes
    $("#education_level_id").change(displayOrHideOtherEducationField);

    var freqsId = $("#availability_freqs_id option:selected").val();
    if (freqsId == 2 || freqsId == 3 || freqsId == 4) {
        $("#dailyFrequencies").hide();
        $("#daysTable").fadeIn();
    }


</script>
@append
