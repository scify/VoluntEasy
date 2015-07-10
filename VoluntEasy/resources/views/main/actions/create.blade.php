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
                <h4>Επιλέξτε σε ποια οργανωτική μονάδα ανήκει η δράση:</h4>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}" class="root disabled"><span
                            class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.tree._branch_actions', ['unit' => $tree, 'userUnits' => $userUnits])
                        </ul>
                    </li>
                </ul>
                <div id="unitsTree"></div>
                @include('main.tree._legend')
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

    //datepickers for the edit form
    $('#actionStartDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('#actionEndDate').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('#actionEndDate').datepicker('setStartDate', null);
    });

    //add restrictions: user should not be able to check
    // an end_date after start_date and vice-versa
    $('#actionEndDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('#actionStartDate').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('#actionStartDate').datepicker('setEndDate', null);
    });


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
