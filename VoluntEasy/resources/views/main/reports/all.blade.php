@extends('default')

@section('title')
Reports
@stop
@section('pageTitle')
Reports
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">


                 @include('main.reports._volunteersByMonth')

            </div>
        </div>
    </div>
</div>
@stop



