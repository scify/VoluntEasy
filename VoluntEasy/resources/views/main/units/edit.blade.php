@extends('default')

@section('title')
Επεξεργασία Μονάδας
@stop

@section('pageTitle')
Επεξεργασία Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::model($unit, ['method' => 'POST', 'action' => ['UnitController@update', 'id' => $unit->id,
                'type' => $type]]) !!}
                @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'unit' => $unit])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$unit->allParents->id}}"
                    {{ $unit->id==$unit->allParents->id ? 'class="active-node"' : '' }}><span class="description">{{$unit->allParents->description}}</span>
                    <ul>
                        @include('main.units.partials._branch_active', ['unit' => $unit->allParents, 'active' => $unit->id])
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

    $(".node").click(function () {
        $.ajax({
            url: '/main/units/one/' + $(this).attr('data-id'),
            success: function (data) {
                $(".unit-details").html(data);
            }
        });

    })

</script>
@stop
