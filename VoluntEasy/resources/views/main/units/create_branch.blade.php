@extends('default')

@section('title')
Δημιουργία Κλαδιού Μονάδας
@stop

@section('pageTitle')
Δημιουργία Κλαδιού Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <h4>Επιλέξτε τον πατέρα της οργανωτικής:</h4>
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}"
                        class="{{ in_array($tree->id, $userUnits) ? '' : 'disabled' }}"><span
                            class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.tree._branch', ['unit' => $tree, 'userUnits' =>
                            $userUnits])
                        </ul>
                    </li>
                </ul>
                @include('main.tree._legend')
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch'], 'id' => 'createForm']) !!}
                @include('main.units.partials._form', ['submitButtonText' => 'none', 'type' => 'branch'])

                <label>Επιλογή Υπευθύνου/ων:</label>
                @include('main.units.partials._users', ['userIds' => [], 'users' => $users])

                <div class="form-group text-right">
                    {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>

    //if the user has clicked on a unit, but the submission returns errors,
    //the page gets reloaded and the active node is lost.
    //the value (unit id) stays in the hidden input so we can make it active again.
    if ($('#parent_unit_id').val() != '') {
        $("#tree li[data-id='" + $('#parent_unit_id').val() + "'").addClass('active-node');
    }

    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        chartClass: "jOrgChart actions",
        actions: true
    });


    //initialize user select
    $('#userList').select2();

    //make an input to send with the form
    $('#userList').on("select2:select", function (e) {
        id = e.params.data.id;
        input = '<input id="user'+id+'" name="user'+id+'" value="'+id+'" hidden/>';
        $("#createForm").append(input);
    });
    //remove input when the option is unselected
    $('#userList').on("select2:unselect", function (e) {
        id = e.params.data.id;
        console.log("#user"+id)
        $("#user"+id).remove();
    });


    $("#parent_unit").val($("#parent_unit").attr("data-value"));

    $(".node").click(function () {
        if (!$(this).hasClass("disabled")) {
            $("#parent_unit").val($(this).find(".description").text());
            $("#parent_unit_id").val($(this).attr("data-id"));
        }
    })
</script>
@stop
