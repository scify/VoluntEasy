@extends('default')

@section('title')
{{ trans('entities/actions.create') }}
@stop

@section('pageTitle')
{{ trans('entities/actions.create') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/actions.info') }}
                </h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(['method' => 'POST', 'action' => ['ActionController@store']]) !!}
                        @include('main.actions.partials._form', ['submitButtonText' => trans('default.save')])
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
                <h4 class="panel-title">{{ trans('entities/actions.selectParent') }} <span class="star">*</span></h4>

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

    //initialize the tree
    var treewrapper = new Treewrapper({
        create: 'action'
    });
    treewrapper.init();

</script>
@append
