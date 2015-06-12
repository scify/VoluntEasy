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

                {!! Form::open(['method' => 'POST', 'action' => ['UserController@store']]) !!}
                    @include('main.users._form', ['submitButtonText' => 'Αποθήκευση'])
                {!! Form::close() !!}
           </div>
        </div>
    </div>
</div>

@stop