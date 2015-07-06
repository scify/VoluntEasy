@extends('default')

@section('title')
Προβολή Δράσης
@stop

@section('pageTitle')
Προβολή Δράσης
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2 id="unitDescription">{{$action->description}}</h2>
                    </div>
                    @if(in_array($action->unit->id, $userUnits))
                    <div class="col-md-4 text-right">
                        <a href="{{ url('actions/edit/'.$action->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> Επεξεργασία</a>
                        <a href="{{ url('actions/delete/'.$action->id) }}" class="btn btn-danger"><i
                                class="fa fa-edit"></i> Διαγραφή</a>
                    </div>
                    @endif
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        @include('main.actions.partials._details', array('action' => $action))
                    </div>
                    <div class="col-md-6">

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
                    @if(in_array($action->unit->id, $userUnits))
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#volunteersModal"><i
                                class="fa fa-leaf"></i> Προσθήκη Εθελοντών
                        </button>
                    </div>
                    @endif
                </div>
                <hr/>
                @include('main.units.partials._volunteers', ['unit' => $action])
            </div>
        </div>
    </div>
</div>

@include('main._modals._volunteers', ['volunteers' => $volunteers, 'active' => $action])


@stop


@section('footerScripts')
<script>
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
            url: $("body").attr('data-url') + '/actions/volunteers',
            method: 'POST',
            data: volunteersUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/actions/one/" + data;
            }
        });
    });
</script>
@stop
