<h3>Στοιχεία Χρήστη</h3>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control']) !!}
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('addr', 'Διεύθυνση:', $errors, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('tel', 'Τηλέφωνο:', $errors, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('password', 'Κωδικός:', $errors, ['class' => 'form-control',
            'type' =>'password']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('password_confirmation', 'Επιβεβαίωση κωδικού:', $errors,
            ['class' => 'form-control', 'type' =>'password']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <div class="form-group">
            {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
        </div>
    </div>
</div>
