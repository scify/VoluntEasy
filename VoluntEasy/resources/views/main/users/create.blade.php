@extends('default')

@section('title')
Προσθήκη Χρήστη
@stop

@section('pageTitle')
Προσθήκη Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UserController@store']]) !!}
                @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!--div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <h4>Επιλέξτε τις οργανωτικές στις οποίες είναι υπεύθυνος ο χρήστης:</h4>
                @include('main.tree._tree', ['tooltips' => 'true'])
            </div>
        </div>
    </div-->
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
/*
    $(".node").click(function () {
        if (!$(this).hasClass("disabled")) {
            if ($(this).hasClass("active-node")) {
                $("#unitDescriptions").append("<li id='unit-" + $(this).attr("data-id") + "'>" + $(this).find(".description").text() + "</li>");
            }
            else {
                $("#unit-" + $(this).attr("data-id")).remove();
            }
        }
    })
*/
</script>
@stop
