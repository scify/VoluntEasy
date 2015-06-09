@extends('default')

@section('title')
    Προσθήκη Χρήστη
@stop

@section('pageTitle')
    Προσθήκη Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">

                {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@store', $user->id]]) !!}
                    @include('main.users._form', ['submitButtonText' => 'Αποθήκευση', 'user' => $user])
                {!! Form::close() !!}
                
                @include('errors.list')
           </div>
        </div>
    </div>
</div>

@stop