   <div class="form-group">
       {!! Form::formInput('description', 'Περιγραφή:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' => 'textarea', 'size' => '5x5']) !!}
   </div>
   {!! Form::hidden('level', '0') !!}
   {!! Form::hidden('parent_unit_id', '0') !!}
   {!! Form::hidden('parent_unit_id', '0') !!}
   {!! Form::hidden('parent_unit_id', '0') !!}
  <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>