@extends('default')

@section('title')
Προβολή Δράσης
@stop

@section('pageTitle')
Προβολή Δράσης
@stop


@section('bodyContent')


<div class="panel panel-white tree">
    <div class="panel-heading clearfix">
        <h2 class="panel-title">Στοιχεία Δράσης</h2>

        <div class="panel-control">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"
               data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
        </div>
    </div>
    <div class="panel-body" style="display: block;">
        <div class="row">
            <div class="col-md-4">
                <h3>Δράση {{ $action->description }}</h3>

                <p>
                    <small>
                        @foreach($branch as $key => $unit)
                        @if($key < sizeof($branch)-1)
                        <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a> <i
                            class="fa fa-angle-right"></i>
                        @else
                        <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
                        @endif
                        @endforeach
                    </small>
                </p>
                <p><strong>Περιγραφή:</strong> {{ $action->comments==null || $action->comments=='' ? '-' :
                    $action->comments }}</p>

                <p><strong>Διάρκεια:</strong> {{ $action->start_date }} - {{ $action->end_date }}</p>
            </div>
            <div class="col-md-4">
                <h3>Στοιχεία Υπευθύνου</h3>
                @if($action->name!=null && $action->name!='')
                <ul class="list-unstyled">
                    <li class="user-list">
                        <p class="msg-name">{{$action->name}}</p>

                        <p class="msg-text"><i class="fa fa-envelope"></i> <a href="mail:to{{ $action->email }}">{{
                            $action->email }}</a> |
                            <i class="fa fa-phone"></i> {{ $action->phone_number }}</p>
                    </li>
                </ul>
                @else
                <p>Δεν έχει οριστεί υπεύθυνος δράσης</p>
                @endif
            </div>
            <hr/>
            @if(in_array($action->unit->id, $userUnits))
            <div class="text-right">
                <a href="{{ url('actions/edit/'.$action->id) }}" class="btn btn-success"><i
                        class="fa fa-edit"></i> Επεξεργασία</a>
                <button onclick="deleteAction({{ $action->id }})" class="btn btn-danger"><i
                        class="fa fa-trash"></i> Διαγραφή</button>
            </div>
            @endif
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.actions.partials._volunteers')
                @if(in_array($action->unit->id, $userUnits))
                <hr/>
                <div class="text-right">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#volunteersModal"><i
                            class="fa fa-leaf"></i> Προσθήκη Εθελοντών
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@include('main._modals._volunteers', ['active' => $action])


@stop


@section('footerScripts')
<script>
    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        chartClass: "jOrgChart actions",
        actions: true
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

        $.ajax({
            url: $("body").attr('data-url') + '/actions/volunteers',
            method: 'POST',
            data: volunteersUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                window.location.href = $("body").attr('data-url') + "/actions/one/" + data;
            }
        });
    });


    //delete action and redirect to action list
    function deleteAction(id) {
        if (confirm("Είτε σίγουροι ότι θέλετε να διαγράψετε τη δράση;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/actions/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    window.location = $("body").attr('data-url') + '/actions';
                }
            });
        }
    }
</script>
@append
