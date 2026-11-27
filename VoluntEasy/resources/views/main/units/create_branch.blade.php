@extends('default')

@section('title')
{{ trans('entities/units.create') }}
@stop

@section('pageTitle')
{{ trans('entities/units.create') }}
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
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch'],
                        'id' =>
                        'createForm']) !!}
                        @include('main.units.partials._form', ['submitButtonText' => 'none', 'type' => 'branch'])

                        <div class="form-group text-right">
                            {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
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
        // initialize the tree; if the submission returned errors,
        // the selected parent unit stays in the hidden input and is shown as active
        new Treewrapper({
            create: 'unit',
            active: {
                type: 'unit',
                id: document.getElementById('parent_unit_id').value
            }
        }).init();

        // initialize the user select
        VE.select('#userList');
    });
</script>
@append
