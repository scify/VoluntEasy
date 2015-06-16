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
   <div class="form-group">
       {!! Form::formInput('parent_unit_id', 'Πατέρας:', $errors, ['class' => 'form-control']) !!}
   </div>
   {!! Form::hidden('level', '0') !!}
  <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>



<script>
    //datepickers for the edit form
     $('#start_date').datepicker({
         language: 'el',
         format: 'dd/mm/yyyy',
         autoclose: true
     }).on('changeDate', function (selected) {
           var startDate = new Date(selected.date.valueOf());
           $('#end_date').datepicker('setStartDate', startDate);
       }).on('clearDate', function (selected) {
           $('#end_date').datepicker('setStartDate', null);
       });

     $('#end_date').datepicker({
         language: 'el',
         format: 'dd/mm/yyyy',
         autoclose: true
     }).on('changeDate', function (selected) {
           var endDate = new Date(selected.date.valueOf());
           $('#start_date').datepicker('setEndDate', endDate);
       }).on('clearDate', function (selected) {
           $('#start_date').datepicker('setEndDate', null);
       });
 </script>