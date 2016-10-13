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
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if(isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'monday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('monday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>{{ trans('entities/volunteers.tuesday') }}</td>
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if (isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'tuesday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('tuesday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>{{ trans('entities/volunteers.wednesday') }}</td>
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if (isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'wednesday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('wednesday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>{{ trans('entities/volunteers.thursday') }}</td>
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if (isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'thursday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('.thursday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>{{ trans('entities/volunteers.friday') }}</td>
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if (isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'friday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('friday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>{{ trans('entities/volunteers.saturday') }}</td>
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if (isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'saturday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('saturday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
            <tr>
                <td>{{ trans('entities/volunteers.sunday') }}</td>
                @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
                <td class="text-center">
                    <?php $checked = 'false' ?>
                    @if (isset($volunteer))
                    @foreach($volunteer->availabilityDays as $day)
                    @if($day->day == 'sunday' && $day->time == $availability_time)
                    <?php $checked = 'true' ?>
                    @endif
                    @endforeach
                    @endif
                    {!! Form::formInput('sunday'.'[]', '', $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'value' => $a_t_id , 'checked' => $checked]) !!}
                </td>
                @endforeach
            </tr>
        </table>

        <div class="form-group" id="dailyFrequencies">
            <p>{{ trans('entities/volunteers.availabilityTimes') }}:</p>
            @foreach($allAvailabilityTimes as $a_t_id => $availability_time)
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
