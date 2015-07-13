@extends('default')

@section('title')
Επεξεργασία Δράσης
@stop

@section('pageTitle')
Επεξεργασία Δράσης
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;" data-id="{{ $action->id }}">
                    <li data-id="{{$tree->id}}" ><span
                            class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.tree._branch_actions', ['unit' => $tree])
                        </ul>
                    </li>
                </ul>
                @include('main.tree._legend')
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::model($action, ['method' => 'POST', 'action' => ['ActionController@update', 'id' => $action->id]]) !!}
                @include('main.actions.partials._form', ['submitButtonText' => 'Αποθήκευση', 'action' =>$action])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop


@section('footerScripts')
<script>

    $("#tree li.action[data-id='"+$('#tree').attr("data-id")+"'").addClass('active-node');

    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        disabled: true
    });

</script>
@stop
