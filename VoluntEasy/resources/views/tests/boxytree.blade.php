@extends('default')

@section('title')
Tree
@stop
@section('pageTitle')
Tree
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <div id="boxytree"></div>

            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script src="{{ asset('assets/js/treewrapper.js')}}"></script>

<script>

var treewrapper = new Treewrapper({
    create: 'action'
});
treewrapper.init();

</script>
@append

