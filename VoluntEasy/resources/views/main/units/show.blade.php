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


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Εθελοντές</h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#volunteersModal"><i
                                class="fa fa-leaf"></i> Προσθήκη Εθελοντών
                        </button>
                    </div>
                </div>
                <hr/>
                @include('main.units.partials._volunteers', ['unit' => $active])
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="volunteersModal"
     aria-labelledby="actionModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Προσθήκη Εθελοντών</h4>
            </div>
            <div class="modal-body">
                <select class="js-states form-control" id="volunteerList" multiple="multiple" tabindex="-1"
                        style="display: none; width: 100%">
                    @foreach($volunteers as $volunteer)
                    <option value="{{ $volunteer->id }}">{{$volunteer->name.' '.$volunteer->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="saveVolunteers" data-id="{{ $active->id }}">Αποθήκευση</button>
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


    //initialize user select
    $('#volunteerList').select2();


    // get the array of volunteers selected and save them
    $("#saveVolunteers").click(function () {
        //array of volunteers
        var volunteers = [];
        $('#volunteerList :selected').each(function (i, selected) {
            volunteers[i] = $(selected).val();
        });

        var volunteersUnits = {
            id: $("#saveVolunteers").attr('data-id'),
            volunteers: volunteers
        };

        console.log(volunteersUnits);

        $.ajax({
            url: '/main/units/volunteers',
            method: 'POST',
            data: volunteersUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = "/main/units/one/" + data;
            }
        });
    });

</script>
@stop
