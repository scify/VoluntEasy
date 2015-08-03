<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('description', 'Όνομα:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
        </div>
        <label>Επιλογή Υπευθύνου/ων:</label>
        @include('main.units.partials._users')
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::formInput('comments', 'Περιγραφή:', $errors, ['class' => 'form-control', 'type' => 'textarea',
            'size' =>
            '5x5', 'required' => 'true']) !!}
        </div>
    </div>
</div>

@if($type=='root')
{!! Form::hidden('level', 0) !!}
@elseif($type=='branch' || $type=='leaf')
{!! Form::hidden('level', 0) !!}
{!! Form::formInput('parent_unit_id', '', $errors, ['type' => 'hidden', 'id' => 'parent_unit_id']) !!}
@endif
