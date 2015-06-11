@extends('default')

@section('title')
    Επεξεργασία Χρήστη
@stop

@section('pageTitle')
    Επεξεργασία Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">

                {!! Form::open(['method' => 'POST', 'action' => ['UserController@store']]) !!}
                    @include('main.users._form', ['submitButtonText' => 'Αποθήκευση'])
                {!! Form::close() !!}

                @include('errors.list')
           </div>
        </div>
    </div>
</div>

@stop