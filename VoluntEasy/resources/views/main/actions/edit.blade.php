@extends('default')

@section('title')
Επεξεργασία Δράσης
@stop

@section('pageTitle')
Επεξεργασία Δράσης
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::model($action, ['method' => 'POST', 'action' => ['ActionController@update', 'id' => $action->id]]) !!}
                @include('main.actions.partials._form', ['submitButtonText' => 'Αποθήκευση', 'action' =>$action])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;" data-id="{{ $action->id }}">
                    <li data-id="{{$tree->id}}" ><span
                            class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.units.partials._branch_actions', ['unit' => $tree])
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

    $("#tree li.action[data-id='"+$('#tree').attr("data-id")+"'").addClass('active-node');

    //datepickers for the edit form
    $('#actionStartDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('#actionEndDate').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('#actionEndDate').datepicker('setStartDate', null);
    });

    //add restrictions: user should not be able to check
    // an end_date after start_date and vice-versa
    $('#actionEndDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('#actionStartDate').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('#actionStartDate').datepicker('setEndDate', null);
    });


    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        disabled: true
    });


    $(".node.leaf").click(function () {
        $("#unit_id").val($(this).attr("data-id"));
    })



</script>
@stop
