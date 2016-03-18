@extends('default')

@section('title')
{{ trans('entities/users.create') }}
@stop

@section('pageTitle')
{{ trans('entities/users.create') }}
@stop

@section('bodyContent')


<div class="row">
    {!! Form::open(['method' => 'POST', 'action' => ['UserController@store'], 'files'=>true]) !!}
    @include('main.users.partials._form')
    @include('main.users.partials._roles', ['submitButtonText' =>  trans('default.save') ])
    {!! Form::close() !!}
</div>


@stop


@section('footerScripts')
<script>

    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        multiple: true,
        ulId: "#tree",
        children: true
    });


</script>
@append
