<!DOCTYPE html>
<html>
<head>
    <title>Φόρμα Εθελοντή</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">

    <link href="{{ asset('css/public_volunteer_form.css')}}" rel="stylesheet" type="text/css"/>
</head>

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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage', 'Χρήση υπολογιστή', $errors, ['class' => 'form-control',
                        'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::formInput('computer_usage_comments', 'Δεξιότητες υπολογιστή:', $errors,
                        ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::formInput('additional_skills', 'Πρόσθετες ικανότητες, προσόντα και εμπειρία:', $errors,
                ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
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
                    @if (isset($volunteer) && $volunteer->lang_levels[$language]==$lev)
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
                'textarea', 'placeholder' => 'Συμπληρώστε τις επιπλέον γλώσσες που γνωρίζετε και το επίπεδό σας', 'size'
                => '2x3']) !!}
            </div>
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
                {!! Form::formInput('work_description', 'Εργασία:', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Περιγράψτε τη θέση σας στην παρούσα ή πιο πρόσφατη εργασία.']) !!}
            </div>

            <div class="form-group">
                {!! Form::formInput('participation_reason', 'Λόγος συμμετοχής:', $errors, ['class' => 'form-control',
                'required' => 'true', 'type' => 'textarea', 'placeholder' => 'Περιγράψτε τους λόγους που θέλετε να γίνετε εθελοντής.']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::formInput('participation_actions', 'Εθελοντική οργάνωση:', $errors, ['class' =>
                'form-control',
                'type' => 'textarea', 'placeholder' => 'Εαν ανήκετε ή ανήκατε σε κάποιες εθελοντικές οργανώσεις ποιο ήταν το αντικείμενο τους και για πόσο χρονικό διάστημα είχατε συμετοχή.']) !!}
            </div>
            <div class="form-group">
                {!! Form::formInput('participation_previous', 'Εθελοντικές δράσεις:', $errors, ['class' =>
                'form-control', 'type' => 'textarea', 'placeholder' => 'Εαν έχετε πάρει μέρος σε εθελοντικές δράσεις στο παρελθόν περιγράψτε ποιο ήταν/είναι το αντικείμενο.']) !!}
            </div>
        </div>
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
                    <td>@foreach($category->interests as $int_id => $interest)
                        <div class="form-group">
                            @if (isset($volunteer) && in_array($int_id, $volunteer->interests->lists('id')->all()) )
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


            <table class="table table-condensed table-bordered">
                <thead>
                <th>Ημέρα</th>
                <th>Πρωί</th>
                <th>Μεσημέρι</th>
                <th>Απόγευμα</th>
                </thead>
                <tr>
                    <td>Δευτέρα</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Τρίτη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Τετάρτη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Πέμπτη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Παρασκεύη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Σαββατο</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Κυριακή</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        {!! Form::formInput('availability_time' . $a_t_id, '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                    </td>
                    @endforeach
                </tr>
            </table>

        </div>
        <div class="col-md-3">
            <div class="form-group">
                <p>Χρόνοι συνεισφοράς:</p>
                @foreach($availabilityTimes as $a_t_id => $availability_time)
                @if (isset($volunteer) && in_array($a_t_id, $volunteer->availabilityTimes->lists('id')->all()) )
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
</div>
<div class="row m-b-lg text-right">
    <div class="col-md-12">
        {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success']) !!}
    </div>
</div>
</div>
