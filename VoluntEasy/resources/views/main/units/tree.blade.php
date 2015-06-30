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
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Tree</h4>
            </div>
            <div class="panel-body">

                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}" class="{{ in_array($tree->id, $userUnits) ? '' : 'disabled' }}"><span
                        class="description">{{$tree->description}}</span>
                    <ul>
                        @include('main.units.partials._branch_actions', ['unit' => $tree, 'userUnits' => $userUnits])
                    </ul>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>
    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        disabled: true
    });

</script>
@stop
