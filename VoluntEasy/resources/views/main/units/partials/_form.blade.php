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
    {!! Form::hidden('level', $tree->level+1) !!}
    {!! Form::hidden('parent_unit_id', $tree->id, ['id' => 'parent_unit_id']) !!}
@endif
<div class="form-group text-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
</div>
