@extends('default')

@section('title')
{{ trans('entities/units.edit') }}
@stop

@section('pageTitle')
{{ trans('entities/units.edit') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/units.info') }}</h4>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::model($active, ['method' => 'POST', 'action' => ['UnitController@update', 'id'
                => $active->id,
                'type' => $type]]) !!}
                @include('main.units.partials._form', ['submitButtonText' => trans('default.save'), 'unit' => $active])
                <div class="form-group text-right">
                    {!! Form::submit( trans('default.save'), ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
                {!! Form::hidden('unit_id', $active->id, ['id' => 'unit_id']) !!}
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/units.selectParent') }} <span class="star">*</span></h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.tree._showTree')
            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>
    //initialize the tree
    var treewrapper = new Treewrapper({
        active: {
            type: 'unit',
            id: $("#unit_id").val()
        },
        disabled: true
    });
    treewrapper.init();

    //initialize user select
    $('#userList').select2();

    // get the array of users selected and save them
    $("#saveUsers").click(function () {
        //array of users
        var users = [];
        $('#userList :selected').each(function (i, selected) {
            users[i] = $(selected).val();
        });

        var userUnits = {
            id: $("#saveUsers").attr('data-id'),
            users: users
        };

        $.ajax({
            url: $("body").attr('data-url') + '/units/users',
            method: 'POST',
            data: userUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/units/one/" + data;
            }
        });
    });


    //save an action
    $("#saveAction").click(function () {
        var action = {
            description: $("#actionDescription").val(),
            comments: $("#actionComments").val(),
            email: $("#actionEmail").val(),
            start_date: $("#actionStartDate").val(),
            end_date: $("#actionEndDate").val(),
            unit_id: $("#saveUsers").attr('data-id')
        };

        $.ajax({
            url: $("body").attr('data-url') + "/actions/store",
            data: action,
            type: "POST",
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        }).done(function (data) {
            console.log(data)
            window.location.href = $("body").attr('data-url') + "/units/one/" + data;
        }).fail(function (jqXHR) {

            if (jqXHR.status == 422) {
                $("p.help-block").remove();
                $("#actionDescription").parent().removeClass("has-error");
                $("#actionComments").parent().removeClass("has-error");
                $("#actionStartDate").parent().removeClass("has-error");
                $("#actionEndDate").parent().removeClass("has-error");

                $.each(jqXHR.responseJSON, function (key, value) {
                    if (key == 'description') {
                        $("#actionDescription").parent().addClass("has-error");
                        $("#actionDescription").parent().append('<p class="help-block">' + value + '</p>');
                    }
                    if (key == 'comments') {
                        $("#actionComments").parent().addClass("has-error");
                        $("#actionComments").parent().append('<p class="help-block">' + value + '</p>');
                    }
                    if (key == 'start_date') {
                        $("#actionStartDate").parent().addClass("has-error");
                        $("#actionStartDate").parent().append('<p class="help-block">' + value + '</p>');
                    }
                    if (key == 'end_date') {
                        $("#actionEndDate").parent().addClass("has-error");
                        $("#actionEndDate").parent().append('<p class="help-block">' + value + '</p>');
                    }
                });
            }
        });
    });




    /*
     $(".node").click(function () {
     $.ajax({
     url: '/units/one/' + $(this).attr('data-id'),
     success: function (data) {
     console.log(data);
     $(".unit-details").html(data);
     }
     });
     })*/
</script>
@append
