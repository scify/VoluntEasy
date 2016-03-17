@extends('default')

@section('title')
{{ trans('entities/units.create') }}
@stop

@section('pageTitle')
{{ trans('entities/units.create') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'root']]) !!}
                @include('main.units.partials._form', ['submitButtonText' => 'none', 'type' => 'root'])

                <label>{{ trans('entities/units.selectExec') }}:</label>
                @include('main.units.partials._users', ['userIds' => [], 'users' => $users])

                <div class="form-group text-right">
                    {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('footerScripts')
<script>
    //initialize user select
    $('#userList').select2();
</script>
@stop
