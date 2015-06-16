@extends('default')

@section('title')
Προβολή Μονάδας
@stop

@section('pageTitle')
Προβολή Μονάδας
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">
                @section('details')
                  @include('main.units.partials._details', array('$unit->allChildren' => $unit))
                @append
                <div class="unit-details">
                    @include('main.units.partials._details', array('$unit->allChildren' => $unit))
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Tree</h4>
            </div>
            <div class="panel-body">

                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$unit->id}}">{{$unit->description}}
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