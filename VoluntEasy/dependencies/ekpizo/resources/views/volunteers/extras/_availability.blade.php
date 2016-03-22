    <div class="form-group">
        @if (isset($volunteer))
        {!! Form::formInput('availability_freqs_id', trans('entities/volunteers.contributionRate').':', $errors, ['class' =>
        'form-control', 'type' => 'select', 'value' => $availabilityFreqs, 'key' =>
        $volunteer->availability_freqs_id]) !!}
        @else
        {!! Form::formInput('availability_freqs_id', trans('entities/volunteers.contributionRate').':', $errors, ['class' =>
        'form-control', 'type' => 'select', 'value' => $availabilityFreqs]) !!}
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-bordered" id="daysTable">
                <thead>
                <th>{{ trans('entities/volunteers.date') }}</th>
                <th>{{ trans('entities/volunteers.morning') }}</th>
                <th>{{ trans('entities/volunteers.afternoon') }}</th>
                <th>{{ trans('entities/volunteers.evening') }}</th>
                </thead>
                <tr>
                    <td>{{ trans('entities/volunteers.monday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.monday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.monday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>{{ trans('entities/volunteers.tuesday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.tuesday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.tuesday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>{{ trans('entities/volunteers.wednesday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.wednesday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.wednesday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>{{ trans('entities/volunteers.thursday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.thursday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.thursday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>{{ trans('entities/volunteers.friday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.friday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.friday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>{{ trans('entities/volunteers.saturday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.saturday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.saturday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td>{{ trans('entities/volunteers.sunday') }}</td>
                    @foreach($availabilityTimes as $a_t_id => $availability_time)
                    <td class="text-center">
                        <?php $checked = 'false' ?>
                        @if (isset($volunteer))
                        @foreach($volunteer->availabilityDays as $day)
                        @if($day->day == trans('entities/volunteers.sunday') && $day->time == $availability_time)
                        <?php $checked = 'true' ?>
                        @endif
                        @endforeach
                        @endif
                        {!! Form::formInput(trans('entities/volunteers.sunday').'[]', '', $errors, ['class' =>
                        'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                    </td>
                    @endforeach
                </tr>
            </table>

            <div class="form-group" id="dailyFrequencies">
                <p>{{ trans('entities/volunteers.availabilityTimes') }}:</p>
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
