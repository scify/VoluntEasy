@extends('default')

@section('title')
Επεξεργασία Χρήστη
@stop

@section('pageTitle')
Επεξεργασία Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i
                            class="fa fa-user m-r-xs"></i>Ατομικά Στοιχεία</a></li>
                    <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-home m-r-xs"></i>Οργανωτικές
                        Μονάδες</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active fade in" id="tab1">
                        <div class="row m-b-lg">
                            <div class="col-md-6">
                                {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
                                => $user->id]]) !!}
                                @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση', 'user' =>
                                $user])
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2">
                        <div class="row m-b-lg">
                            <div class="col-md-4">
                                @if(isset($user))
                                @if (sizeof($user->units)==0)
                                <h3>Ο χρήστης δεν ανήκει σε καμία οργανωτική μονάδα.</h3>

                                <div class="text-right">
                                </div>
                            </div>
                            @else
                            <ul class="list-unstyled">
                                @foreach($user->units as $unit)
                                <li><a href="#" class="unit" data-id="{{$unit->id}}">{{$unit->description}}</a></li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div id="unitsTree"></div>
                            <ul id="tree" style="display:none;">
                                <li data-id="{{$tree->id}}"><span class="description">{{$tree->description}}</span>
                                    <ul>
                                        @include('main.units.partials._branch_actives', ['unit' => $tree, 'active' =>
                                        $active])
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-success" id="save" data-user-id="{{$user->id}}">
                            Αποθήκευση
                        </button>

                        @endif
                        @endif
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
        chartElement: '#unitsTree',
        multiple: true,
        ulId: "#tree"
    });


    $("#save").click(function () {

        var activeLis = [];
        $("#tree").find("li.active-node").each(function () {
            activeLis.push($(this).attr('data-id'));
        });

        var userUnits = {
            id: $(this).attr('data-user-id'),
            units: activeLis
        };

        $.ajax({
            url: '/main/users/units',
            method: 'POST',
            data: userUnits,
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            success: function (data) {
                window.location.href = "/main/users/one/" + data;
            }
        });
    })

</script>
@stop
