@extends('default')

@section('title')
    Προσθήκη Μονάδας
@stop

@section('pageTitle')
    Προσθήκη Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">

                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store']]) !!}
                    @include('main.units._form', ['submitButtonText' => 'Αποθήκευση'])
                {!! Form::close() !!}
           </div>
        </div>
    </div>
</div>

@stop