@extends('default')

@section('title')
Οι εκκρεμότητές μου
@stop
@section('pageTitle')
Οι εκκρεμότητές μου
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Οι εκκρεμότητές μου</h4>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.users.partials._pendingVolunteers')
            </div>
        </div>
    </div>
</div>

@stop


