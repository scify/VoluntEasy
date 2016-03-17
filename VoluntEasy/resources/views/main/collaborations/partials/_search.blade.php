<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', trans('entities/collaborations.collabName').':', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('type', trans('entities/collaborations.type').':', $errors, ['class' => 'form-control input-sm search', 'id' =>
            'collabType', 'placeholder' => '...']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('start_date', trans('entities/collaborations.startDate').':', $errors, ['class' => 'form-control input-sm search
            startDate', 'id'
            => 'actionStartDate']) !!}
            <small class="help-block">{{ trans('entities/collaborations.startDateExpl') }}</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('end_date', trans('entities/collaborations.endDate').':', $errors, ['class' => 'form-control input-sm search
            endDate', 'id' =>
            'actionEndDate']) !!}
            <small class="help-block">{{ trans('entities/collaborations.endDateExpl') }}</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('active_only', trans('entities/collaborations.activeOnly'), $errors, ['class' => 'form-control', 'type' => 'checkbox',
            'value' => 'true', 'checked' => 'false']) !!}
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
@append
