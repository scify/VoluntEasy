@extends('default')

@section('title')
    Δημιουργία Κλαδιού Μονάδας
@stop

@section('pageTitle')
    Δημιουργία Κλαδιού Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch']]) !!}
                    @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'type' => 'branch'])
                {!! Form::close() !!}
           </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$unit->id}}" class="active-node"><span class="description">{{$unit->description}}</span>
                        <ul>
                            @include('main.units.partials._branch', array('$unit->allChildren' => $unit))
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
        chartElement: '#unitsTree'
    });

    $("#parent_unit").val($("#parent_unit").attr("data-value"));

    $(".node").click(function () {
        $("#parent_unit").val($(this).find(".description").text());
        $("#parent_unit_id").value($(this).attr("data-id"));
    })
</script>
@stop