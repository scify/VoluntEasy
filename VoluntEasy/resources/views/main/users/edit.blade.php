@extends('default')

@section('title')
Επεξεργασία Χρήστη
@stop

@section('pageTitle')
Επεξεργασία Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
                => $user->id]]) !!}
                @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση', 'user' =>
                $user])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


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

@stop


@section('footerScripts')
<!--script src="{{ asset('assets/js/pages/users/edit.js')}}"></script>
<script>
    var handler = new window.scify.editHandler("pink");
    handler.init();
</script-->


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
        var activeLis = [];

        $("#unitsTree").find(".node.assignTo").each(function () {
            activeLis.push($(this).attr('data-id'));
        });
        var userUnits = {
            id: $(this).attr('data-user-id'),
            units: activeLis
        };
        console.log(activeLis);

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
