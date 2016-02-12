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

    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-bordered" id="daysTable">
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
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Δευτέρα' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Δευτέρα[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Τρίτη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Τρίτη' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Τρίτη[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Τετάρτη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Τετάρτη' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Τετάρτη[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Πέμπτη</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Πέμπτη' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Πέμπτη[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Παρασκευή</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Παρασκευή' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Παρασκευή[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Σάββατο</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Σάββατο' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Σάββατο[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Κυριακή</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == 'Κυριακή' && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput('Κυριακή[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
            </table>

            <div class="form-group" id="dailyFrequencies">
                <p>Χρόνοι συνεισφοράς:</p>
                @foreach($availabilityTimes as $a_t_id => $availability_time)
                @if (isset($volunteer) && in_array($a_t_id, $volunteer->availabilityTimes->lists('id')->all()) )
                {!! Form::formInput('availability_time[]', $availability_time, $errors, ['class' =>
                'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'true']) !!}
                @else
                {!! Form::formInput('availability_time[]', $availability_time, $errors, ['class' =>
                'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => 'false']) !!}
                @endif
                @endforeach
            </div>
        </div>
    </div>
