   <div class="form-group">
       {!! Form::label('name', 'Name:') !!}
       {!! Form::text('name', null, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::label('email', 'Email:') !!}
       {!! Form::text('email', null, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::label('password', 'Password:') !!}
       {!! Form::text('password', null, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::label('addr', 'Διεύθυνση:') !!}
       {!! Form::text('addr', null, ['class' => 'form-control']) !!}
   </div>
   <div class="form-group">
       {!! Form::label('tel', 'Τηλέφωνο:') !!}
       {!! Form::text('tel', null, ['class' => 'form-control']) !!}
   </div>
  <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
  </div>