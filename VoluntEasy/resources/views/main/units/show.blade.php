@extends('default')

@section('title')
Προβολή Μονάδας
@stop

@section('pageTitle')
Προβολή Μονάδας
@stop


@section('bodyContent')

<div class="row">


    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 id="unitDescription">{{$unit->description}}</h2>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        @section('details')
                        @include('main.units.partials._details', array('$unit->allChildren' => $unit))
                        @append
                        <div class="unit-details">
                            @include('main.units.partials._details', array('$unit->allChildren' => $unit))
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="unitsTree"></div>
                        <ul id="tree" style="display:none;">
                            <li data-id="{{$unit->id}}" class="active-node"><span
                                    class="description">{{$unit->description}}</span>
                                <ul>
                                    @include('main.units.partials._branch', array('$unit->allChildren' => $unit))
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr/>
                        <div class="text-right">
                            <a href="{{ url('main/units/edit/'.$unit->id) }}" class="btn btn-success"><i
                                    class="fa fa-edit"></i> Επεξεργασία</a>
                            <a href="{{ url('main/units/delete/'.$unit->id) }}" class="btn btn-danger"><i
                                    class="fa fa-edit"></i> Διαγραφή</a>
                        </div>
                    </div>
                </div>

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