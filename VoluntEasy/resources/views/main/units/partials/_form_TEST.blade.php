   <div class="form-group">
       {!! Form::formInput('description', 'Περιγραφή:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' => 'textarea', 'size' => '5x5']) !!}
   </div>
   <div class="row">
       <div class="col-md-6">
           <div class="form-group {{($errors->has('start_date') ? 'has-error' : '') }}">
                <label for="start_date">Ημερομηνία Έναρξης:</label>
                <div class='input-group date' id='start_date'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                @if ($errors->has('start_date')) <p class="help-block">{{ $errors->first('start_date') }}</p> @endif
           </div>
       </div>
       <div class="col-md-6">
           <div class="form-group {{($errors->has('end_date') ? 'has-error' : '') }}">
                <label for="end_date">Ημερομηνία Λήξης:</label>
                <div class='input-group date' id='end_date'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
               </div>
               @if ($errors->has('end_date')) <p class="help-block">{{ $errors->first('end_date') }}</p> @endif
           </div>
       </div>
   </div>

   <div class="form-group">
       {!! Form::formInput('parent_unit_id', 'Πατέρας:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('level', 'Επίπεδο:', $errors, ['class' => 'form-control']) !!}
   </div>
  <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>



@section('footerScripts')
 <script type="text/javascript">
     $('#start_date').datepicker({
         language: 'el',
         format: 'dd/mm/yyyy',
         orientation: "top auto"
     }).on('changeDate', function (selected) {
           var startDate = new Date(selected.date.valueOf());
           $('#end_date').datepicker('setStartDate', startDate);
       }).on('clearDate', function (selected) {
           $('#end_date').datepicker('setStartDate', null);
       });

     $('#end_date').datepicker({
         language: 'el',
         format: 'dd/mm/yyyy',
         orientation: "top auto"
     }).on('changeDate', function (selected) {
           var endDate = new Date(selected.date.valueOf());
           $('#start_date').datepicker('setEndDate', endDate);
       }).on('clearDate', function (selected) {
           $('#start_date').datepicker('setEndDate', null);
       });
 </script>
 @stop