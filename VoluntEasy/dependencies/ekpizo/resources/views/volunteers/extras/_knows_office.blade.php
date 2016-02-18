<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->knows_office))
    {!! Form::formInput('knows_office', 'Γνώση Word', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('knows_office', 'Γνώση Word', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
    @endif
</div>
<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->knows_excel))
    {!! Form::formInput('knows_excel', 'Γνώση Excel', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('knows_excel', 'Γνώση Excel', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
    @endif
</div>
<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->knows_powerpoint))
    {!! Form::formInput('knows_powerpoint', 'Γνώση Powerpoint', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('knows_powerpoint', 'Γνώση Powerpoint', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
    @endif
</div>
