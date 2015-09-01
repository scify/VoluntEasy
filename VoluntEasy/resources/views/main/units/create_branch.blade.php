@extends('default')

@section('title')
Δημιουργία Οργανωτικής Μονάδας
@stop

@section('pageTitle')
Δημιουργία Οργανωτικής Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία οργανωτικής μονάδας</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch'],
                        'id' =>
                        'createForm']) !!}
                        @include('main.units.partials._form', ['submitButtonText' => 'none', 'type' => 'branch'])

                        <div class="form-group text-right">
                            {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Επιλογή πατέρα οργανωτικής <span class="star">*</span></h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.tree._tree')
            </div>
        </div>
    </div>
</div>


@stop


@section('footerScripts')
<script>

    //initialize the tree
    var treewrapper = new Treewrapper({
        create: 'unit',
        active: {
            type: 'unit',
            id: $('#parent_unit_id').val()
        }
    });
    treewrapper.init();


    //if the user has clicked on a unit, but the submission returns errors,
    //the page gets reloaded and the active node is lost.
    //the value (unit id) stays in the hidden input so we can make it active again.
    if ($('#parent_unit_id').val() != '') {
        $(".node").addClass('active-node');
    }

    //initialize user select
    $('#userList').select2();

    //make an input to send with the form
    $('#userList').on("select2:select", function (e) {
        id = e.params.data.id;
        input = '<input id="user' + id + '" name="user' + id + '" value="' + id + '" hidden/>';
        $("#createForm").append(input);
    });

    //remove input when the option is unselected
    $('#userList').on("select2:unselect", function (e) {
        id = e.params.data.id;
        console.log("#user" + id)
        $("#user" + id).remove();
    });


    $("#parent_unit").val($("#parent_unit").attr("data-value"));


</script>
@append
