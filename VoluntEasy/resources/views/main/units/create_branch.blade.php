@extends('default')

@section('title')
Δημιουργία Κλαδιού Μονάδας
@stop

@section('pageTitle')
Δημιουργία Κλαδιού Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch']]) !!}
                @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'type' => 'branch'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}"
                        class="{{ in_array($tree->id, $userUnits) ? 'active-node' : 'disabled' }}"><span
                            class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.units.partials._branch_actions', ['unit' => $tree, 'userUnits' =>
                            $userUnits])
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

    //if the user has clciked on a unit, but the submittions returns errors,
    //the page gets reloaded and the active node is lost.
    //the value (unit id) stays in the hidden input so we can make it active again.
    if ($('#parent_unit_id').val() != '') {
        $("#tree li[data-id='" + $('#parent_unit_id').val() + "'").addClass('active-node');
    }

    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        chartClass: "jOrgChart actions",
        actions: true
    });

    $("#parent_unit").val($("#parent_unit").attr("data-value"));

    $(".node").click(function () {
        $("#parent_unit").val($(this).find(".description").text());
        $("#parent_unit_id").val($(this).attr("data-id"));
    })
</script>
@stop
