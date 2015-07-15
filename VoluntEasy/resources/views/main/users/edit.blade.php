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

                        @if($tree!=null)
                        @include('main.tree._tree', ['unit' => $tree, 'actives' => $actives])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-success" id="save" data-user-id="{{$user->id}}">
                            Αποθήκευση
                        </button>
                    </div>
                </div>
                @else
                <h3>Δεν υπάρχουν οργανωτικές μονάδες.</h3>
                @endif
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
        ulId: "#tree",
        children: true
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

        console.log(activeLis);

        $.ajax({
            url: $("body").attr('data-url') + '/users/units',
            method: 'POST',
            data: userUnits,
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/users/one/" + data;
            }
        });
    })

</script>
@stop
