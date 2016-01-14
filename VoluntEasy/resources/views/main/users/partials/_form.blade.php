<div class="col-md-2">
@if(isset($user))
    <div class="profile-image-container user-image text-center">
        <img src="{{ ($user->image_name==null || $user->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$user->image_name) }}"
             alt="" class="user-image-small userImage">
    </div>
@endif

@if(!isset($user) || (isset($user) && Auth::user()->id==$user->id))
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::formInput('image', 'Ανέβασμα φωτογραφίας', $errors, ['class' => 'form-control', 'type' =>
            'file'])
            !!}
        </div>
    </div>
</div>
@endif
</div>


<div class="col-md-6">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
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
                {!! Form::formInput('tel', 'Τηλέφωνο:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    @if(!isset($user) || (isset($user) && Auth::user()->id==$user->id))
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::formInput('password', 'Κωδικός:', $errors, ['class' => 'form-control',
                'type' =>'password', 'required' => 'true']) !!}
                <small class="help-block">Ο κωδικός πρέπει να έχει μήκος τουλάχιστον 8 χαρακτήρες και να περιέχει τουλάχισον ένα κεφαλαίο γράμμα και έναν αριθμό.</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::formInput('password_confirmation', 'Επιβεβαίωση κωδικού:', $errors,
                ['class' => 'form-control', 'type' =>'password', 'required' => 'true']) !!}
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                @if (isset($user))
                {!! Form::formInput('role_id', 'Ρόλος:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $workStatuses, 'key' => $volunteer->role_id]) !!}
                @else
                {!! Form::formInput('role_id', 'Ρόλος:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $roles]) !!}
                @endif
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
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
</div>
