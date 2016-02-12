<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->knows_office))
    {!! Form::formInput('computer_usage', 'Γνώση Word', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('computer_usage', 'Γνώση Word', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
    @endif
</div>
<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->knows_office))
    {!! Form::formInput('computer_usage', 'Γνώση Excel', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('computer_usage', 'Γνώση Excel', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
    @endif
</div>
<div class="form-group">
    @if (isset($volunteer) && isset($volunteer->knows_office))
    {!! Form::formInput('computer_usage', 'Γνώση Powerpoint', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'true']) !!}
    @else
    {!! Form::formInput('computer_usage', 'Γνώση Powerpoint', $errors, ['class' => 'form-control',
    'type' => 'checkbox', 'value' => true, 'checked' => 'false']) !!}
    @endif
</div>
