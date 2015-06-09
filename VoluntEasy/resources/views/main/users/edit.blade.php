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
              @include('main.users.form', array("user" => $user))
           </div>
        </div>
    </div>
</div>

@stop