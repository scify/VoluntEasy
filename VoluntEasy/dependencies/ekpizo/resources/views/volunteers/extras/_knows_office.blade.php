<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->extras->knows_word))
    {!! Form::formInput('knows_word', 'Γνώση Word', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('knows_word', 'Γνώση Word', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => false, 'checked' => 'false']) !!}
    @endif
</div>
<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->extras->knows_excel))
    {!! Form::formInput('knows_excel', 'Γνώση Excel', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('knows_excel', 'Γνώση Excel', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => false, 'checked' => 'false']) !!}
    @endif
</div>
<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->extras->knows_powerpoint))
    {!! Form::formInput('knows_powerpoint', 'Γνώση Powerpoint', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('knows_powerpoint', 'Γνώση Powerpoint', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => false, 'checked' => 'false']) !!}
    @endif
</div>
