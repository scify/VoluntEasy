<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('description', 'Όνομα Μονάδας', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('parent_unit_id', 'Ανήκει στη μονάδα:', $errors, ['class' => 'form-control input-sm searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-2">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> Αναζήτηση</button>
            <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> Καθαρισμός</button>
        </div>
    </div>
</div>


@section('footerScripts')
<script>
    $("#clear").click(function(){
        $(".search").val('');
        $(".searchDropDown").val('0');
    });

</script>
@append
