@extends('default')

@section('title')
{{ trans('entities/tree.tree') }}
@stop
@section('pageTitle')
{{ trans('entities/tree.tree') }}
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
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
        new Treewrapper({disabled: true}).init();
    });
</script>
@append
