@extends('default')

@section('title')
{{ trans('entities/actions.edit') }}
@stop

@section('pageTitle')
{{ trans('entities/actions.edit') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/actions.info') }}</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($action, ['method' => 'POST', 'action' => ['ActionController@update', 'id' => $action->id]]) !!}
                        @include('main.actions.partials._form', ['submitButtonText' => trans('default.save'), 'action' =>$action])
                        {!! Form::close() !!}
                        {!! Form::hidden('action_id', $action->id, ['id' => 'action_id']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

