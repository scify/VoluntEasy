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
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Στοιχεία Μονάδας
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                {!! Form::model($active, ['method' => 'POST', 'action' => ['UnitController@update', 'id'
                                => $active->id,
                                'type' => $type]]) !!}
                                @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'unit' =>
                                $active])
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                   aria-expanded="false" aria-controls="collapseTwo">
                                    Υπεύθυνοι
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
                                @include('main.units.partials._users', ['unit' =>$active, 'users' => $users])
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Δράσεις
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingThree">
                            <div class="panel-body">
                                @include('main.units.partials._actions', ['unit' =>$active, 'userIds' => $userIds])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>


                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}"
                    {{ $active->id==$tree->id ? 'class=active-node' : '' }}><span class="description">{{$tree->description}}</span>
                    <ul>
                        @include('main.units.partials._branch_active', ['unit' => $tree, 'active' => $active->id])
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
    //initialize the tree
    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        disabled: true
    });

    //initialize user select
    $('#userList').select2();


    $("#saveUsers").click(function () {
        var users = [];
        $('#userList :selected').each(function (i, selected) {
            users[i] = $(selected).val();
        });

        var userUnits = {
            id: $("#saveUsers").attr('data-id'),
            users: users
        };

        $.ajax({
            url: '/main/units/users',
            method: 'POST',
            data: userUnits,
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            success: function (data) {
                window.location.href = "/main/units/one/" + data;
            }
        });
    });


    /*
     $(".node").click(function () {
     $.ajax({
     url: '/main/units/one/' + $(this).attr('data-id'),
     success: function (data) {
     console.log(data);
     $(".unit-details").html(data);
     }
     });
     })*/
</script>
@stop
