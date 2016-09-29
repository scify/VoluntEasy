<html>
<head>
    {{-- bootstrap --}}
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>

    {{-- bootstrap datepicker css --}}
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ asset('/' . env('MODE') . '/css/volunteer_public_form.css') }}" rel="stylesheet"/>
</head>
<body>

{!! Form::open(['id' => 'volunteer-form', 'method' => 'POST', 'action' =>
    ['VolunteerController@postPublicFormRequestToBecomeVolunteer']]) !!}

<div>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.personalInfoCaps')
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="amka-wrapper">
                <label for="amka">@lang('entities/volunteers.amka'):</label>
                @if($errors->has('amka'))
                    <p class="error">{{ $errors->first('amka') }}</p>
                @endif
                <input type="text" name="amka" value="{{ old('amka') }}" size="20"
                       class="form-text">
            </div>
            <div class="form-item" id="first-name-wrapper">
                <label for="name">@lang('entities/volunteers.name'):
                    <span class="form-required" title="@lang('entities/volunteers.requiredField')">*</span>
                </label>
                @if($errors->has('name'))
                    <p class="error">{{ $errors->first('name') }}</p>
                @endif
                <input type="text" name="name" value="{{ old('name') }}" size="20"
                       class="form-text required">
                <div class="description">@lang('entities/volunteers.fillName')</div>
            </div>
            <div class="form-item" id="last-name-wrapper">
                <label for="last_name">@lang('entities/volunteers.lastName'):
                    <span class="form-required" title="@lang('entities/volunteers.requiredField')">*</span>
                </label>
                @if($errors->has('last_name'))
                    <p class="error">{{ $errors->first('last_name') }}</p>
                @endif
                <input type="text" name="last_name" size="40"
                       value="{{ old('last_name') }}"
                       class="form-text required">
                <div class="description">@lang('entities/volunteers.fillLastName')</div>
            </div>
            <div class="form-item" id="fathers-name-wrapper">
                <label for="fathers_name">@lang('entities/volunteers.fathersName'): <span class="form-required"
                                                              title="@lang('entities/volunteers.requiredField')">*</span></label>
                @if($errors->has('fathers_name'))
                    <p class="error">{{ $errors->first('fathers_name') }}</p>
                @endif
                <input type="text" name="fathers_name" size="20"
                       value="{{ old('fathers_name') }}"
                       class="form-text required">
                <div class="description">@lang('entities/volunteers.fillFathersName')</div>
            </div>
            <div class="form-item" id="identification-type-wrapper">
                <label for="identification_type_id">@lang('entities/volunteers.idType'): </label>
                <select name="identification_type_id" class="form-select">
                    @foreach($identificationTypes as $key => $value)
                        @if($key !== 0)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-item" id="identification-num-wrapper">
                @if($errors->has('identification_num'))
                    <p class="error">{{ $errors->first('identification_num') }}</p>
                @endif
                <input type="text" name="identification_num" size="20"
                       value="{{ old('identification_num') }}"
                       class="form-text">
                <div class="description">@lang('entities/volunteers.fillIdentity')
                </div>
            </div>
            <div class="container-inline-date date-clear-block">
                <div class="form-item" id="birth-date-wrapper">
                    <label for="birth_date">@lang('entities/volunteers.birthDate'): <span class="form-required"
                                                                       title="@lang('entities/volunteers.requiredField')">*</span></label>
                    @if($errors->has('birth_date'))
                        <p class="error">{{ $errors->first('birth_date') }}</p>
                    @endif
                    <input type="text" name="birth_date" value="{{ old('birth_date') }}">
                    <div class="description">DD-MM-YYYY</div>
                </div>
            </div>
            <div class="form-item">
                <label>@lang('entities/volunteers.gender'): <span class="form-required" title="@lang('entities/volunteers.requiredField')">*
                    </span></label>
                @if($errors->has('gender_id'))
                    <p class="error">{{ $errors->first('gender_id') }}</p>
                @endif
                <div class="form-radios">
                @foreach($genders as $genderKey => $gender)
                    @if($genderKey != 0)
                    <div class="form-item" id="gender-{{ $gender }}-wrapper">
                        <label class="option" for="gender-{{ $gender }}"><input type="radio" id="gender-{{ $gender }}"
                                                                       name="gender_id" value="{{ $genderKey }}"
                                                                       class="form-radio">
                            {{ $gender }}</label>
                    </div>
                    @endif
                @endforeach
                </div>
            </div>
            {{--<div class="form-item" id="marital-status-wrapper">--}}
                {{--<label for="marital_status_id">@lang('entities/volunteers.maritalStatus'): </label>--}}
                {{--@if($errors->has('marital_status_id'))--}}
                    {{--<p class="error">{{ $errors->first('marital_status_id') }}</p>--}}
                {{--@endif--}}
                {{--<select name="marital_status_id" class="form-select">--}}
                    {{--@foreach($maritalStatuses as $key => $value)--}}
                        {{--<option value="{{ $key }}" @if($key === 0) selected="selected" @endif>{{ $value }}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="form-item" id="children-wrapper">--}}
                {{--<label for="children">@lang('entities/volunteers.childNum'): </label>--}}
                {{--@if($errors->has('children'))--}}
                    {{--<p class="error">{{ $errors->first('children') }}</p>--}}
                {{--@endif--}}
                {{--<input type="text" name="children" size="2" value="{{ old('children') }}"--}}
                       {{--class="form-text">--}}
            {{--</div>--}}
            <div class="form-item" id="address-wrapper">
                <label for="address">@lang('entities/volunteers.address'): </label>
                @if($errors->has('address'))
                    <p class="error">{{ $errors->first('address') }}</p>
                @endif
                <input type="text" maxlength="100" name="address" size="60"
                       value="{{ old('address') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="post-box-wrapper">
                <label for="post_box">@lang('entities/volunteers.postBox').: </label>
                @if($errors->has('post_box'))
                    <p class="error">{{ $errors->first('post_box') }}</p>
                @endif
                <input type="text" name="post_box" size="6" value="{{ old('post_box') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="city-wrapper">
                <label for="city">@lang('entities/volunteers.city'): </label>
                @if($errors->has('city'))
                    <p class="error">{{ $errors->first('city') }}</p>
                @endif
                <input type="text" name="city" size="50" value="{{ old('city') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="country-wrapper">
                <label for="country">@lang('entities/volunteers.country'): </label>
                @if($errors->has('country'))
                    <p class="error">{{ $errors->first('country') }}</p>
                @endif
                <input type="text" name="country" size="50" value="{{ old('country') }}"
                       class="form-text">
            </div>
            {{--<div class="form-item" id="live-in-curr-country-wrapper">--}}
                {{--<label class="option" for="live_in_curr_country"><input type="checkbox" name="live_in_curr_country"--}}
                                                                        {{--id="live_in_curr_country"--}}
                                                                        {{--value="1"--}}
                                                                        {{--checked="checked" class="form-checkbox">--}}
                    {{--@lang('entities/volunteers.livesInCurrCountry')</label>--}}
                {{--<div class="description">@lang('entities/volunteers.livesInCurrCountryExpl')</div>--}}
            {{--</div>--}}
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.contactInfoCaps')
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="home-tel-wrapper">
                <label for="home_tel">@lang('entities/volunteers.homeTel'): </label>
                @if($errors->has('home_tel'))
                    <p class="error">{{ $errors->first('home_tel') }}</p>
                @endif
                <input type="text" name="home_tel" size="15"
                       value="{{ old('home_tel') }}" class="form-text">
            </div>
            <div class="form-item" id="work-tel-wrapper">
                <label for="work_tel">@lang('entities/volunteers.workTel'): </label>
                @if($errors->has('work_tel'))
                    <p class="error">{{ $errors->first('work_tel') }}</p>
                @endif
                <input type="text" name="work_tel" size="15"
                       value="{{ old('work_tel') }}" class="form-text">
            </div>
            <div class="form-item" id="cell-tel-wrapper">
                <label for="cell_tel">@lang('entities/volunteers.cellTel'): </label>
                @if($errors->has('cell_tel'))
                    <p class="error">{{ $errors->first('cell_tel') }}</p>
                @endif
                <input type="text" name="cell_tel" size="15"
                       value="{{ old('cell_tel') }}"
                       class="form-text">
            </div>
            {{--<div class="form-item" id="fax-wrapper">--}}
                {{--<label for="fax">@lang('entities/volunteers.fax'): </label>--}}
                {{--@if($errors->has('fax'))--}}
                    {{--<p class="error">{{ $errors->first('fax') }}</p>--}}
                {{--@endif--}}
                {{--<input type="text" name="fax" size="15" value="{{ old('fax') }}"--}}
                       {{--class="form-text">--}}
            {{--</div>--}}
            <div class="form-item" id="email-wrapper">
                <label for="email">@lang('entities/volunteers.email'): <span class="form-required"
                                                title="@lang('entities/volunteers.requiredField')">*</span></label>
                @if($errors->has('email'))
                    <p class="error">{{ $errors->first('email') }}</p>
                @endif
                <input type="text" name="email" size="50" value="{{ old('email') }}"
                       class="form-text required">
                <div class="description">@lang('entities/volunteers.fillEmail')</div>
            </div>
            <div class="form-item" id="comm-method-wrapper">
                <label for="comm_method_id">@lang('entities/volunteers.preferredContactWay'): </label>
                <select name="comm_method_id" class="form-select">
                    @foreach($commMethod as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.educationAndSkillsCaps')
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="education-level-wrapper">
                <label for="education_level_id">@lang('entities/volunteers.educationLevel'): <span class="form-required"
                                                                           title="@lang('entities/volunteers.requiredField')">*</span></label>
                @if($errors->has('education_level_id'))
                    <p class="error">{{ $errors->first('education_level_id') }}</p>
                @endif
                <select name="education_level_id" class="form-select required">
                    @foreach($edLevel as $key => $value)
                        <option value="@if($key !== 0){{ $key }}@endif">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="description">@lang('entities/volunteers.fillEducation')</div>
            </div>
            <div class="form-item" id="specialty-wrapper">
                <label for="specialty">@lang('entities/volunteers.specialty'): </label>
                @if($errors->has('specialty'))
                    <p class="error">{{ $errors->first('specialty') }}</p>
                @endif
                <input type="text" name="specialty" size="50"
                       value="{{ old('specialty') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="department-wrapper">
                <label for="department">@lang('entities/volunteers.department'): </label>
                @if($errors->has('department'))
                    <p class="error">{{ $errors->first('department') }}</p>
                @endif
                <input type="text" name="department" size="50"
                       value="{{ old('department') }}" class="form-text">
            </div>
            <fieldset>
                <legend>@lang('entities/volunteers.foreignLanguages')</legend>
                @foreach($languages as $languageKey => $language)
                    <div class="form-item">
                        <label>{{ $language }}: </label>
                        <div class="form-radios">
                        @foreach($langLevels as $levelKey => $langLevel)
                            <div class="form-item" id="{{ $language . "-" . $langLevel }}-wrapper">
                                <label class="option" for="{{ $language . "-" . $langLevel }}"><input type="radio"
                                                                               id="{{ $language . "-" . $langLevel }}"
                                                                               name="lang[{{ $languageKey }}]" value="{{ $levelKey }}"
                                                                               class="form-radio">
                                    {{ $langLevel }}</label>
                            </div>
                        @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="fieldset-wrapper">
                    <div class="form-item" id="extra-lang-wrapper">
                        <label for="extra_lang">@lang('entities/volunteers.extraLanguages'):</label>
                        @if($errors->has('extra_lang'))
                            <p class="error">{{ $errors->first('extra_lang') }}</p>
                        @endif
                        <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="extra_lang"
                                                                        class="form-textarea resizable"></textarea>
                        </span>
                        </div>
                        <div class="description">@lang('entities/volunteers.extraLanguagesExpl')</div>
                    </div>
                </div>
            </fieldset>
            <div class="form-item" id="driver-license-type-wrapper">
                <label for="driver_license_type_id">@lang('entities/volunteers.driverLicenceType'): </label>
                @if($errors->has('driver_licence_type_id'))
                    <p class="error">{{ $errors->first('driver_licence_type_id') }}</p>
                @endif
                <select name="driver_license_type_id" class="form-select">
                    @foreach($driverLicenseTypes as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="description">@lang('entities/volunteers.fillDriverLicence')</div>
            </div>
            <div class="form-item" id="computer-usage-wrapper">
                <label class="option" for="computer_usage"><input type="checkbox" name="computer_usage"
                                                                  id="computer_usage"
                                                                  value="1" class="form-checkbox">
                    @lang('entities/volunteers.computerUsage')</label>
                <input type="hidden" name="computer_usage_comments" value="">
            </div>
            <div class="form-item" id="additional-skills-wrapper">
                <label for="additional_skills">@lang('entities/volunteers.additionalSkills'): </label>
                @if($errors->has('additional_skills'))
                    <p class="error">{{ $errors->first('additional_skills') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="additional_skills"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">@lang('entities/volunteers.additionalSkillsExp')
                </div>
            </div>
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.workExpCaps')
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="work-status-wrapper">
                <label for="work_status_id">@lang('entities/volunteers.workStatus'): <span class="form-required"
                                                                       title="@lang('entities/volunteers.requiredField')">*</span></label>
                @if($errors->has('work_status_id'))
                    <p class="error">{{ $errors->first('work_status_id') }}</p>
                @endif
                <select name="work_status_id" class="form-select required">
                    @foreach($workStatuses as $key => $value)
                        <option value="@if($key !== 0){{ $key }}@endif">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-item" id="work-description-wrapper">
                <label for="work_description">@lang('entities/volunteers.workDescription'): </label>
                @if($errors->has('work_description'))
                    <p class="error">{{ $errors->first('work_description') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="work_description"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">@lang('entities/volunteers.workDescriptionExpl')</div>
            </div>
        </div>

    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.volunteeringExpCaps')
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="participation-reason-wrapper">
                <label for="participation_reason">@lang('entities/volunteers.participationReason'): <span class="form-required"
                                                                         title="@lang('entities/volunteers.requiredField')">*</span></label>
                @if($errors->has('participation_reason'))
                    <p class="error">{{ $errors->first('participation_reason') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_reason"
                                                                class="form-textarea resizable required"></textarea>
                        </span>
                </div>
                <div class="description">@lang('entities/volunteers.participationReasonExpl')</div>
            </div>
            <div class="form-item" id="participation-actions-wrapper">
                <label for="participation_actions">@lang('entities/volunteers.volunteeringOrg'): </label>
                @if($errors->has('participation_actions'))
                    <p class="error">{{ $errors->first('participation_actions') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_actions"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">@lang('entities/volunteers.volunteeringOrgExpl')
                </div>
            </div>
            <div class="form-item" id="participation-previous-wrapper">
                <label for="participation_previous">@lang('entities/volunteers.volunteeringPrev'): </label>
                @if($errors->has('participation_previous'))
                    <p class="error">{{ $errors->first('participation_previous') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_previous"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">@lang('entities/volunteers.volunteeringPrevExpl')
                </div>
            </div>
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.availabilityCaps')
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="availability-freqs-wrapper">
                <label for="availability_freqs_id">@lang('entities/volunteers.contributionRate'): </label>
                @if($errors->has('availability_freqs_id'))
                    <p class="error">{{ $errors->first('availability_freqs_id') }}</p>
                @endif
                <select name="availability_freqs_id" class="form-select">
                    @foreach($availabilityFreqs as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-item">
                <label>@lang('entities/volunteers.availabilityTimes'): </label>
                <div class="form-checkboxes">
                @foreach($availabilityTimes as $timeKey => $availabilityTime)
                    <div class="form-item" id="contribution-time-{{ $availabilityTime }}-wrapper">
                        <label class="option" for="contribution_time_{{ $availabilityTime }}"><input type="checkbox"
                                                                                     name="contribution_time[{{ $availabilityTime }}]"
                                                                                     id="contribution_time_{{ $availabilityTime }}"
                                                                                     value="{{ $timeKey }}"
                                                                                     class="form-checkbox">
                            {{  \Lang::get('entities/volunteers.' . $availabilityTime) }}</label>
                    </div>
                @endforeach
                </div>
            </div>
        </div>

    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            @lang('entities/volunteers.interestsCaps')
        </legend>
        <div class="fieldset-wrapper">
        @foreach($interestCategories as $interestCategory)
            @foreach($interestCategory->interests as $interest)
                <div class="form-item" id="edit-{{ $interest->description }}-wrapper">
                    <label class="option" for="interest{{ $interest->id }}"><input type="checkbox"
                                                                                      name="interest{{ $interest->id }}"
                                                                                      id="interest{{ $interest->id }}"
                                                                                      value="{{ $interest->id }}" class="form-checkbox">
                        {{ $interest->description }}</label>
                </div>
            @endforeach
        @endforeach
        </div>
    </fieldset>

    <br>
    <a href="#" class="intlink" data-toggle="modal" data-target="#oroi">
        <strong>@lang('entities/volunteers.termsConditions')</strong>
    </a>

    <div class="modal fade" id="oroi" tabindex="-1" role="dialog" aria-labelledby="terms">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @lang('entities/volunteers.termsText')
                </div>
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-item" id="edit-oroi-wrapper">
        <label class="option" for="terms">
            @if($errors->has('terms'))
                <p class="error">{{ $errors->first('terms') }}</p>
            @endif
            <input type="checkbox" name="terms" id="terms" value="1"
                                                 class="form-checkbox required"> @lang('entities/volunteers.agree')</label>
    </div>


    @lang('entities/volunteers.privacyText')<br>
    <div class="readon"><input class="button" type="submit" name="op" id="edit-submit" value="@lang('entities/volunteers.send')"></div>
    <p class="success @if(isset($hide) && $hide === 'true') hide @endif">@lang('entities/volunteers.successMessage')</p>
    <input type="hidden" name="comments" value="">

</div>


{!! Form::close() !!}

<script src="{{ asset('/assets/plugins/jquery/jquery-2.1.3.min.js') }}"></script>

{{-- bootstrap js --}}
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- bootstrap datepicker js --}}
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.el.js')}}"></script>

{{-- custom js --}}
<script src="{{ asset('/' . env('MODE') . '/js/volunteer_public_form.js') }}"></script>

</body>
</html>
