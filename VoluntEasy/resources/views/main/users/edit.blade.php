@extends('default')

@section('title')
{{ trans('entities/users.edit') }}
@stop

@section('pageTitle')
{{ trans('entities/users.edit') }}
@stop

@section('bodyContent')

    {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
    => $user->id], 'files' => true]) !!}
    @include('main.users.partials._form', ['user' =>
    $user])
    @include('main.users.partials._roles', ['submitButtonText' => trans('default.save') ])
    {!! Form::close() !!}

@stop


@section('footerScripts')

<script>

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
