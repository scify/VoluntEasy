@extends('default')

@section('title')
    Δημιουργία Κλαδιού Μονάδας
@stop

@section('pageTitle')
    Δημιουργία Κλαδιού Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch']]) !!}
                    @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'type' => 'branch'])
                {!! Form::close() !!}
           </div>
        </div>
    </div>


</div>

@stop


