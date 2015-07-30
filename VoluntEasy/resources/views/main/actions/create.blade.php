@extends('default')

@section('title')
Δημιουργία Δράσης
@stop

@section('pageTitle')
Δημιουργία Δράσης
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία δράσης</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::open(['method' => 'POST', 'action' => ['ActionController@store']]) !!}
                        @include('main.actions.partials._form', ['submitButtonText' => 'Αποθήκευση'])
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
                <h4 class="panel-title">Επιλογή πατέρα δράσης <span class="star">*</span></h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.tree._tree', ['tooltips' => 'true', 'creating' => 'action'])
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
    if($('#unit_id').val()!=''){
        $("#tree li[data-id='"+$('#unit_id').val()+"'").addClass('active-node');
    }


    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        chartClass: "jOrgChart"
    });


    $(".node.leaf").click(function () {
        if (!$(this).hasClass("disabled")) {
            $("#unit_id").val($(this).attr("data-id"));
        }
    })



</script>
@stop
