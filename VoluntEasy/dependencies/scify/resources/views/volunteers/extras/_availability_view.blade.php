<p><strong>{{ trans('entities/volunteers.contributionRate') }}:</strong> {{
    $volunteer->availability_freqs_id==null || $volunteer->availability_freqs_id=='' ? '' :
    $volunteer->availabilityFrequencies->description }}</p>

<p><strong>{{ trans('entities/volunteers.daysAndTimes') }}:</strong>
    @foreach($volunteer->availabilityDays as $i => $day)
    @if($i==0)
    {{ trans('entities/volunteers.'.$day->day) }} {{ trans('entities/volunteers.'.$day->time) }}
    @else
    ,  {{ trans('entities/volunteers.'.$day->day) }} {{ trans('entities/volunteers.'.$day->time) }}
    @endif
    @endforeach
</p>
