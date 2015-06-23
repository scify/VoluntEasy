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
                {!! Form::model($active, ['method' => 'POST', 'action' => ['UnitController@update', 'id' => $active->id,
                'type' => $type]]) !!}
                @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'unit' => $active])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>


                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}" {{ $active->id==$tree->id ? 'class=active-node' : '' }}><span class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.units.partials._branch_active', ['unit' => $tree,  'active' => $active->id])
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

    $(".node").click(function () {
        $.ajax({
            url: '/main/units/one/' + $(this).attr('data-id'),
            success: function (data) {
                console.log(data);
                $(".unit-details").html(data);
            }
        });
    })
</script>
@stop
