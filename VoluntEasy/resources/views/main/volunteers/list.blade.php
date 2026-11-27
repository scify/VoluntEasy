@extends('default')

@section('title')
{{ trans('entities/volunteers.view') }}
@stop
@section('pageTitle')
{{ trans('entities/volunteers.view') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['VolunteerController@search'], 'id' => 'searchForm'])
                !!}
                @include('main.volunteers.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/volunteers.volunteers') }}</h4>
            </div>
            <div class="panel-body">
                @include('main.volunteers.partials._table')
                <hr/>
                @include('main.volunteers.partials._legend')
            </div>
        </div>
    </div>
</div>

@stop
