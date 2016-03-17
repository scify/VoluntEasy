<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('description', trans('entities/units.unitName').':', $errors, ['class' => 'form-control input-sm search']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('parent_unit_id', trans('entities/units.belongsTo').':', $errors, ['class' => 'form-control input-sm searchDropDown',
            'type' => 'select', 'value' => $units]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('user_id', trans('entities/units.executive').':', $errors, ['class' => 'form-control input-sm searchDropDown',
            'type' => 'select', 'value' => $users]) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::formInput('my_units', trans('entities/units.myUnits'), $errors, ['class' => 'form-control', 'type' => 'checkbox', 'value' => 'true', 'checked' => 'false']) !!}
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

