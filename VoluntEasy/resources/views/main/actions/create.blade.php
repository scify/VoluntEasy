@extends('default')

@section('title')
Προσθήκη Δράσης
@stop

@section('pageTitle')
Προσθήκη Δράσης
@stop

@section('bodyContent')

<div class="row">
    @if($tree!=null)
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <h4>Επιλέξτε σε ποια οργανωτική μονάδα ανήκει η δράση: <span class="star"></span></h4>
                @include('main.tree._tree', ['tooltips' => 'true'])
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">

                {!! Form::open(['method' => 'POST', 'action' => ['ActionController@store']]) !!}
                @include('main.actions.partials._form', ['submitButtonText' => 'Αποθήκευση'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <h3>Παρακαλώ δημιουργήστε πρώτα οργανωτική μονάδα.</h3>
            </div>
        </div>
    </div>
    @endif
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
