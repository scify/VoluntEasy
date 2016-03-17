<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('description', trans('entities/actions.actionName') .':', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', trans('entities/actions.belongsTo') .':', $errors, ['class' => 'form-control input-sm
            searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('start_date', trans('entities/actions.searchStartDate') .':', $errors, ['class' => 'form-control input-sm search
            startDate', 'id'
            => 'actionStartDate']) !!}
            <small class="help-block">{{ trans('entities/actions.searchStartDateExpl') }}</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('end_date', trans('entities/actions.searchEndDate') .':', $errors, ['class' => 'form-control input-sm search
            endDate', 'id' =>
            'actionEndDate']) !!}
            <small class="help-block">{{ trans('entities/actions.searchEndDateExpl') }}</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('active_only', trans('entities/actions.onlyActive'), $errors, ['class' => 'form-control', 'type' => 'checkbox',
            'value' => 'true', 'checked' => 'false']) !!}
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <p><a href="#" id="showFilters">{{ trans('entities/actions.moreFilters') }}</a></p>
    </div>
</div>


<!-- More filters -->
<div class="row" id="filters" style="display:none;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::formInput('name', trans('entities/actions.execName') .':', $errors, ['class' => 'form-control input-sm search', 'id' =>
                    'actionUser', 'placeholder' => '...']) !!}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> {{ trans('default.search') }}</button>
            <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> {{ trans('default.clear') }}</button>
        </div>
    </div>
</div>

@section('footerScripts')
<script src="{{ asset('assets/js/pages/search.js') }}"></script>

<script>
    $("#showFilters").click(function () {
        $("#filters").toggle();
    });
</script>
@append
