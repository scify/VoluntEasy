<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('description', 'Όνομα Δράσης', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', 'Ανήκει στη μονάδα:', $errors, ['class' => 'form-control input-sm searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('start_date', 'Ημερομηνία Έναρξης:', $errors, ['class' => 'form-control input-sm search startDate', 'id'
            => 'actionStartDate']) !!}
            <small class="help-block">Δράσεις που ξεκινούν μετά από την ημερομηνία</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('end_date', 'Ημερομηνία Λήξης:', $errors, ['class' => 'form-control input-sm search endDate', 'id' =>
            'actionEndDate']) !!}
            <small class="help-block">Δράσεις που λήγουν πριν από την ημερομηνία</small>
        </div>
    </div>
    <div class="col-md-2">
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
            <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός</button>
        </div>
</div>
