@extends('default')

@section('title')
    Προβολή Μονάδας
@stop

@section('pageTitle')
    {{$unit->description}}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">

                {!! Form::model($unit, ['method' => 'POST', 'action' => ['UnitController@update', 'id' => $unit->id]]) !!}
                    @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'unit' => $unit])
                {!! Form::close() !!}
           </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Tree</h4>
           </div>
           <div class="panel-body">

            <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li>{{$unit->description}}
                        <ul>
                             @include('main.units.partials._branch', array('$unit->allChildren' => $unit))
                       </ul>
                   </li>
                </ul>
           </div>
        </div>
    </div>
</div>

@stop


@section('footerScripts')
<script>
   $("#tree").jOrgChart({
           chartElement: '#unitsTree'
   });


    //datepickers for the edit form
     $('#start_date').datepicker({
         language: 'el',
         format: 'dd/mm/yyyy',
         autoclose: true
     }).on('changeDate', function (selected) {
           var startDate = new Date(selected.date.valueOf());
           $('#end_date').datepicker('setStartDate', startDate);
       }).on('clearDate', function (selected) {
           $('#end_date').datepicker('setStartDate', null);
       });

     $('#end_date').datepicker({
         language: 'el',
         format: 'dd/mm/yyyy',
         autoclose: true
     }).on('changeDate', function (selected) {
           var endDate = new Date(selected.date.valueOf());
           $('#start_date').datepicker('setEndDate', endDate);
       }).on('clearDate', function (selected) {
           $('#start_date').datepicker('setEndDate', null);
       });
 </script>
@stop