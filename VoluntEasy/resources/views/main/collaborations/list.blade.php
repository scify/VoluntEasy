@extends('default')

@section('title')
Προβολή Συνεργασιών
@stop
@section('pageTitle')
Προβολή Συνεργασιών
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['CollaborationController@search'], 'id' => 'searchForm']) !!}
                @include('main.collaborations.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Συνεργασίες</h4>
            </div>
            <div class="panel-body">
                @include('main.collaborations.partials._table')
            </div>
        </div>
    </div>
</div>
@stop


