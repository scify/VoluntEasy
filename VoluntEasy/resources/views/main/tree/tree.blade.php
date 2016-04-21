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

    //initialize the tree
    var treewrapper = new Treewrapper({
        disabled:true
    });
    treewrapper.init();

</script>
@append
