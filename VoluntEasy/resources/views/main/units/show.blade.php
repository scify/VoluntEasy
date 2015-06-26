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
                    <div class="col-md-8">
                        <h2 id="unitDescription">{{$active->description}}</h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ url('main/units/edit/'.$active->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> Επεξεργασία</a>
                        <a href="{{ url('main/units/delete/'.$active->id) }}" class="btn btn-danger"><i
                                class="fa fa-edit"></i> Διαγραφή</a>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="unit-details">
                            @include('main.units.partials._details', array('active' => $active, 'type' => $type))
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="unitsTree"></div>
                        <ul id="tree" style="display:none;">
                            <li data-id="{{$active->id}}"
                            {{ $active->id==$tree->id ? 'class=active-node' : '' }}><span
                                class="description">{{$tree->description}}</span>
                            <ul>
                                @include('main.units.partials._branch_active', ['unit' => $tree, 'active' =>
                                $active->id])
                            </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr/>

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
        chartElement: '#unitsTree',
        disabled: true
    });

</script>
@stop
