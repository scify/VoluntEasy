<div class="tab-content">
<!-- tab1 Ατομικά στοιχεία.-->
<div class="tab-pane active fade in" id="tab1">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('last_name', 'Επώνυμο:', $errors, ['class' => 'form-control', 'required' => 'true'])
                !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('fathers_name', 'Όνομα Πατέρα:', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::formInput('birth_date', 'Ημερομηνία Γέννησης:', $errors, ['class' => 'form-control
                        birthDate', 'id' => 'birth_date', 'required' => 'true']) !!}
                        <small class="help-block text-primary under18" style="display:none;">Ο εθελοντής είναι ανήλικος</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('gender_id', 'Φύλο:', $errors, ['class' => 'form-control', 'type' =>
                        'select', 'value' => $genders, 'key' => $volunteer->gender_id]) !!}
                        @else
                        {!! Form::formInput('gender_id', 'Φύλο:', $errors, ['class' => 'form-control', 'type' =>
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
                        {!! Form::formInput('address', 'Διεύθυνση:', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('post_box', 'Τ.Κ:', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::formInput('city', 'Πόλη:', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('country', 'Χώρα:', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('live_in_curr_country', 'Κάτοικος Ελλάδας', $errors, ['class' => 'form-control',
                'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!} <em>(Αποεπιλέξτε εφόσον δε διαμένετε
                μόνιμα στην Ελλάδα.)</em>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('identification_type_id', 'Τύπος ταυτότητας:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $identificationTypes, 'key' =>
                        $volunteer->identification_type_id]) !!}
                        @else
                        {!! Form::formInput('identification_type_id', 'Τύπος ταυτότητας:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $identificationTypes]) !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::formInput('identification_num', 'Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής:',
                        $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('marital_status_id', 'Οικογενειακή κατάσταση:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $maritalStatuses, 'key' =>
                        $volunteer->marital_status_id]) !!}
                        @else
                        {!! Form::formInput('marital_status_id', 'Οικογενειακή κατάσταση:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $maritalStatuses]) !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('children', 'Αριθμός τέκνων:', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- tab2 Στοιχεία επικοινωνίας. -->
<div class="tab-pane fade" id="tab2">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('home_tel', 'Τηλέφωνο Οικίας:', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('work_tel', 'Τηλέφωνο Εργασίας:', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('cell_tel', 'Κινητό:', $errors, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('fax', 'Fax:', $errors, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
            <div class="form-group">
                @if (isset($volunteer))
                {!! Form::formInput('comm_method_id', 'Να επικοινωνήσουμε μαζί σας στο:', $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $commMethod, 'key' => $volunteer->comm_method_id]) !!}
                @else
                {!! Form::formInput('comm_method_id', 'Να επικοινωνήσουμε μαζί σας στο:', $errors, ['class' =>
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
                        {!! Form::formInput('education_level_id', 'Επίπεδο εκπαίδευσης:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $edLevel, 'key' =>
                        $volunteer->education_level_id]) !!}
                        @else
                        {!! Form::formInput('education_level_id', 'Επίπεδο εκπαίδευσης:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $edLevel]) !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('specialty', 'Ειδικότητα:', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('department', 'Σχολή:', $errors, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        @if (isset($volunteer))
                        {!! Form::formInput('driver_license_type_id', 'Δίπλωμα οδήγησης:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $driverLicenseTypes, 'key' =>
                        $volunteer->driver_license_type_id]) !!}
                        @else
                        {!! Form::formInput('driver_license_type_id', 'Δίπλωμα οδήγησης:', $errors, ['class' =>
                        'form-control', 'type' => 'select', 'value' => $driverLicenseTypes]) !!}
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage', 'Χρήση υπολογιστή', $errors, ['class' => 'form-control',
                        'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::formInput('additional_skills', 'Πρόσθετες ικανότητες, προσόντα και εμπειρία', $errors,
                ['class' => 'form-control', 'type' => 'textarea']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <p>Ξένες γλώσσες:</p>
            @foreach ($languages as $lan => $language)
            <div class="form-group">
                <p> {{ $language . ':' }}</p>
                {!! Form::label('') !!}
                @foreach ($langLevels as $lev => $level)
                <label>
                    <em>{{ $level }}</em>
                    @if (isset($volunteer) && in_array($lan, $volunteer->languages->lists('language_id')) )
                    {!! Form::formInput('lang'.$lan, '', $errors, ['class' => 'form-control', 'type' => 'radio', 'value'
                    => $lev, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('lang'.$lan, '', $errors, ['class' => 'form-control', 'type' => 'radio', 'value'
                    => $lev, 'checked' => 'false']) !!}
                    @endif
                </label>
                @endforeach
            </div>
            @endforeach

            <div class="form-group">
                {!! Form::formInput('extra_lang', 'Άλλες γλώσσες', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Συμπληρώστε τις επιπλέον γλώσσες που γνωρίζετε και το επίπεδό σας']) !!}
            </div>
            <br>
            <br>
        </div>
    </div>
</div>
<!-- tab4 Εργασιακή εμπειρία και εθελοντική προσφορά. -->
<div class="tab-pane fade" id="tab4">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                @if (isset($volunteer))
                {!! Form::formInput('work_status_id', 'Εργασιακή κατάσταση:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $workStatuses, 'key' => $volunteer->work_status_id]) !!}
                @else
                {!! Form::formInput('work_status_id', 'Εργασιακή κατάσταση:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $workStatuses]) !!}
                @endif
            </div>
            <div class="form-group">
                {!! Form::formInput('work_description', 'Εργασία', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Περιγράψτε τη θέση σας στην παρούσα ή πιο πρόσφατη εργασία.']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('participation_actions', 'Εθελοντική οργάνωση', $errors, ['class' => 'form-control',
                'type' => 'textarea', 'placeholder' => 'Εαν ανήκετε ή ανήκατε σε κάποιες εθελοντικές οργανώσεις ποιο ήταν το αντικείμενο τους και για πόσο χρονικό διάστημα είχατε συμετοχή.']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('participation_previous', 'Εθελοντικές δράσεις', $errors, ['class' =>
                'form-control', 'type' => 'textarea', 'placeholder' => 'Εαν έχετε πάρει μέρος σε εθελοντικές δράσεις στο παρελθόν περιγράψτε ποιο ήταν/είναι το αντικείμενο.']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('participation_reason', 'Λόγος συμμετοχής', $errors, ['class' => 'form-control',
                'required' => 'true', 'type' => 'textarea', 'placeholder' => 'Περιγράψτε τους λόγους που θέλετε να γίνετε εθελοντής.']) !!}
            </div>
        </div>
    </div>
</div>
<!-- tab5 Διαθεσιμότητα. -->
<div class="tab-pane fade" id="tab5">
    <div class="row m-b-lg">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    @if (isset($volunteer))
                    {!! Form::formInput('availability_freqs_id', 'Συχνότητα συνεισφοράς:', $errors, ['class' =>
                    'form-control', 'type' => 'select', 'value' => $availabilityFreqs, 'key' =>
                    $volunteer->availability_freqs_id]) !!}
                    @else
                    {!! Form::formInput('availability_freqs_id', 'Συχνότητα συνεισφοράς:', $errors, ['class' =>
                    'form-control', 'type' => 'select', 'value' => $availabilityFreqs]) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <p>Χρόνοι συνεισφοράς:</p>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    @if (isset($volunteer) && in_array($a_t_id, $volunteer->availabilityTimes->lists('id')) )
                    {!! Form::formInput('availability_time' . $a_t_id, $availability_time, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('availability_time' . $a_t_id, $availability_time, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <p>Περιοχές ενδιαφερόντων:</p>
                <h4>Πολιτισμός και Αθλητισμός</h4>
                @foreach($interests as $int_id => $interest)
                @if($interest->category=='Πολιτισμός και Αθλητισμός')
                <div class="form-group">
                    @if (isset($volunteer) && in_array($int_id, $volunteer->interests->lists('id')) )
                    {!! Form::formInput('interest' . $interest->id, $interest->description , $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('interest' . $interest->id, $interest->description, $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'false']) !!}
                    @endif
                </div>
                @endif
                @endforeach
                <h4>Για το Παιδί</h4>
                @foreach($interests as $int_id => $interest)
                @if($interest->category=='Για το Παιδί')
                <div class="form-group">
                    @if (isset($volunteer) && in_array($int_id, $volunteer->interests->lists('id')) )
                    {!! Form::formInput('interest' . $interest->id, $interest->description , $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('interest' . $interest->id, $interest->description, $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'false']) !!}
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            <div class="col-md-4">
                <h4>Περιβάλλον</h4>
                @foreach($interests as $int_id => $interest)
                @if($interest->category=='Περιβάλλον')
                <div class="form-group">
                    @if (isset($volunteer) && in_array($int_id, $volunteer->interests->lists('id')) )
                    {!! Form::formInput('interest' . $interest->id, $interest->description , $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('interest' . $interest->id, $interest->description, $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'false']) !!}
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            <div class="col-md-4">
                <h4>Διεύθυνση Κοινωνικής Αλληλεγγύης και Υγείας</h4>
                @foreach($interests as $int_id => $interest)
                @if($interest->category=='Διεύθυνση Κοινωνικής Αλληλεγγύης και Υγείας')
                <div class="form-group">
                    @if (isset($volunteer) && in_array($int_id, $volunteer->interests->lists('id')) )
                    {!! Form::formInput('interest' . $interest->id, $interest->description , $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('interest' . $interest->id, $interest->description, $errors, ['class' =>
                    'form-control',
                    'type' => 'checkbox', 'value' => $interest->id, 'checked' => 'false']) !!}
                    @endif
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- tab6 Comments -->
<div class="tab-pane fade" id="tab6">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('comments', 'Σχόλια', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Σχόλια σχετικά με τον εθελοντή']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <p>Αποκλεισμός εθελοντή από τις μονάδες:</p>

                <select class="js-states form-control" id="unitList" multiple="multiple" name="unitsSelect[]"
                        tabindex="-1"
                        style="display: none; width: 100%">

                    @foreach($units as $unit_id => $unit)
                    <option value="{{ $unit->id }}" name="unit-{{$unit->id}}"
                    {{ isset($volunteer) && in_array($unit->id, $volunteer->unitsExcludes->lists('id')) ? 'selected' :
                    '' }} >{{ $unit->description }}</option>

                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row m-b-lg text-right">
    <div class="col-md-12">
        {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success']) !!}
    </div>
</div>
</div>

@section('footerScripts')
<script>

    $('#birth_date').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var birthDate = new Date(selected.date.valueOf());
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        //display message that the volunteer is underage
        if(age<18)
            $(".under18").show();
        else if(age>18)
            $(".under18").hide();

    });

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


</script>
@append
