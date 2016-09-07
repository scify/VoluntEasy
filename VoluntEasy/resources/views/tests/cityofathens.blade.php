<html>
<head>
    {{-- bootstrap --}}
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>

    <link href="{{ asset('/athensmunicipality/css/cityofathens_form.css')}}" rel="stylesheet"/>
</head>
<body>

@if (count($errors) > 0)
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{!! Form::open(['id' => 'volunteer-form', 'method' => 'POST', 'action' => ['Api\VolunteerApiController@apiStore']]) !!}

{{--<form action="/ethelontismos/symetoxh" accept-charset="UTF-8" method="post" id="ethelontismosform-my-form">--}}
    <div>
        <fieldset class=" collapsible">
            <legend>
                ΑΤΟΜΙΚΑ ΣΤΟΙΧΕΙΑ
            </legend>
            <div class="fieldset-wrapper">
                <div class="form-item" id="edit-Όνομα-wrapper">
                    <label for="name">Όνομα:
                        <span class="form-required" title="Το πεδίο είναι απαραίτητο.">*</span>
                    </label>
                    <input type="text" maxlength="20" name="name" id="edit-Όνομα" size="20" value=""
                           class="form-text required">
                    <div class="description">Παρακαλώ συμπληρώστε το ονομά σας.</div>
                </div>
                <div class="form-item" id="edit-Επώνυμο-wrapper">
                    <label for="last_name">Επώνυμο:
                        <span class="form-required" title="Το πεδίο είναι απαραίτητο.">*</span>
                    </label>
                    <input type="text" maxlength="40" name="last_name" id="edit-Επώνυμο" size="40" value=""
                           class="form-text required">
                    <div class="description">Παρακαλώ συμπληρώστε το επώνυμο σας.</div>
                </div>
                <div class="form-item" id="edit-Όνομα-Πατέρα-wrapper">
                    <label for="fathers_name">Όνομα Πατέρα: <span class="form-required"
                                                                       title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    <input type="text" maxlength="20" name="fathers_name" id="edit-Όνομα-Πατέρα" size="20" value=""
                           class="form-text required">
                    <div class="description">Παρακαλώ συμπληρώστε το όνομα του πατέρα σας.</div>
                </div>
                <div class="form-item" id="edit-Τύπος-Ταυτότητας-wrapper">
                    <label for="identification_type_id">Τύπος Ταυτότητας: </label>
                    <select name="identification_type_id" class="form-select" id="edit-Τύπος-Ταυτότητας">
                        <option value="Α.Δ.Τ.">Α.Δ.Τ.</option>
                        <option value="Διαβατήριο">Διαβατήριο</option>
                        <option value="Άδεια Παραμονής">Άδεια Παραμονής</option>
                    </select>
                </div>
                <div class="form-item" id="edit-Ταυτότητα-wrapper">
                    <input type="text" maxlength="20" name="identification_num" id="edit-Ταυτότητα" size="20" value=""
                           class="form-text">
                    <div class="description">Παρακαλώ συμπληρώστε το Α.Δ.Τ. ή Διαβατηρίου ή Άδεια Παραμονής και επιλέξτε
                        απο την λίστα τον τύπο.
                    </div>
                </div>
                <div class="container-inline-date date-clear-block">
                    <div class="form-item" id="edit-Ημερομηνία-Γέννησης-wrapper">
                        <label for="birth_date">Ημερομηνία Γέννησης: <span class="form-required"
                                                                                         title="Το πεδίο είναι απαραίτητο.">*</span></label>
                        <div class="date-day">
                            <div class="form-item" id="edit-Ημερομηνία-Γέννησης-day-wrapper">
                                <select name="Ημερομηνία_Γέννησης[day]" class="form-select required  date-day"
                                        id="edit-Ημερομηνία-Γέννησης-day">
                                    <option value="" selected="selected">-Ημέρα</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="date-month">
                            <div class="form-item" id="edit-Ημερομηνία-Γέννησης-month-wrapper">
                                <select name="Ημερομηνία_Γέννησης[month]" class="form-select required  date-month"
                                        id="edit-Ημερομηνία-Γέννησης-month">
                                    <option value="" selected="selected">-Μήνας</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div>
                        <div class="date-year">
                            <div class="form-item" id="edit-Ημερομηνία-Γέννησης-year-wrapper">
                                <select name="Ημερομηνία_Γέννησης[year]" class="form-select required  date-year"
                                        id="edit-Ημερομηνία-Γέννησης-year">
                                    <option value="" selected="selected">-Έτος</option>
                                    <option value="1935">1935</option>
                                    <option value="1936">1936</option>
                                    <option value="1937">1937</option>
                                    <option value="1938">1938</option>
                                    <option value="1939">1939</option>
                                    <option value="1940">1940</option>
                                    <option value="1941">1941</option>
                                    <option value="1942">1942</option>
                                    <option value="1943">1943</option>
                                    <option value="1944">1944</option>
                                    <option value="1945">1945</option>
                                    <option value="1946">1946</option>
                                    <option value="1947">1947</option>
                                    <option value="1948">1948</option>
                                    <option value="1949">1949</option>
                                    <option value="1950">1950</option>
                                    <option value="1951">1951</option>
                                    <option value="1952">1952</option>
                                    <option value="1953">1953</option>
                                    <option value="1954">1954</option>
                                    <option value="1955">1955</option>
                                    <option value="1956">1956</option>
                                    <option value="1957">1957</option>
                                    <option value="1958">1958</option>
                                    <option value="1959">1959</option>
                                    <option value="1960">1960</option>
                                    <option value="1961">1961</option>
                                    <option value="1962">1962</option>
                                    <option value="1963">1963</option>
                                    <option value="1964">1964</option>
                                    <option value="1965">1965</option>
                                    <option value="1966">1966</option>
                                    <option value="1967">1967</option>
                                    <option value="1968">1968</option>
                                    <option value="1969">1969</option>
                                    <option value="1970">1970</option>
                                    <option value="1971">1971</option>
                                    <option value="1972">1972</option>
                                    <option value="1973">1973</option>
                                    <option value="1974">1974</option>
                                    <option value="1975">1975</option>
                                    <option value="1976">1976</option>
                                    <option value="1977">1977</option>
                                    <option value="1978">1978</option>
                                    <option value="1979">1979</option>
                                    <option value="1980">1980</option>
                                    <option value="1981">1981</option>
                                    <option value="1982">1982</option>
                                    <option value="1983">1983</option>
                                    <option value="1984">1984</option>
                                    <option value="1985">1985</option>
                                    <option value="1986">1986</option>
                                    <option value="1987">1987</option>
                                    <option value="1988">1988</option>
                                    <option value="1989">1989</option>
                                    <option value="1990">1990</option>
                                    <option value="1991">1991</option>
                                    <option value="1992">1992</option>
                                    <option value="1993">1993</option>
                                    <option value="1994">1994</option>
                                    <option value="1995">1995</option>
                                    <option value="1996">1996</option>
                                    <option value="1997">1997</option>
                                </select>
                            </div>
                        </div>
                        <div class="description">DD-MM-YYYY</div>
                        <input type="hidden" name="birth_date">
                    </div>
                </div>
                <div class="form-item">
                    <label>Φύλο: <span class="form-required" title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    <div class="form-radios">
                        <div class="form-item" id="edit-Φύλο-Άνδρας-wrapper">
                            <label class="option" for="edit-Φύλο-Άνδρας"><input type="radio" id="edit-Φύλο-Άνδρας"
                                                                                name="gender_id" value="1"
                                                                                class="form-radio"> Άνδρας</label>
                        </div>
                        <div class="form-item" id="edit-Φύλο-Γυναίκα-wrapper">
                            <label class="option" for="edit-Φύλο-Γυναίκα"><input type="radio" id="edit-Φύλο-Γυναίκα"
                                                                                 name="gender_id" value="2"
                                                                                 class="form-radio"> Γυναίκα</label>
                        </div>
                    </div>
                </div>
                <div class="form-item" id="edit-Οικογενειακή-Κατάσταση-wrapper">
                    <label for="marital_status_id">Οικογενειακή Κατάσταση: </label>
                    <select name="marital_status_id" class="form-select" id="edit-Οικογενειακή-Κατάσταση">
                        <option value="" selected="selected">- Επιλέξτε -</option>
                        <option value="1">άγαμος/η</option>
                        <option value="2">παντρεμένος/η</option>
                        <option value="3">χήρος/α</option>
                        <option value="4">διαζευγμένος/η</option>
                    </select>
                </div>
                <div class="form-item" id="edit-Τέκνα-wrapper">
                    <label for="children">Τέκνα: </label>
                    <input type="text" maxlength="2" name="children" id="edit-Τέκνα" size="2" value="" class="form-text">
                </div>
                <div class="form-item" id="edit-Διεύθυνση-wrapper">
                    <label for="address">Διεύθυνση: </label>
                    <input type="text" maxlength="100" name="address" id="edit-Διεύθυνση" size="60" value=""
                           class="form-text">
                </div>
                <div class="form-item" id="edit-Τ-Κ-wrapper">
                    <label for="post_box">Τ.Κ.: </label>
                    <input type="text" maxlength="6" name="post_box" id="edit-Τ-Κ" size="6" value="" class="form-text">
                </div>
                <div class="form-item" id="edit-Πόλη-wrapper">
                    <label for="city">Πόλη: </label>
                    <input type="text" maxlength="50" name="city" id="edit-Πόλη" size="50" value="" class="form-text">
                </div>
                <div class="form-item" id="edit-Χώρα-wrapper">
                    <label for="country">Χώρα: </label>
                    <input type="text" maxlength="50" name="country" id="edit-Χώρα" size="50" value="" class="form-text">
                </div>
                <div class="form-item" id="edit-Κάτοικος-Ελλάδας-wrapper">
                    <label class="option" for="live_in_curr_country"><input type="checkbox" name="live_in_curr_country"
                                                                             id="edit-Κάτοικος-Ελλάδας"
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
                <div class="form-item" id="edit-Τηλέφωνο-Οικίας-wrapper">
                    <label for="home_tel">Τηλέφωνο Οικίας: </label>
                    <input type="text" maxlength="15" name="home_tel" id="edit-Τηλέφωνο-Οικίας" size="15"
                           value="" class="form-text">
                </div>
                <div class="form-item" id="edit-Τηλέφωνο-Εργασίας-wrapper">
                    <label for="work_tel">Τηλέφωνο Εργασίας: </label>
                    <input type="text" maxlength="15" name="work_tel" id="edit-Τηλέφωνο-Εργασίας" size="15"
                           value="" class="form-text">
                </div>
                <div class="form-item" id="edit-Κινητό-wrapper">
                    <label for="cell_tel">Κινητό: </label>
                    <input type="text" maxlength="15" name="cell_tel" id="edit-Κινητό" size="15" value=""
                           class="form-text">
                </div>
                <div class="form-item" id="edit-Fax-wrapper">
                    <label for="fax">Fax: </label>
                    <input type="text" maxlength="15" name="fax" id="edit-Fax" size="15" value="" class="form-text">
                </div>
                <div class="form-item" id="edit-email-wrapper">
                    <label for="email">email: <span class="form-required"
                                                         title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    <input type="text" maxlength="128" name="email" id="edit-email" size="50" value=""
                           class="form-text required">
                    <div class="description">Συμπληρώστε την διεύθυνση στην μορφή "xxx@xxx.xx"</div>
                </div>
                <div class="form-item" id="edit-Τρόπος-επικοινωνίας-wrapper">
                    <label for="comm_method_id">Να επικοινωνήσουμε μαζί σας στο: </label>
                    <select name="comm_method_id" class="form-select" id="edit-Τρόπος-επικοινωνίας">
                        <option value="1">Ηλεκτρονικό ταχυδρομείο</option>
                        <option value="2">Τηλέφωνο Οικίας</option>
                        <option value="3">Τηλέφωνο Εργασίας</option>
                        <option value="4">Κινητό Τηλέφωνο</option>
                    </select>
                </div>
            </div>


        </fieldset>
        <fieldset class=" collapsible">
            <legend>
                ΕΚΠΑΙΔΕΥΣΗ &amp; ΙΚΑΝΟΤΗΤΕΣ
            </legend>
            <div class="fieldset-wrapper">
                <div class="form-item" id="edit-Επίπεδο-εκπαίδευσης-wrapper">
                    <label for="education_level_id">Επίπεδο εκπαίδευσης: <span class="form-required"
                                                                                     title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    <select name="education_level_id" class="form-select required" id="edit-Επίπεδο-εκπαίδευσης">
                        <option value="0">- Επιλέξτε -</option>
                        {{--<option value="Δημοτικό">Δημοτικό</option>--}}
                        <option value="1">Γυμνάσιο</option>
                        <option value="2">Λύκειο</option>
                        <option value="3">Ανώτερη</option>
                        <option value="4">Ανώτατη</option>
                        <option value="5">Μεταπτυχιακά</option>
                    </select>
                    <div class="description">Επιλέξτε απο την λίστα το επίπεδο της εκπαίδευσης σας.</div>
                </div>
                <div class="form-item" id="edit-Ειδικότητα-wrapper">
                    <label for="specialty">Ειδικότητα: </label>
                    <input type="text" maxlength="50" name="specialty" id="edit-Ειδικότητα" size="50" value=""
                           class="form-text">
                </div>
                <div class="form-item" id="edit-Σχολή-wrapper">
                    <label for="department">Σχολή: </label>
                    <input type="text" maxlength="50" name="department" id="edit-Σχολή" size="50" value="" class="form-text">
                </div>
                <fieldset>
                    <legend>Ξένες Γλώσσες</legend>
                    <div class="form-item">
                        <label>Ελληνικά: </label>
                        <div class="form-radios">
                            <div class="form-item" id="edit-Ελληνικά-Βασικό-wrapper">
                                <label class="option" for="edit-Ελληνικά-Βασικό"><input type="radio"
                                                                                        id="edit-Ελληνικά-Βασικό"
                                                                                        name="lang[1]" value="1"
                                                                                        class="form-radio">
                                    Βασικό</label>
                            </div>
                            <div class="form-item" id="edit-Ελληνικά-Καλό-wrapper">
                                <label class="option" for="edit-Ελληνικά-Καλό"><input type="radio"
                                                                                      id="edit-Ελληνικά-Καλό"
                                                                                      name="lang[1]" value="2"
                                                                                      class="form-radio"> Καλό</label>
                            </div>
                            <div class="form-item" id="edit-Ελληνικά-Πολύ-Καλό-wrapper">
                                <label class="option" for="edit-Ελληνικά-Πολύ-Καλό"><input type="radio"
                                                                                           id="edit-Ελληνικά-Πολύ-Καλό"
                                                                                           name="lang[1]"
                                                                                           value="3"
                                                                                           class="form-radio"> Πολύ Καλό</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label>Αγγλικά: </label>
                        <div class="form-radios">
                            <div class="form-item" id="edit-Αγγλικά-Βασικό-wrapper">
                                <label class="option" for="edit-Αγγλικά-Βασικό"><input type="radio"
                                                                                       id="edit-Αγγλικά-Βασικό"
                                                                                       name="lang[2]" value="1"
                                                                                       class="form-radio">
                                    Βασικό</label>
                            </div>
                            <div class="form-item" id="edit-Αγγλικά-Καλό-wrapper">
                                <label class="option" for="edit-Αγγλικά-Καλό"><input type="radio" id="edit-Αγγλικά-Καλό"
                                                                                     name="lang[2]" value="2"
                                                                                     class="form-radio"> Καλό</label>
                            </div>
                            <div class="form-item" id="edit-Αγγλικά-Πολύ-Καλό-wrapper">
                                <label class="option" for="edit-Αγγλικά-Πολύ-Καλό"><input type="radio"
                                                                                          id="edit-Αγγλικά-Πολύ-Καλό"
                                                                                          name="lang[2]"
                                                                                          value="3"
                                                                                          class="form-radio"> Πολύ Καλό</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label>Γαλλικά: </label>
                        <div class="form-radios">
                            <div class="form-item" id="edit-Γαλλικά-Βασικό-wrapper">
                                <label class="option" for="edit-Γαλλικά-Βασικό"><input type="radio"
                                                                                       id="edit-Γαλλικά-Βασικό"
                                                                                       name="lang[3]" value="1"
                                                                                       class="form-radio">
                                    Βασικό</label>
                            </div>
                            <div class="form-item" id="edit-Γαλλικά-Καλό-wrapper">
                                <label class="option" for="edit-Γαλλικά-Καλό"><input type="radio" id="edit-Γαλλικά-Καλό"
                                                                                     name="lang[3]" value="2"
                                                                                     class="form-radio"> Καλό</label>
                            </div>
                            <div class="form-item" id="edit-Γαλλικά-Πολύ-Καλό-wrapper">
                                <label class="option" for="edit-Γαλλικά-Πολύ-Καλό"><input type="radio"
                                                                                          id="edit-Γαλλικά-Πολύ-Καλό"
                                                                                          name="lang[3]"
                                                                                          value="3"
                                                                                          class="form-radio"> Πολύ Καλό</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label>Ισπανικά: </label>
                        <div class="form-radios">
                            <div class="form-item" id="edit-Ισπανικά-Βασικό-wrapper">
                                <label class="option" for="edit-Ισπανικά-Βασικό"><input type="radio"
                                                                                        id="edit-Ισπανικά-Βασικό"
                                                                                        name="lang[4]" value="1"
                                                                                        class="form-radio">
                                    Βασικό</label>
                            </div>
                            <div class="form-item" id="edit-Ισπανικά-Καλό-wrapper">
                                <label class="option" for="edit-Ισπανικά-Καλό"><input type="radio"
                                                                                      id="edit-Ισπανικά-Καλό"
                                                                                      name="lang[4]" value="2"
                                                                                      class="form-radio"> Καλό</label>
                            </div>
                            <div class="form-item" id="edit-Ισπανικά-Πολύ-Καλό-wrapper">
                                <label class="option" for="edit-Ισπανικά-Πολύ-Καλό"><input type="radio"
                                                                                           id="edit-Ισπανικά-Πολύ-Καλό"
                                                                                           name="lang[4]"
                                                                                           value="3"
                                                                                           class="form-radio"> Πολύ Καλό</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <label>Γερμανικά: </label>
                        <div class="form-radios">
                            <div class="form-item" id="edit-Γερμανικά-Βασικό-wrapper">
                                <label class="option" for="edit-Γερμανικά-Βασικό"><input type="radio"
                                                                                         id="edit-Γερμανικά-Βασικό"
                                                                                         name="lang[5]" value="1"
                                                                                         class="form-radio">
                                    Βασικό</label>
                            </div>
                            <div class="form-item" id="edit-Γερμανικά-Καλό-wrapper">
                                <label class="option" for="edit-Γερμανικά-Καλό"><input type="radio"
                                                                                       id="edit-Γερμανικά-Καλό"
                                                                                       name="lang[5]" value="2"
                                                                                       class="form-radio"> Καλό</label>
                            </div>
                            <div class="form-item" id="edit-Γερμανικά-Πολύ-Καλό-wrapper">
                                <label class="option" for="edit-Γερμανικά-Πολύ-Καλό"><input type="radio"
                                                                                            id="edit-Γερμανικά-Πολύ-Καλό"
                                                                                            name="lang[5]"
                                                                                            value="3"
                                                                                            class="form-radio"> Πολύ
                                    Καλό</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-item" id="edit-Άλλες-γλώσες-wrapper">
                        <label for="extra_lang">Άλλες γλώσες: </label>
                        <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="extra_lang"
                                                                        id="edit-Άλλες-γλώσες"
                                                                        class="form-textarea resizable"></textarea>
                                {{--<div class="grippie"></div>--}}
                            </span>
                        </div>
                        <div class="description">Συμπληρώστε τις επιπλέον γλώσσες που γνωρίζετε και το επιπεδό σας</div>
                    </div>
                </fieldset>
                <div class="form-item" id="edit-Δίπλωμα-οδήγησης-wrapper">
                    <label for="driver_license_type_id">Δίπλωμα οδήγησης - Κατηγορία: </label>
                    <select name="driver_license_type_id" class="form-select" id="edit-Δίπλωμα-οδήγησης">
                        <option value="0" selected="selected">- Επιλέξτε -</option>
                        <option value="1">Χωρίς Δίπλωμα</option>
                        <option value="2">Α κατηγορίας</option>
                        <option value="3">Α1 κατηγορίας</option>
                        <option value="4">Β κατηγορίας</option>
                        <option value="5">Γ κατηγορίας</option>
                        <option value="6">Γ+Ε κατηγορίας</option>
                    </select>
                    <div class="description">Επιλέξτε την κατηγορία του διπλώματος σας εάν έχετε.</div>
                </div>
                <div class="form-item" id="edit-Χρήση-υπολογιστή-wrapper">
                    <label class="option" for="computer_usage"><input type="checkbox" name="computer_usage"
                                                                             id="edit-Χρήση-υπολογιστή"
                                                                             value="1" class="form-checkbox">
                        Χρήση υπολογιστή</label>
                    <input type="hidden" name="computer_usage_comments" value="">
                </div>
                <div class="form-item" id="edit-Πρόσθετες-ικανότητες-wrapper">
                    <label for="additional_skills">Πρόσθετες ικανότητες, προσόντα και εμπειρία : </label>
                    <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="additional_skills"
                                                                    id="edit-Πρόσθετες-ικανότητες"
                                                                    class="form-textarea resizable"></textarea>
                            {{--<div class="grippie"></div>--}}
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
                <div class="form-item" id="edit-Εργασιακή-κατάσταση-wrapper">
                    <label for="work_status_id">Εργασιακή κατάσταση: <span class="form-required"
                                                                                     title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    <select name="work_status_id" class="form-select required" id="edit-Εργασιακή-κατάσταση">
                        <option value="0">- Επιλέξτε -</option>
                        <option value="1">Φοιτητής</option>
                        <option value="2">Εργαζόμενος</option>
                        <option value="3">Άνεργος</option>
                        <option value="4">Συνταξιούχος</option>
                    </select>
                </div>
                <div class="form-item" id="edit-Εργασία-wrapper">
                    <label for="work_description">Εργασία: </label>
                    <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="work_description" id="edit-Εργασία"
                                                                    class="form-textarea resizable"></textarea>
                            {{--<div class="grippie"></div>--}}
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
                <div class="form-item" id="edit-Λόγος-συμετοχής-wrapper">
                    <label for="participation_reason">Λόγος συμετοχής: <span class="form-required"
                                                                             title="Το πεδίο είναι απαραίτητο.">*</span></label>
                    <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_reason"
                                                                    id="edit-Λόγος-συμετοχής"
                                                                    class="form-textarea resizable required"></textarea>
                            {{--<div class="grippie"></div>--}}
                        </span>
                    </div>
                    <div class="description">Περιγράψτε τους λόγους που θέλετε να γίνετε εθελοντής.</div>
                </div>
                <div class="form-item" id="edit-Εθελοντική-οργάνωση-wrapper">
                    <label for="participation_actions">Εθελοντική οργάνωση: </label>
                    <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_actions"
                                                                    id="edit-Εθελοντική-οργάνωση"
                                                                    class="form-textarea resizable"></textarea>
                            {{--<div class="grippie"></div>--}}
                        </span>
                    </div>
                    <div class="description">Εαν ανήκετε ή ανήκατε σε κάποιες εθελοντικές οργανώσεις ποιο ήταν το
                        αντικείμενο τους και για πόσο χρονικό διάστημα είχατε συμετοχή.
                    </div>
                </div>
                <div class="form-item" id="edit-Εθελοντικές-δράσεις-wrapper">
                    <label for="participation_previous">Εθελοντικές δράσεις: </label>
                    <div class="resizable-textarea"><span><textarea cols="60" rows="5" name="participation_previous"
                                                                    id="edit-Εθελοντικές-δράσεις"
                                                                    class="form-textarea resizable"></textarea>
                            {{--<div class="grippie"></div>--}}
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
                <div class="form-item" id="edit-Συχνότητα-συνεισφοράς-wrapper">
                    <label for="availability_freqs_id">Συχνότητα_συνεισφοράς: </label>
                    <select name="availability_freqs_id" class="form-select" id="edit-Συχνότητα-συνεισφοράς">
                        <option value="0" selected="selected">- Επιλέξτε -</option>
                        <option value="1">1-2 φορές την εβδομάδα</option>
                        <option value="2">1-2 φορές το δεκαπενθήμερο</option>
                        <option value="3">1-2 φορές τον μήνα</option>
                    </select>
                </div>
                <div class="form-item">
                    <label>Χρόνοι συνεισφοράς: </label>
                    <div class="form-checkboxes">
                        <div class="form-item" id="edit-Χρόνοι-συνεισφοράς-Πρωί-wrapper">
                            <label class="option" for="edit-Χρόνοι-συνεισφοράς-Πρωί"><input type="checkbox"
                                                                                            name="Χρόνοι_συνεισφοράς[Πρωί]"
                                                                                            id="edit-Χρόνοι-συνεισφοράς-Πρωί"
                                                                                            value="Πρωί"
                                                                                            class="form-checkbox"> Πρωί</label>
                        </div>
                        <div class="form-item" id="edit-Χρόνοι-συνεισφοράς-Απογεύμα-wrapper">
                            <label class="option" for="edit-Χρόνοι-συνεισφοράς-Απογεύμα"><input type="checkbox"
                                                                                                name="Χρόνοι_συνεισφοράς[Απογεύμα]"
                                                                                                id="edit-Χρόνοι-συνεισφοράς-Απογεύμα"
                                                                                                value="Απογεύμα"
                                                                                                class="form-checkbox">
                                Απογεύμα</label>
                        </div>
                        <div class="form-item" id="edit-Χρόνοι-συνεισφοράς-Σαββατοκύριακο-wrapper">
                            <label class="option" for="edit-Χρόνοι-συνεισφοράς-Σαββατοκύριακο"><input type="checkbox"
                                                                                                      name="Χρόνοι_συνεισφοράς[Σαββατοκύριακο]"
                                                                                                      id="edit-Χρόνοι-συνεισφοράς-Σαββατοκύριακο"
                                                                                                      value="Σαββατοκύριακο"
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
                        <p>Γνωρίζω ότι τα ανωτέρω στοιχεία θα παραμείνουν στο φορέα και αποδέχομαι ότι ο Δήμος Αθηναίων δύναται
                            να επεξεργαστεί δεδομένα προσωπικού χαρακτήρα μου και ειδικότερα τα εδώ αναφερόμενα δεδομένα μου για
                            τους σκοπούς οργάνωσης και πραγματοποίησης των εθελοντικών δράσεων. </p>
                        <p>Δεν υφίσταται σχέση εργασίας ή έργου μεταξύ εμού και του Γραφείου Εθελοντισμού του Δήμου Αθηναίων για
                            τις εθελοντικές υπηρεσίες που προσφέρω.</p>
                        <p>Ουδεμία απαίτηση χρηματική ή άλλης αποζημίωσης έχω έναντι του Γραφείου Εθελοντισμού λόγω της ανάληψης
                            των ανωτέρω αναφερόμενων εργασιών και της εθελοντικής μου προσφοράς σε αυτό.</p>
                        <p>Δηλώνω ότι δεν αντιμετωπίζω προβλήματα υγείας που θα μπορούσαν να επηρεάσουν την παροχή των ανωτέρω
                            εθελοντικών υπηρεσιών.</p>
                        <p>Στις εργασίες στις οποίες συμμετέχω εθελοντικά το Γραφείο Εθελοντισμού θα μπορεί να αναγράφει το
                            όνομά μου εφόσον το επιθυμώ και μετά από δήλωσή μου.</p>
                        <p>Το υλικό που το Γραφείο Εθελοντισμού μου παράσχει για την υλοποίηση των εργασιών που αναλαμβάνω καθώς
                            και τα παραγόμενα αποτελέσματα και προϊόντα αυτών ανήκουν αποκλειστικά και μόνον στο Γραφείο και ως
                            εκ τούτου δεν έχω κανένα δικαίωμα (συμπεριλαμβανομένων και των πνευματικών) χρήσης, δημοσίευσης,
                            πώλησης ή άλλο επί αυτών.</p>
                        <p>Μετά το πέρας της εθελοντικής μου εργασίας υποχρεούμαι να επιστρέψω στο Γραφείο Εθελοντισμού το υλικό
                            που μου έχει διατεθεί για το λόγο αυτό.</p>
                        <p>Κατά την διάρκεια υλοποίησης των εθελοντικών εργασιών που αναλαμβάνω, οφείλω να τηρώ τα χρονικά
                            πλαίσια που μου έχουν τεθεί από τον Φορέα και να ακολουθώ τις σχετικές υποδείξεις και οδηγίες που
                            μου δίνονται.</p>
                        <p>Το Γραφείο Εθελοντισμού έχει το δικαίωμα να με παύσει από τις αρμοδιότητές μου ή να αφαιρέσει τμήμα
                            των εθελοντικών εργασιών που αναλαμβάνω.</p>
                        <p>Κανένα άλλο δικαίωμα ή απαίτηση έχω έναντι του Γραφείου Εθελοντισμού.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-item" id="edit-oroi-wrapper">
            <label class="option" for="edit-oroi"><input type="checkbox" name="oroi" id="edit-oroi" value="1"
                                                         class="form-checkbox required"> Συμφωνώ</label>
        </div>


        Σημειώνεται ότι τα προσωπικά και άλλα δεδομένα που θα συμπληρωθούν στην παρούσα αίτηση θα διατηρηθούν στο αρχείο
        του Δήμου Αθηναίων, δεν θα αξιοποιηθούν για οποιονδήποτε άλλο σκοπό πέρα από την εθελοντική συμμετοχή στα
        προγράμματα του Δήμου, και δεν πρόκειται τρίτοι να έχουν πρόσβαση σ’ αυτά, τηρουμένων των ισχυουσών διατάξεων
        και ιδίως του άρθρου 10 ν. 2472/1997.<br>
        <div class="readon"><input class="button" type="submit" name="op" id="edit-submit" value="Αποστολή"></div>
        {{--<input type="hidden" name="form_build_id" id="form-7e2651a9f659467767dd107ebf13ed4f"--}}
               {{--value="form-7e2651a9f659467767dd107ebf13ed4f">--}}
        {{--<input type="hidden" name="form_id" id="edit-ethelontismosform-my-form" value="ethelontismosform_my_form">--}}
        <input type="hidden" name="comments" value="">

    </div>


{!! Form::close() !!}

    <script src="{{ asset('/assets/plugins/jquery/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('/athensmunicipality/js/volunteer_participation_form.js') }}"></script>

    {{-- bootstrap js --}}
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

</body>
</html>
