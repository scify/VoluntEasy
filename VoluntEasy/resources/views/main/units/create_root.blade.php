@extends('default')

@section('title')
    Δημιουργία Μονάδας
@stop

@section('pageTitle')
    Δημιουργία Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => $type]]) !!}
                    @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'type' => $type])
                {!! Form::close() !!}
           </div>
        </div>
    </div>
</div>

@stop
