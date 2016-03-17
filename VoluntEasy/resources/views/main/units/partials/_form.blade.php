<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('description', trans('entities/units.name').':', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
        </div>
        <label>{{ trans('entities/units.selectExec') }}:</label>
        @include('main.units.partials._users')
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('comments', trans('entities/units.description').':', $errors, ['class' => 'form-control', 'type' => 'textarea',
            'size' =>
            '5x5']) !!}
        </div>
    </div>
</div>

@if($type=='root')
{!! Form::hidden('level', 0) !!}
@elseif($type=='branch' || $type=='leaf')
{!! Form::hidden('level', 0) !!}
{!! Form::formInput('parent_unit_id', '', $errors, ['type' => 'hidden', 'id' => 'parent_unit_id']) !!}
@endif
