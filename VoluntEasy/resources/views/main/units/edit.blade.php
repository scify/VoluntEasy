@extends('default')

@section('title')
    Επεξεργασία Μονάδας
@stop

@section('pageTitle')
    Επεξεργασία Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">

                {!! Form::model($unit, ['method' => 'POST', 'action' => ['UnitController@update', 'id' => $unit->id]]) !!}
                    @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'unit' => $unit])
                {!! Form::close() !!}
           </div>
        </div>
    </div>
</div>

@stop