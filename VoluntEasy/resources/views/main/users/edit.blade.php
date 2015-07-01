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
                        <div class="col-md-12">
                            <h2>Επιλογή Οργανωτικών Μονάδων</h2>
                            @if($tree!=null)
                            <div id="unitsTree"></div>
                            <ul id="tree" style="display:none;">
                                <li data-id="{{$tree->id}}"><span class="description">{{$tree->description}}</span>
                                    <ul>
                                        @include('main.units.partials._branch_actives', ['unit' => $tree, 'active' =>
                                        $active])
                                    </ul>
                                </li>
                            </ul>
                            @else
                            <h3>Δεν υπάρχουν οργανωτικές μονάδες.</h3>
                            @endif
                        </div>
                        <button type="button" class="btn btn-success" id="save" data-user-id="{{$user->id}}">
                            Αποθήκευση
                        </button>
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
            url: '/users/units',
            method: 'POST',
            data: userUnits,
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            success: function (data) {
                window.location.href = "/users/one/" + data;
            }
        });
    })

</script>
@stop
