<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', 'Όνομα συνεργαζόμενου φορέα', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('type', 'Τύπος', $errors, ['class' => 'form-control input-sm search', 'id' =>
            'collabType', 'placeholder' => '...']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('start_date', 'Ημερομηνία Έναρξης:', $errors, ['class' => 'form-control input-sm search
            startDate', 'id'
            => 'actionStartDate']) !!}
            <small class="help-block">Συμβάσεις που ξεκινούν μετά από την ημερομηνία</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('end_date', 'Ημερομηνία Λήξης:', $errors, ['class' => 'form-control input-sm search
            endDate', 'id' =>
            'actionEndDate']) !!}
            <small class="help-block">Συμβάσεις που λήγουν πριν από την ημερομηνία</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('active_only', 'Μόνο οι ενεργές συμβάσεις', $errors, ['class' => 'form-control', 'type' => 'checkbox',
            'value' => 'true', 'checked' => 'false']) !!}
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
            <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός</button>
        </div>
    </div>
</div>

@section('footerScripts')
<script src="{{ asset('assets/js/pages/search.js') }}"></script>
@append
