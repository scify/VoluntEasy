@extends('default')

@section('title')
    Δημιουργία Χρήστη
@stop

@section('pageTitle')
    Δημιουργία Χρήστη
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Χρήστες</h4>
           </div>
           <div class="panel-body">
              @include('main.users.form')
           </div>
        </div>
    </div>
</div>

@stop