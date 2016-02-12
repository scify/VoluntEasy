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
