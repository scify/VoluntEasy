@extends('default')

@section('title')
{{ trans('entities/actions.view') }}
@stop
@section('pageTitle')
{{ trans('entities/actions.view') }}
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['ActionController@search'], 'id' => 'searchForm']) !!}
                @include('main.actions.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/actions.actions') }}                </h4>
            </div>
            <div class="panel-body">
                @include('main.actions.partials._table')
            </div>
        </div>
    </div>
</div>
@stop


