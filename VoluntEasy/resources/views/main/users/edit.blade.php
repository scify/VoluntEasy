@extends('default')

@section('title')
{{ trans('entities/users.edit') }}
@stop

@section('pageTitle')
{{ trans('entities/users.edit') }}
@stop

@section('bodyContent')

    {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
    => $user->id], 'files' => true]) !!}
    @include('main.users.partials._form', ['user' =>
    $user])
    @include('main.users.partials._roles', ['submitButtonText' => trans('default.save') ])
    {!! Form::close() !!}

@stop

