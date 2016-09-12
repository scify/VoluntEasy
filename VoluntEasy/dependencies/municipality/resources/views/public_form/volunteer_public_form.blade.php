<html>
<head>
    <title>Φόρμα Εθελοντών</title>

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
            ΑΤΟΜΙΚΑ ΣΤΟΙΧΕΙΑ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="first-name-wrapper">
                <label for="name">Όνομα:
                    <span class="form-required" title="Το πεδίο είναι απαραίτητο.">*</span>
                </label>
                @if($errors->has('name'))
                    <p class="error">{{ $errors->first('name') }}</p>
                @endif
                <input type="text" name="name" value="{{ old('name') }}" size="20"
                       class="form-text required">
                <div class="description">Παρακαλώ συμπληρώστε το ονομά σας.</div>
            </div>
            <div class="form-item" id="last-name-wrapper">
                <label for="last_name">Επώνυμο:
                    <span class="form-required" title="Το πεδίο είναι απαραίτητο.">*</span>
                </label>
                @if($errors->has('last_name'))
                    <p class="error">{{ $errors->first('last_name') }}</p>
                @endif
                <input type="text" name="last_name" size="40"
                       value="{{ old('last_name') }}"
                       class="form-text required">
                <div class="description">Παρακαλώ συμπληρώστε το επώνυμο σας.</div>
            </div>
            <div class="form-item" id="fathers-name-wrapper">
                <label for="fathers_name">Όνομα Πατέρα: <span class="form-required"
                                                              title="Το πεδίο είναι απαραίτητο.">*</span></label>
                @if($errors->has('fathers_name'))
                    <p class="error">{{ $errors->first('fathers_name') }}</p>
                @endif
                <input type="text" name="fathers_name" size="20"
                       value="{{ old('fathers_name') }}"
                       class="form-text required">
                <div class="description">Παρακαλώ συμπληρώστε το όνομα του πατέρα σας.</div>
            </div>
            <div class="form-item" id="identification-type-wrapper">
                <label for="identification_type_id">Τύπος Ταυτότητας: </label>
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
                <div class="description">Παρακαλώ συμπληρώστε το Α.Δ.Τ. ή Διαβατηρίου ή Άδεια Παραμονής και επιλέξτε
                    απο την λίστα τον τύπο.
                </div>
            </div>
            <div class="container-inline-date date-clear-block">
                <div class="form-item" id="birth-date-wrapper">
                    <label for="birth_date">Ημερομηνία Γέννησης: <span class="form-required"
                                                                       title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    @if($errors->has('birth_date'))
                        <p class="error">{{ $errors->first('birth_date') }}</p>
                    @endif
                    <input type="text" name="birth_date" value="{{ old('birth_date') }}">
                    <div class="description">DD-MM-YYYY</div>
                </div>
            </div>
            <div class="form-item">
                <label>Φύλο: <span class="form-required" title="Το πεδίο είναι απαραίτητο.">*</span></label>
                @if($errors->has('gender_id'))
                    <p class="error">{{ $errors->first('gender_id') }}</p>
                @endif
                <div class="form-radios">
                    <div class="form-item" id="gender-male-wrapper">
                        <label class="option" for="gender-male"><input type="radio" id="gender-male"
                                                                            name="gender_id" value="1"
                                                                            class="form-radio"> Άνδρας</label>
                    </div>
                    <div class="form-item" id="gender-female-wrapper">
                        <label class="option" for="gender-female"><input type="radio" id="gender-female"
                                                                             name="gender_id" value="2"
                                                                             class="form-radio"> Γυναίκα</label>
                    </div>
                </div>
            </div>
            <div class="form-item" id="marital-status-wrapper">
                <label for="marital_status_id">Οικογενειακή Κατάσταση: </label>
                @if($errors->has('marital_status_id'))
                    <p class="error">{{ $errors->first('marital_status_id') }}</p>
                @endif
                <select name="marital_status_id" class="form-select">
                    @foreach($maritalStatuses as $key => $value)
                        <option value="{{ $key }}" @if($key === 0) selected="selected" @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-item" id="children-wrapper">
                <label for="children">Τέκνα: </label>
                @if($errors->has('children'))
                    <p class="error">{{ $errors->first('children') }}</p>
                @endif
                <input type="text" name="children" size="2" value="{{ old('children') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="address-wrapper">
                <label for="address">Διεύθυνση: </label>
                @if($errors->has('address'))
                    <p class="error">{{ $errors->first('address') }}</p>
                @endif
                <input type="text" maxlength="100" name="address" size="60"
                       value="{{ old('address') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="post-box-wrapper">
                <label for="post_box">Τ.Κ.: </label>
                @if($errors->has('post_box'))
                    <p class="error">{{ $errors->first('post_box') }}</p>
                @endif
                <input type="text" name="post_box" size="6" value="{{ old('post_box') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="city-wrapper">
                <label for="city">Πόλη: </label>
                @if($errors->has('city'))
                    <p class="error">{{ $errors->first('city') }}</p>
                @endif
                <input type="text" name="city" size="50" value="{{ old('city') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="country-wrapper">
                <label for="country">Χώρα: </label>
                @if($errors->has('country'))
                    <p class="error">{{ $errors->first('country') }}</p>
                @endif
                <input type="text" name="country" size="50" value="{{ old('country') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="live-in-curr-country-wrapper">
                <label class="option" for="live_in_curr_country"><input type="checkbox" name="live_in_curr_country"
                                                                        id="live_in_curr_country"
                                                                        value="1"
                                                                        checked="checked" class="form-checkbox">
                    Κάτοικος Ελλάδας</label>
                <div class="description">Αποεπιλέξτε εφόσον δεν διαμένετε μόνιμα στην Ελλάδα</div>
            </div>
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            ΣΤΟΙΧΕΙΑ ΕΠΙΚΟΙΝΩΝΙΑΣ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="home-tel-wrapper">
                <label for="home_tel">Τηλέφωνο Οικίας: </label>
                @if($errors->has('home_tel'))
                    <p class="error">{{ $errors->first('home_tel') }}</p>
                @endif
                <input type="text" name="home_tel" size="15"
                       value="{{ old('home_tel') }}" class="form-text">
            </div>
            <div class="form-item" id="work-tel-wrapper">
                <label for="work_tel">Τηλέφωνο Εργασίας: </label>
                @if($errors->has('work_tel'))
                    <p class="error">{{ $errors->first('work_tel') }}</p>
                @endif
                <input type="text" name="work_tel" size="15"
                       value="{{ old('work_tel') }}" class="form-text">
            </div>
            <div class="form-item" id="cell-tel-wrapper">
                <label for="cell_tel">Κινητό: </label>
                @if($errors->has('cell_tel'))
                    <p class="error">{{ $errors->first('cell_tel') }}</p>
                @endif
                <input type="text" name="cell_tel" size="15"
                       value="{{ old('cell_tel') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="fax-wrapper">
                <label for="fax">Fax: </label>
                @if($errors->has('fax'))
                    <p class="error">{{ $errors->first('fax') }}</p>
                @endif
                <input type="text" name="fax" size="15" value="{{ old('fax') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="email-wrapper">
                <label for="email">email: <span class="form-required"
                                                title="Το πεδίο είναι απαραίτητο.">*</span></label>
                @if($errors->has('email'))
                    <p class="error">{{ $errors->first('email') }}</p>
                @endif
                <input type="text" name="email" size="50" value="{{ old('email') }}"
                       class="form-text required">
                <div class="description">Συμπληρώστε την διεύθυνση στην μορφή "xxx@xxx.xx"</div>
            </div>
            <div class="form-item" id="comm-method-wrapper">
                <label for="comm_method_id">Να επικοινωνήσουμε μαζί σας στο: </label>
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
            ΕΚΠΑΙΔΕΥΣΗ &amp; ΙΚΑΝΟΤΗΤΕΣ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="education-level-wrapper">
                <label for="education_level_id">Επίπεδο εκπαίδευσης: <span class="form-required"
                                                                           title="Το πεδίο είναι απαραίτητο.">*</span></label>
                @if($errors->has('education_level_id'))
                    <p class="error">{{ $errors->first('education_level_id') }}</p>
                @endif
                <select name="education_level_id" class="form-select required">
                    @foreach($edLevel as $key => $value)
                        <option value="@if($key !== 0){{ $key }}@endif">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="description">Επιλέξτε απο την λίστα το επίπεδο της εκπαίδευσης σας.</div>
            </div>
            <div class="form-item" id="specialty-wrapper">
                <label for="specialty">Ειδικότητα: </label>
                @if($errors->has('specialty'))
                    <p class="error">{{ $errors->first('specialty') }}</p>
                @endif
                <input type="text" name="specialty" size="50"
                       value="{{ old('specialty') }}"
                       class="form-text">
            </div>
            <div class="form-item" id="department-wrapper">
                <label for="department">Σχολή: </label>
                @if($errors->has('department'))
                    <p class="error">{{ $errors->first('department') }}</p>
                @endif
                <input type="text" name="department" size="50"
                       value="{{ old('department') }}" class="form-text">
            </div>
            <fieldset>
                <legend>Ξένες Γλώσσες</legend>
                <div class="form-item">
                    <label>Ελληνικά: </label>
                    <div class="form-radios">
                        <div class="form-item" id="greek-basic-wrapper">
                            <label class="option" for="greek-basic"><input type="radio"
                                                                                    id="greek-basic"
                                                                                    name="lang[1]" value="1"
                                                                                    class="form-radio">
                                Βασικό</label>
                        </div>
                        <div class="form-item" id="greek-good-wrapper">
                            <label class="option" for="greek-good"><input type="radio"
                                                                                  id="greek-good"
                                                                                  name="lang[1]" value="2"
                                                                                  class="form-radio"> Καλό</label>
                        </div>
                        <div class="form-item" id="greek-very-good-wrapper">
                            <label class="option" for="greek-very-good"><input type="radio"
                                                                                       id="greek-very-good"
                                                                                       name="lang[1]"
                                                                                       value="3"
                                                                                       class="form-radio"> Πολύ
                                Καλό</label>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label>Αγγλικά: </label>
                    <div class="form-radios">
                        <div class="form-item" id="english-basic-wrapper">
                            <label class="option" for="english-basic"><input type="radio"
                                                                                   id="english-basic"
                                                                                   name="lang[2]" value="1"
                                                                                   class="form-radio">
                                Βασικό</label>
                        </div>
                        <div class="form-item" id="english-good-wrapper">
                            <label class="option" for="english-good"><input type="radio" id="english-good"
                                                                                 name="lang[2]" value="2"
                                                                                 class="form-radio"> Καλό</label>
                        </div>
                        <div class="form-item" id="english-very-good-wrapper">
                            <label class="option" for="english-very-good"><input type="radio"
                                                                                      id="english-very-good"
                                                                                      name="lang[2]"
                                                                                      value="3"
                                                                                      class="form-radio"> Πολύ
                                Καλό</label>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label>Γαλλικά: </label>
                    <div class="form-radios">
                        <div class="form-item" id="french-basic-wrapper">
                            <label class="option" for="french-basic"><input type="radio"
                                                                                   id="french-basic"
                                                                                   name="lang[3]" value="1"
                                                                                   class="form-radio">
                                Βασικό</label>
                        </div>
                        <div class="form-item" id="french-good-wrapper">
                            <label class="option" for="french-good"><input type="radio" id="french-good"
                                                                                 name="lang[3]" value="2"
                                                                                 class="form-radio"> Καλό</label>
                        </div>
                        <div class="form-item" id="french-very-good-wrapper">
                            <label class="option" for="french-very-good"><input type="radio"
                                                                                      id="french-very-good"
                                                                                      name="lang[3]"
                                                                                      value="3"
                                                                                      class="form-radio"> Πολύ
                                Καλό</label>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label>Ισπανικά: </label>
                    <div class="form-radios">
                        <div class="form-item" id="spanish-basic-wrapper">
                            <label class="option" for="spanish-basic"><input type="radio"
                                                                                    id="spanish-basic"
                                                                                    name="lang[4]" value="1"
                                                                                    class="form-radio">
                                Βασικό</label>
                        </div>
                        <div class="form-item" id="spanish-good-wrapper">
                            <label class="option" for="spanish-good"><input type="radio"
                                                                                  id="spanish-good"
                                                                                  name="lang[4]" value="2"
                                                                                  class="form-radio"> Καλό</label>
                        </div>
                        <div class="form-item" id="spanish-very-good-wrapper">
                            <label class="option" for="spanish-very-good"><input type="radio"
                                                                                       id="spanish-very-good"
                                                                                       name="lang[4]"
                                                                                       value="3"
                                                                                       class="form-radio"> Πολύ
                                Καλό</label>
                        </div>
                    </div>
                </div>
                <div class="form-item">
                    <label>Γερμανικά: </label>
                    <div class="form-radios">
                        <div class="form-item" id="german-basic-wrapper">
                            <label class="option" for="german-basic"><input type="radio"
                                                                                     id="german-basic"
                                                                                     name="lang[5]" value="1"
                                                                                     class="form-radio">
                                Βασικό</label>
                        </div>
                        <div class="form-item" id="german-good-wrapper">
                            <label class="option" for="german-good"><input type="radio"
                                                                                   id="german-good"
                                                                                   name="lang[5]" value="2"
                                                                                   class="form-radio"> Καλό</label>
                        </div>
                        <div class="form-item" id="german-very-good-wrapper">
                            <label class="option" for="german-very-good"><input type="radio"
                                                                                        id="german-very-good"
                                                                                        name="lang[5]"
                                                                                        value="3"
                                                                                        class="form-radio"> Πολύ
                                Καλό</label>
                        </div>
                    </div>
                </div>
                <div class="form-item" id="extra-lang-wrapper">
                    <label for="extra_lang">Άλλες γλώσες: </label>
                    <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="extra_lang"
                                                                    class="form-textarea resizable"></textarea>
                            </span>
                    </div>
                    <div class="description">Συμπληρώστε τις επιπλέον γλώσσες που γνωρίζετε και το επιπεδό σας</div>
                </div>
            </fieldset>
            <div class="form-item" id="driver-license-type-wrapper">
                <label for="driver_license_type_id">Δίπλωμα οδήγησης - Κατηγορία: </label>
                @if($errors->has('driver_licence_type_id'))
                    <p class="error">{{ $errors->first('driver_licence_type_id') }}</p>
                @endif
                <select name="driver_license_type_id" class="form-select">
                    @foreach($driverLicenseTypes as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <div class="description">Επιλέξτε την κατηγορία του διπλώματος σας εάν έχετε.</div>
            </div>
            <div class="form-item" id="computer-usage-wrapper">
                <label class="option" for="computer_usage"><input type="checkbox" name="computer_usage"
                                                                  id="computer_usage"
                                                                  value="1" class="form-checkbox">
                    Χρήση υπολογιστή</label>
                <input type="hidden" name="computer_usage_comments" value="">
            </div>
            <div class="form-item" id="additional-skills-wrapper">
                <label for="additional_skills">Πρόσθετες ικανότητες, προσόντα και εμπειρία : </label>
                @if($errors->has('additional_skills'))
                    <p class="error">{{ $errors->first('additional_skills') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="additional_skills"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">Συμπληρώστε τυχόν επιπλέον πρόσθετες ικανότητες, προσόντα και εμπειρία που
                    διαθέτετε.
                </div>
            </div>
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            ΕΡΓΑΣΙΑΚΗ ΕΜΠΕΙΡΙΑ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="work-status-wrapper">
                <label for="work_status_id">Εργασιακή κατάσταση: <span class="form-required"
                                                                       title="Το πεδίο είναι απαραίτητο.">*</span></label>
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
                <label for="work_description">Εργασία: </label>
                @if($errors->has('work_description'))
                    <p class="error">{{ $errors->first('work_description') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="work_description"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">Περιγράψτε την θέσης σας στην παρούσα ή την πιο πρόσφατη εργασία σας</div>
            </div>
        </div>

    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            ΕΘΕΛΟΝΤΙΚΗ ΠΡΟΣΦΟΡΑ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="participation-reason-wrapper">
                <label for="participation_reason">Λόγος συμετοχής: <span class="form-required"
                                                                         title="Το πεδίο είναι απαραίτητο.">*</span></label>
                @if($errors->has('participation_reason'))
                    <p class="error">{{ $errors->first('participation_reason') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_reason"
                                                                class="form-textarea resizable required"></textarea>
                        </span>
                </div>
                <div class="description">Περιγράψτε τους λόγους που θέλετε να γίνετε εθελοντής.</div>
            </div>
            <div class="form-item" id="participation-actions-wrapper">
                <label for="participation_actions">Εθελοντική οργάνωση: </label>
                @if($errors->has('participation_actions'))
                    <p class="error">{{ $errors->first('participation_actions') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_actions"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">Εαν ανήκετε ή ανήκατε σε κάποιες εθελοντικές οργανώσεις ποιο ήταν το
                    αντικείμενο τους και για πόσο χρονικό διάστημα είχατε συμετοχή.
                </div>
            </div>
            <div class="form-item" id="participation-previous-wrapper">
                <label for="participation_previous">Εθελοντικές δράσεις: </label>
                @if($errors->has('participation_previous'))
                    <p class="error">{{ $errors->first('participation_previous') }}</p>
                @endif
                <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_previous"
                                                                class="form-textarea resizable"></textarea>
                        </span>
                </div>
                <div class="description">Εαν έχετε πάρει μέρος σε εθελοντικές δράσεις στο παρελθόν περιγράψτε ποιο
                    ήταν/είναι το αντικείμενο.
                </div>
            </div>
        </div>


    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            ΔΙΑΘΕΣΙΜΟΤΗΤΑ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="availability-freqs-wrapper">
                <label for="availability_freqs_id">Συχνότητα_συνεισφοράς: </label>
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
                <label>Χρόνοι συνεισφοράς: </label>
                <div class="form-checkboxes">
                    <div class="form-item" id="contribution-time-morning-wrapper">
                        <label class="option" for="contribution_time_morning"><input type="checkbox"
                                                                                        name="contribution_time[morning]"
                                                                                        id="contribution_time_morning"
                                                                                        value="1"
                                                                                        class="form-checkbox">
                            Πρωί</label>
                    </div>
                    <div class="form-item" id="contribution-time-afternoon-wrapper">
                        <label class="option" for="contribution_time_afternoon"><input type="checkbox"
                                                                                            name="contribution_time[afternoon]"
                                                                                            id="contribution_time_afternoon"
                                                                                            value="1"
                                                                                            class="form-checkbox">
                            Απογεύμα</label>
                    </div>
                    <div class="form-item" id="contribution-time-weekend-wrapper">
                        <label class="option" for="contribution_time_weekend"><input type="checkbox"
                                                                                                  name="contribution_time[weekend]"
                                                                                                  id="contribution_time_weekend"
                                                                                                  value="1"
                                                                                                  class="form-checkbox">
                            Σαββατοκύριακο</label>
                    </div>
                </div>
            </div>
        </div>

    </fieldset>
    <fieldset class=" collapsible">
        <legend>
            ΠΕΡΙΟΧΕΣ ΕΝΔΙΑΦΕΡΟΝΤΩΝ
        </legend>
        <div class="fieldset-wrapper">
            <div class="form-item" id="edit-πολιτισμός-και-εκπαίδευση-wrapper">
                <label class="option" for="edit-πολιτισμός-και-εκπαίδευση"><input type="checkbox"
                                                                                  name="πολιτισμός_και_εκπαίδευση"
                                                                                  id="edit-πολιτισμός-και-εκπαίδευση"
                                                                                  value="ΝΑΙ" class="form-checkbox">
                    Πολιτισμός και εκπαίδευση</label>
            </div>
            <div class="form-item" id="edit-αθλητισμός-wrapper">
                <label class="option" for="edit-αθλητισμός"><input type="checkbox" name="αθλητισμός"
                                                                   id="edit-αθλητισμός" value="ΝΑΙ"
                                                                   class="form-checkbox"> Αθλητισμός</label>
            </div>
            <div class="form-item">
                <label>Περιβάλλον: </label>
                <div class="form-checkboxes">
                    <div class="form-item"
                         id="edit-περιβάλλον-ενημέρωση-ευαισθητοποίηση-πολιτών-σε-περιβαλλοντικά-θέματα-wrapper">
                        <label class="option"
                               for="edit-περιβάλλον-ενημέρωση-ευαισθητοποίηση-πολιτών-σε-περιβαλλοντικά-θέματα"><input
                                    type="checkbox"
                                    name="περιβάλλον[ενημέρωση-ευαισθητοποίηση πολιτών σε περιβαλλοντικά θέματα]"
                                    id="edit-περιβάλλον-ενημέρωση-ευαισθητοποίηση-πολιτών-σε-περιβαλλοντικά-θέματα"
                                    value="ενημέρωση-ευαισθητοποίηση πολιτών σε περιβαλλοντικά θέματα"
                                    class="form-checkbox"> ενημέρωση-ευαισθητοποίηση πολιτών σε περιβαλλοντικά
                            θέματα</label>
                    </div>
                    <div class="form-item" id="edit-περιβάλλον-καθαρισμός-δημοσίου-χώρου-wrapper">
                        <label class="option" for="edit-περιβάλλον-καθαρισμός-δημοσίου-χώρου"><input type="checkbox"
                                                                                                     name="περιβάλλον[καθαρισμός δημοσίου χώρου]"
                                                                                                     id="edit-περιβάλλον-καθαρισμός-δημοσίου-χώρου"
                                                                                                     value="καθαρισμός δημοσίου χώρου"
                                                                                                     class="form-checkbox">
                            καθαρισμός δημοσίου χώρου</label>
                    </div>
                    <div class="form-item" id="edit-περιβάλλον-βάψιμο-επιφανειών-wrapper">
                        <label class="option" for="edit-περιβάλλον-βάψιμο-επιφανειών"><input type="checkbox"
                                                                                             name="περιβάλλον[βάψιμο επιφανειών]"
                                                                                             id="edit-περιβάλλον-βάψιμο-επιφανειών"
                                                                                             value="βάψιμο επιφανειών"
                                                                                             class="form-checkbox">
                            βάψιμο επιφανειών</label>
                    </div>
                    <div class="form-item" id="edit-περιβάλλον-antigraffiti-wrapper">
                        <label class="option" for="edit-περιβάλλον-antigraffiti"><input type="checkbox"
                                                                                        name="περιβάλλον[antigraffiti]"
                                                                                        id="edit-περιβάλλον-antigraffiti"
                                                                                        value="antigraffiti"
                                                                                        class="form-checkbox">
                            antigraffiti</label>
                    </div>
                    <div class="form-item" id="edit-περιβάλλον-φύτευση-wrapper">
                        <label class="option" for="edit-περιβάλλον-φύτευση"><input type="checkbox"
                                                                                   name="περιβάλλον[φύτευση]"
                                                                                   id="edit-περιβάλλον-φύτευση"
                                                                                   value="φύτευση"
                                                                                   class="form-checkbox">
                            φύτευση</label>
                    </div>
                </div>
            </div>
            <div class="form-item">
                <label>Κοινωνική αλληλεγγύη: </label>
                <div class="form-checkboxes">
                    <div class="form-item" id="edit-κοινωνική-αλληλεγγύη-Κόμβος-Αλληλεγγύης-Πολιτών-wrapper">
                        <label class="option" for="edit-κοινωνική-αλληλεγγύη-Κόμβος-Αλληλεγγύης-Πολιτών"><input
                                    type="checkbox" name="κοινωνική_αλληλεγγύη[Κόμβος Αλληλεγγύης Πολιτών]"
                                    id="edit-κοινωνική-αλληλεγγύη-Κόμβος-Αλληλεγγύης-Πολιτών"
                                    value="Κόμβος Αλληλεγγύης Πολιτών" class="form-checkbox"> Κόμβος Αλληλεγγύης
                            Πολιτών</label>
                    </div>
                    <div class="form-item"
                         id="edit-κοινωνική-αλληλεγγύη-Παροχή-φροντίδας-ως-εθελοντής-γείτονας-wrapper">
                        <label class="option"
                               for="edit-κοινωνική-αλληλεγγύη-Παροχή-φροντίδας-ως-εθελοντής-γείτονας"><input
                                    type="checkbox"
                                    name="κοινωνική_αλληλεγγύη[Παροχή φροντίδας ως εθελοντής γείτονας]"
                                    id="edit-κοινωνική-αλληλεγγύη-Παροχή-φροντίδας-ως-εθελοντής-γείτονας"
                                    value="Παροχή φροντίδας ως εθελοντής γείτονας" class="form-checkbox"> Παροχή
                            φροντίδας ως εθελοντής γείτονας</label>
                    </div>
                </div>
            </div>
        </div>


    </fieldset>

    <br>
    <a href="#" class="intlink" data-toggle="modal" data-target="#oroi">
        <strong>Όροι και Προϋποθέσεις Συμμετοχής</strong>
    </a>

    <div class="modal fade" id="oroi" tabindex="-1" role="dialog" aria-labelledby="terms">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Δηλώνω υπεύθυνα ότι:</h3>
                    <p>Όλα τα ανωτέρω στοιχεία είναι αληθή και σωστά.</p>
                    <p>Γνωρίζω ότι τα ανωτέρω στοιχεία θα παραμείνουν στο φορέα και αποδέχομαι ότι ο Δήμος Αθηναίων
                        δύναται
                        να επεξεργαστεί δεδομένα προσωπικού χαρακτήρα μου και ειδικότερα τα εδώ αναφερόμενα δεδομένα μου
                        για
                        τους σκοπούς οργάνωσης και πραγματοποίησης των εθελοντικών δράσεων. </p>
                    <p>Δεν υφίσταται σχέση εργασίας ή έργου μεταξύ εμού και του Γραφείου Εθελοντισμού του Δήμου Αθηναίων
                        για
                        τις εθελοντικές υπηρεσίες που προσφέρω.</p>
                    <p>Ουδεμία απαίτηση χρηματική ή άλλης αποζημίωσης έχω έναντι του Γραφείου Εθελοντισμού λόγω της
                        ανάληψης
                        των ανωτέρω αναφερόμενων εργασιών και της εθελοντικής μου προσφοράς σε αυτό.</p>
                    <p>Δηλώνω ότι δεν αντιμετωπίζω προβλήματα υγείας που θα μπορούσαν να επηρεάσουν την παροχή των
                        ανωτέρω
                        εθελοντικών υπηρεσιών.</p>
                    <p>Στις εργασίες στις οποίες συμμετέχω εθελοντικά το Γραφείο Εθελοντισμού θα μπορεί να αναγράφει το
                        όνομά μου εφόσον το επιθυμώ και μετά από δήλωσή μου.</p>
                    <p>Το υλικό που το Γραφείο Εθελοντισμού μου παράσχει για την υλοποίηση των εργασιών που αναλαμβάνω
                        καθώς
                        και τα παραγόμενα αποτελέσματα και προϊόντα αυτών ανήκουν αποκλειστικά και μόνον στο Γραφείο και
                        ως
                        εκ τούτου δεν έχω κανένα δικαίωμα (συμπεριλαμβανομένων και των πνευματικών) χρήσης, δημοσίευσης,
                        πώλησης ή άλλο επί αυτών.</p>
                    <p>Μετά το πέρας της εθελοντικής μου εργασίας υποχρεούμαι να επιστρέψω στο Γραφείο Εθελοντισμού το
                        υλικό
                        που μου έχει διατεθεί για το λόγο αυτό.</p>
                    <p>Κατά την διάρκεια υλοποίησης των εθελοντικών εργασιών που αναλαμβάνω, οφείλω να τηρώ τα χρονικά
                        πλαίσια που μου έχουν τεθεί από τον Φορέα και να ακολουθώ τις σχετικές υποδείξεις και οδηγίες
                        που
                        μου δίνονται.</p>
                    <p>Το Γραφείο Εθελοντισμού έχει το δικαίωμα να με παύσει από τις αρμοδιότητές μου ή να αφαιρέσει
                        τμήμα
                        των εθελοντικών εργασιών που αναλαμβάνω.</p>
                    <p>Κανένα άλλο δικαίωμα ή απαίτηση έχω έναντι του Γραφείου Εθελοντισμού.</p>
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
                                                 class="form-checkbox required"> Συμφωνώ</label>
    </div>


    Σημειώνεται ότι τα προσωπικά και άλλα δεδομένα που θα συμπληρωθούν στην παρούσα αίτηση θα διατηρηθούν στο αρχείο
    του Δήμου Αθηναίων, δεν θα αξιοποιηθούν για οποιονδήποτε άλλο σκοπό πέρα από την εθελοντική συμμετοχή στα
    προγράμματα του Δήμου, και δεν πρόκειται τρίτοι να έχουν πρόσβαση σ’ αυτά, τηρουμένων των ισχυουσών διατάξεων
    και ιδίως του άρθρου 10 ν. 2472/1997.<br>
    <div class="readon"><input class="button" type="submit" name="op" id="edit-submit" value="Αποστολή"></div>
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
