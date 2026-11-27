@extends('default')

@section('title')
{{ trans('entities/units.edit') }}
@stop

@section('pageTitle')
{{ trans('entities/units.edit') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/units.info') }}</h4>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::model($active, ['method' => 'POST', 'action' => ['UnitController@update', 'id'
                => $active->id,
                'type' => $type]]) !!}
                @include('main.units.partials._form', ['submitButtonText' => trans('default.save'), 'unit' => $active])
                <div class="form-group text-right">
                    {!! Form::submit( trans('default.save'), ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
                {!! Form::hidden('unit_id', $active->id, ['id' => 'unit_id']) !!}
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/units.selectParent') }} <span class="star">*</span></h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.tree._showTree')
            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>
    VE.ready(function () {
        // initialize the tree
        new Treewrapper({
            active: {
                type: 'unit',
                id: document.getElementById('unit_id').value
            },
            disabled: true
        }).init();

        // initialize the user select
        VE.select('#userList');
    });
</script>
@append
