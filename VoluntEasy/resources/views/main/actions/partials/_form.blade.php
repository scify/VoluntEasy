<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('description', trans('entities/actions.name').':', $errors, ['class' => 'form-control', 'id' =>
            'actionDescription', 'required' => 'true']) !!}
        </div>
        <div class="form-group">
            {!! Form::formInput('comments', trans('entities/actions.description').':', $errors, ['class' => 'form-control', 'type' => 'textarea',
            'size' =>
            '5x5', 'id' => 'actionComments']) !!}
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('start_date', trans('entities/actions.searchStartDate').':', $errors, ['class' => 'form-control
                    startDate', 'id' => 'actionStartDate', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('end_date', trans('entities/actions.searchEndDate').':', $errors, ['class' => 'form-control endDate',
                    'id' => 'actionEndDate', 'required' => 'true']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('name', trans('entities/actions.commExecInfo').':', $errors, ['class' => 'form-control', 'id' =>
                    'actionName']) !!}
                    <small class="help-block">{{ trans('entities/actions.execNameExpl') }}
                    </small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('email', trans('entities/actions.execEmail').':', $errors, ['class' => 'form-control', 'id' => 'actionEmail'])
                    !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('phone_number', trans('entities/actions.execPhone').':', $errors, ['class' => 'form-control', 'id' =>
                    'actionPhone'])
                    !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('volunteer_sum', trans('entities/actions.volNum').':', $errors, ['class' => 'form-control', 'id'
                    =>
                    'actionPhone'])
                    !!}
                    <small class="help-block">{{ trans('entities/actions.volNumExpl') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    {!! Form::formInput('unit_id', null, $errors, ['type' => 'hidden', 'id' => 'unit_id']) !!}
    <div class="form-group text-right">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success', 'id' => 'saveAction']) !!}
    </div>
</div>

