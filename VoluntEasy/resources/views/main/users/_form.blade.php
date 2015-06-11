   <div class="form-group">
       {!! Form::textError('name', 'Όνομα:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::textError('email', 'Email:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::textError('password', 'Κωδικός:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::textError('confirmPassword', 'Επιβεβαίωση κωδικού:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::textError('addr', 'Διεύθυνση:', $errors, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::textError('tel', 'Τηλέφωνο:', $errors, ['class' => 'form-control']) !!}
   </div>
  <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>