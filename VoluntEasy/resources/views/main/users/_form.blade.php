   <div class="form-group">
       {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('password', 'Κωδικός:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('confirmPassword', 'Επιβεβαίωση κωδικού:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('addr', 'Διεύθυνση:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::formInput('tel', 'Τηλέφωνο:', $errors, ['class' => 'form-control']) !!}
   </div>
  <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>