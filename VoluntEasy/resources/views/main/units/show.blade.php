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
            <div class="panel-heading clearfix">
                <h2 class="panel-title">Στοιχεία Μονάδας</h2>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <h3>Μονάδα {{$active->description}}</h3>

                        <p><strong>Περιγραφή:</strong> {{$active->comments}}</p>
                    </div>
                    <div class="col-md-4">
                        @if(sizeof($active->users)==0)
                        <h3>Υπεύθυνοι Μονάδας:</h3>

                        <p>-</p>
                        @elseif(sizeof($active->users)==1)
                        <h3>Υπεύθυνος Μονάδας</h3>
                        <ul class="list-unstyled">
                            <li class="user-list">
                                <div class="msg-img"><img src="{{ asset('assets/images/default.png')}}" alt=""
                                                          class="user-image-small"></div>
                                <p class="msg-name"><a href="{{ url('users/one/'.$active->users[0]->id) }}">{{$active->users[0]->name}}</a>

                                <p>

                                <p class="msg-text"><i class="fa fa-envelope"></i> <a
                                        href="mail:to{{ $active->users[0]->email }}">{{ $active->users[0]->email }}</a>
                                    |
                                    <i class="fa fa-home"></i> {{ $active->users[0]->addr }} |
                                    <i class="fa fa-phone"></i> {{ $active->users[0]->tel }}</p>
                            </li>
                        </ul>
                        @else
                        <h3>Υπεύθυνοι Μονάδας:</h3>
                        <ul class="list-unstyled">
                            @foreach($active->users as $user)
                            <li class="user-list">
                                <div class="msg-img"><img src="{{ asset('assets/images/default.png')}}" alt=""
                                                          class="user-image-small"></div>
                                <p class="msg-name"><a href="{{ url('users/one/'.$user->id) }}">{{$user->name}}</a>

                                <p>

                                <p class="msg-text"><i class="fa fa-envelope"></i> <a href="mail:to{{ $user->email }}">{{
                                    $user->email }}</a> |
                                    <i class="fa fa-home"></i> {{ $user->addr }} |
                                    <i class="fa fa-phone"></i> {{ $user->tel }}</p>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($type=='leaf')
                        <h3>Ενεργές Δράσεις:</h3>
                        @if(sizeof($active->actions)==0)
                        <h3>-</h3>
                        @else
                        <ul class="list-unstyled">
                            @foreach($active->actions as $action)
                            <li>
                                <p class="user-list"><a href="{{ url('actions/one/'.$action->id) }}">{{$action->description}}</a>
                                    <small>{{ $action->start_date }} - {{ $action->end_date }}</small>
                                </p>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        @endif

                    </div>
                </div>
                <hr/>
                @if(in_array($active->id, $userUnits))
                <div class="text-right">
                    <a href="{{ url('units/edit/'.$active->id) }}" class="btn btn-success"><i
                            class="fa fa-edit"></i> Επεξεργασία</a>
                    <button onclick="deleteUnit({{ $active->id }})" class="btn btn-danger"><i
                            class="fa fa-trash"></i> Διαγραφή</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="panel panel-white tree">
    <div class="panel-heading clearfix">
        <h2 class="panel-title">Δέντρο</h2>

        <div class="panel-control">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"
               data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
        </div>
    </div>
    <div class="panel-body" style="display: block;">
        @include('main.tree._tree', ['editing' => 'unit', 'actives' => $actives])

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
                <div class="row">
                    <div class="col-md-12">
                        @include('main.units.partials._volunteers', ['unit' => $active])
                    </div>
                </div>
                @if(in_array($active->id, $userUnits))
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#volunteersModal"><i
                                    class="fa fa-leaf"></i> Προσθήκη Εθελοντών
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Όλες οι δράσεις</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.units.partials._allactions', ['unit' => $active])
            </div>
        </div>
    </div>
</div>

<!-- Include the modal that has the select2 with all the available volunteers -->
@include('main._modals._volunteers')


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
            url: $("body").attr('data-url') + '/units/volunteers',
            method: 'POST',
            data: volunteersUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/units/one/" + data;
            }
        });
    });

    //delete a unit and redirect to unit list
    function deleteUnit(id) {
        if (confirm("Είτε σίγουροι ότι θέλετε να διαγράψετε τη μονάδα;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/units/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    window.location = $("body").attr('data-url') + '/units';
                }
            });
        }
    }

</script>
@append
