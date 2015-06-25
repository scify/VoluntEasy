<div class="form-group">
       {!! Form::formInput('description', 'Περιγραφή:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' => 'textarea', 'size' => '5x5']) !!}
   </div>
     <div class="row">
       <div class="col-md-6">
           <div class="form-group">
                 {!! Form::formInput('start_date', 'Ημερομηνία Έναρξης:', $errors, ['class' => 'form-control', 'data-provide' => 'datepicker']) !!}
           </div>
       </div>
       <div class="col-md-6">
           <div class="form-group">
                {!! Form::formInput('end_date', 'Ημερομηνία Λήξης:', $errors, ['class' => 'form-control', 'data-provide' => 'datepicker']) !!}
           </div>
       </div>
     </div>
       {!! Form::formInput('unit_id', null, $errors, ['type' => 'hidden', 'id' => 'unit_id']) !!}
  <div class="form-group text-right">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>


