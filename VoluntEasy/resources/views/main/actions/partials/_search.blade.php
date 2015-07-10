<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('description', 'Όνομα Δράσης', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', 'Ανήκει στη μονάδα:', $errors, ['class' => 'form-control input-sm search',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('start_date', 'Ημερομηνία Έναρξης:', $errors, ['class' => 'form-control input-sm search', 'id'
            => 'actionStartDate']) !!}
            <small class="help-block">Δράσεις που ξεκινούν μετά από την ημερομηνία</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('end_date', 'Ημερομηνία Λήξης:', $errors, ['class' => 'form-control input-sm search', 'id' =>
            'actionEndDate']) !!}
            <small class="help-block">Δράσεις που λήγουν πριν από την ημερομηνία</small>
        </div>
    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-2">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
            <button type="submit" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός</button>
        </div>
    </div>
</div>

@section('footerScripts')
<script>
    //datepickers for the edit form
    $('#actionStartDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('#actionEndDate').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('#actionEndDate').datepicker('setStartDate', null);
    });

    //add restrictions: user should not be able to check
    // an end_date after start_date and vice-versa
    $('#actionEndDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('#actionStartDate').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('#actionStartDate').datepicker('setEndDate', null);
    });


    $("#clear").click(function(){

    });

</script>
@append
