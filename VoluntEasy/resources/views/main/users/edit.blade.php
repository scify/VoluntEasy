@extends('default')

@section('title')
Επεξεργασία Χρήστη
@stop

@section('pageTitle')
Επεξεργασία Χρήστη
@stop

@section('bodyContent')

    {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
    => $user->id], 'files' => true]) !!}
    @include('main.users.partials._form', ['user' =>
    $user])
    @include('main.users.partials._roles', ['submitButtonText' => 'Αποθήκευση'])
    {!! Form::close() !!}


{{--
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row m-b-lg">
                    <div class="col-md-12 ">

                        <h3>Επιλογή Οργανωτικών Μονάδων</h3>

                        <p>Επιλέξτε τις οργανωτικές μονάδες στις οποίες μπορεί να έχει πρόσβαση ο χρήστης.</p>

                        @include('main.tree._tree')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-success" id="save" data-user-id="{{$user->id}}">
                            Αποθήκευση
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
--}}

@stop


@section('footerScripts')

<script>
    //initialize the tree
    var treewrapper = new Treewrapper({
        url: $("body").attr('data-url') + '/api/tree/activeUnits/' + $("#save").attr('data-user-id'),
        multiple: true,
        children: true,
        withActions: false,
        edit: 'user'
    });
    treewrapper.init();

    $("#save").click(function () {
        var activeNodes = [];

        $("#unitsTree").find(".node.assignTo").each(function () {
            activeNodes.push($(this).attr('data-id'));
        });
        var userUnits = {
            id: $(this).attr('data-user-id'),
            units: activeNodes
        };
        console.log(activeNodes);

        $.ajax({
            url: $("body").attr('data-url') + '/users/units',
            method: 'POST',
            data: userUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/users/one/" + data;
            }
        });
    })
</script>
@append
