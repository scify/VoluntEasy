@extends('default')

@section('title')
Προσθήκη Χρήστη
@stop

@section('pageTitle')
Προσθήκη Χρήστη
@stop

@section('bodyContent')


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία χρήστη</h4>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::open(['method' => 'POST', 'action' => ['UserController@store'], 'files'=>true]) !!}
                        @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση'])
                        {!! Form::close() !!}
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
