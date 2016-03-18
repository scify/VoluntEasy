<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('name', trans('entities/users.name').':', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('email', trans('entities/users.email').':', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('unit_id', trans('entities/users.unitUser').':', $errors, ['class' => 'form-control input-sm searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group ">
            <button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i> {{ trans('default.search') }}</button>
            <button type="button" id="clear" class="btn btn-default"><i class="fa fa-remove"></i> {{ trans('default.clear') }}</button>
        </div>
    </div>
</div>

