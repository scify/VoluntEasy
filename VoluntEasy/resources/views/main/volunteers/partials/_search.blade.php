
        <div class="form-group">
            {!! Form::formInput('name', '', $errors, ['class' => 'form-control', 'placeholder' => 'Όνομα']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('last_name', '', $errors, ['class' => 'form-control', 'placeholder' => 'Επώνυμο']) !!}
        </div>

        <div class="form-group">
            {!! Form::formInput('birth_date', '', $errors, ['class' => 'form-control', 'placeholder' => 'Ημ. Γέννησης']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('email', '', $errors, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        </div>

        <div class="form-group">
            {!! Form::formInput('home_tel', '', $errors, ['class' => 'form-control', 'placeholder' => 'Τηλέφωνο']) !!}
        </div>
        <div class="form-group">
        {!! Form::formInput('marital_status_id', '', $errors, ['class' => 'form-control', 'type' => 'select', 'value' => $maritalStatuses]) !!}
        </div>


        <div class="form-group ">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </div>

