<div class="form-group">
    {!! Form::formInput('description', 'Όνομα:', $errors, ['class' => 'form-control', 'id' => 'actionDescription', 'required' => 'true']) !!}
</div>
<div class="form-group">
    {!! Form::formInput('comments', 'Περιγραφή:', $errors, ['class' => 'form-control', 'type' => 'textarea', 'size' =>
    '5x5', 'id' => 'actionComments', 'required' => 'true']) !!}
</div>
<div class="form-group">
    {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control', 'id' => 'actionEmail']) !!}
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('start_date', 'Ημερομηνία Έναρξης:', $errors, ['class' => 'form-control startDate', 'id' => 'actionStartDate', 'required' => 'true']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('end_date', 'Ημερομηνία Λήξης:', $errors, ['class' => 'form-control endDate',  'id' => 'actionEndDate', 'required' => 'true']) !!}
        </div>
    </div>
</div>
{!! Form::formInput('unit_id', null, $errors, ['type' => 'hidden', 'id' => 'unit_id']) !!}
<div class="form-group text-right">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success', 'id' => 'saveAction']) !!}
</div>


