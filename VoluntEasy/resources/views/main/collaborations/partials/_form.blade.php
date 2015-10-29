<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control', 'id' =>
                    'collabName', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('type', 'Τύπος:', $errors, ['class' => 'form-control', 'id' =>
                    'collabType', 'required' => 'true']) !!}
                    <small class="help-block">Π.χ.: ΜΚΟ, Οργανισμός κλπ</small>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::formInput('comments', 'Περιγραφή:', $errors, ['class' => 'form-control', 'type' =>
                    'textarea',
                    'size' =>
                    '5x5', 'id' => 'collabDescription']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('start_date', 'Ημερομηνία Έναρξης:', $errors, ['class' => 'form-control
                    startDate', 'id' => 'collabStartDate', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('end_date', 'Ημερομηνία Λήξης:', $errors, ['class' => 'form-control endDate',
                    'id' => 'collabEndDate', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('address', 'Διεύθυνση:', $errors, ['class' => 'form-control', 'id' =>
                    'collabAddress']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('phone', 'Τηλέφωνο:', $errors, ['class' => 'form-control', 'id' =>
                    'collabPhone'])
                    !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h5>Στοιχεία Υπευθύνου Συνεργασίας</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration))
                    {!! Form::formInput('execName', 'Όνομα:', $errors, ['class' => 'form-control', 'value' => $collaboration->executives[0]->name]) !!}
                    @else
                    {!! Form::formInput('execName', 'Όνομα:', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration))
                    {!! Form::formInput('execEmail', 'Email:', $errors, ['class' => 'form-control', 'value' => $collaboration->executives[0]->execEmail]) !!}
                    @else
                    {!! Form::formInput('execEmail', 'Email:', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration))
                    {!! Form::formInput('execAddress', 'Διεύθυνση:', $errors, ['class' => 'form-control', 'value' => $collaboration->executives[0]->address]) !!}
                    @else
                    {!! Form::formInput('execAddress', 'Διεύθυνση:', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration))
                    {!! Form::formInput('execPhone', 'Τηλέφωνο:', $errors, ['class' => 'form-control', 'value' => $collaboration->executives[0]->phone]) !!}
                    @else
                    {!! Form::formInput('execPhone', 'Τηλέφωνο:', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success', 'id' => 'saveCollaboration']) !!}
    </div>
</div>
