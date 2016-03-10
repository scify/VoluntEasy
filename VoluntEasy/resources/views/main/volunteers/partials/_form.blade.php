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
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('birth_date', 'Ημερομηνία Γέννησης:', $errors, ['class' => 'form-control
                        birthDate', 'id' => 'birth_date', 'required' => 'true']) !!}
                        <small class="help-block text-primary under18" style="display:none;">Ο εθελοντής είναι
                            ανήλικος
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
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
                {!! Form::formInput('city', 'Πόλη:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
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
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('afm', 'Α.Φ.Μ.:',
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
                {!! Form::formInput('cell_tel', 'Κινητό:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
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
                {!! Form::formInput('comm_method_id', 'Προτιμώμενος τρόπος επικοινωνίας:', $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $commMethod, 'key' => $volunteer->comm_method_id]) !!}
                @else
                {!! Form::formInput('comm_method_id', 'Προτιμώμενος τρόπος επικοινωνίας:', $errors, ['class' =>
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
                <div class="col-md-4">
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
            </div>
            <div class="row top-margin">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage', 'Χρήση υπολογιστή', $errors, ['class' => 'form-control',
                        'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
                    </div>
                    {{-- Extras--}}
                    @if(in_array('knows_office', $extras))
                        @include($extrasPath.'._knows_office')
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage_comments', 'Λοιπές δεξιότητες υπολογιστή:', $errors,
                        ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::formInput('additional_skills', 'Πρόσθετες ικανότητες, προσόντα και εμπειρία:',
                        $errors,
                        ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                    </div>
                </div>
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


             {{--
                <p> {{ $language . ':' }}</p>
                {!! Form::label('') !!}
                @foreach ($langLevels as $lev => $level)
                <label>
                    <em>{{ $level }}</em>
                    @if (isset($volunteer) && isset($volunteer->lang_levels[$language]) &&
                    $volunteer->lang_levels[$language]==$lev)
                    {!! Form::formInput('lang'.$lan, '', $errors, ['class' => 'form-control languages', 'type' =>
                    'radio', 'value'
                    => $lev, 'checked' => 'true']) !!}
                    @else
                    {!! Form::formInput('lang'.$lan, '', $errors, ['class' => 'form-control languages', 'type' =>
                    'radio', 'value'
                    => $lev, 'checked' => 'false']) !!}
                    @endif
                </label>
                @endforeach
                --}}
            </div>
            @endforeach
            <div class="form-group">
                <button class="btn btn-default" id="cleanLanguages">Καθαρισμός</button>
            </div>

            <div class="form-group">
                {!! Form::formInput('extra_lang', 'Άλλες γλώσσες', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Συμπληρώστε τις επιπλέον γλώσσες που γνωρίζετε και το επίπεδό σας', 'size'
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
            <p>Περιοχές ενδιαφερόντων:</p>

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
    </div>
</div>
<!-- tab6 Comments -->
<div class="tab-pane fade" id="tab6">
    <div class="row m-b-lg">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Σχόλια σχετικά με τον εθελοντή']) !!}
            </div>

            <div class="form-group">
                @if (isset($volunteer))
                {!! Form::formInput('howYouLearned', 'Πως μάθατε για εμάς;', $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $howYouLearned, 'key' =>
                $volunteer->how_you_learned_id]) !!}
                @else
                {!! Form::formInput('howYouLearned', 'Πως μάθατε για εμάς;', $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $howYouLearned]) !!}
                @endif
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
                    {{ isset($volunteer) && in_array($unit->id, $volunteer->unitsExcludes->lists('id')->all()) ?
                    'selected'
                    :
                    '' }} >{{ $unit->description }}</option>

                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {!! Form::formInput('files[]', 'Ανέβασμα αρχείων:', $errors, ['class' => 'form-control', 'type' =>
                'file', 'multiple' => 'true'])
                !!}
                <small class="help-blocκ">Μπορείτε να ανεβάσετε περισσότερα από 1 αρχεία.</small>
                <br/>
                <small class="help-blocκ">Τα αρχεία δεν πρέπει να ξεπερνούν σε μέγεθος τα 10mb.</small>
            </div>
            @if(isset($volunteer))
            <div class="form-group">
                @if(sizeof($volunteer->files)>0)
                <p>Ανεβασμένα αρχεία:</p>

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
        {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success']) !!}
    </div>
</div>
</div>

@section('footerScripts')
<script>

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


    var freqsId = $("#availability_freqs_id option:selected").val();
    if (freqsId == 2 || freqsId == 3 || freqsId == 4) {
        $("#dailyFrequencies").hide();
        $("#daysTable").fadeIn();
    }


</script>
@append
