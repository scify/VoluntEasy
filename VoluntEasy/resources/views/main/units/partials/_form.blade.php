<div class="form-group">
    {!! Form::formInput('description', 'Περιγραφή:', $errors, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' => 'textarea', 'size' =>
    '5x5']) !!}
</div>
@if($type=='root')
    {!! Form::hidden('level', 0) !!}
@elseif($type=='branch')
    <div class="form-group">
        {!! Form::formInput('parent_unit', 'Πατέρας:', $errors, ['class' => 'form-control', 'data-value' => $unit->description]) !!}
    </div>
    {!! Form::hidden('level', $unit->level+1) !!}
    {!! Form::hidden('parent_unit_id', $unit->id) !!}
@endif
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
</div>
