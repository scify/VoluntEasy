@extends('default')

@section('title')
    Προβολή Μονάδων
@stop
@section('pageTitle')
    Προβολή Μονάδων
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Μονάδες</h4>
           </div>
           <div class="panel-body">
              <table class="table table-striped">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>Περιγραφή</th>
                       <th>Σχόλια</th>
                       <th>Ημ. Έναρξης</th>
                       <th>Ημ. Λήξης</th>
                       <th>Level</th>
                       <th>Paren Id</th>
                       <th></th>
                    </tr>
                 </thead>
                 <tbody>
                 @foreach ($units as $unit)
                     <tr>
                        <td>{{ $unit->id }}</td>
                        <td><a href="{{ url('main/units/one/'.$unit->id) }}">{{ $unit->description }}</a></td>
                        <td>{{ $unit->comments }}</td>
                        <td>{{ $unit->start_date }}</td>
                        <td>{{ $unit->end_date }}</td>
                        <td>{{ $unit->level }}</td>
                        <td>{{ $unit->parent_unit_id }} {{ $unit->parent->description }}</td>
                        <td><a href="{{ url('main/units/delete/'.$unit->id) }}"><i class="fa fa-trash"></i></a></td>
                     </tr>
                 @endforeach
                 </tbody>
              </table>
           </div>
        </div>
    </div>
</div>



<div class="row">

    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Tree</h4>
           </div>
           <div class="panel-body">

            <div id="unitsTree"></div>

            <p></p>
            <ul id="tree" ></ul>

           </div>
           </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Tree</h4>
           </div>
           <div class="panel-body">
           <div id="testTree"></div>
               <ul id="org" style="display:none">
               <li>
                 Food
                 <ul>
                   <li>Beer</li>
                   <li>Vegetables
                     <ul>
                       <li>Pumpkin</li>
                       <li><a href="http://tquila.com" target="_blank">Aubergine</a></li>
                     </ul>
                   </li>
                   <li>Bread</li>
                   <li>Chocolate
                     <ul>
                       <li>Topdeck</li>
                       <li>Reese's Cups</li>
                     </ul>
                   </li>
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

var html='';
//add spinner while it loads
    $.ajax({
       url: '/main/units/all',
       success: function(data) {
            var ul = '<ul id="org" style="display:none">';
            getLi(data);

console.log(html);
             $("#tree").append(html);

            $("#tree").jOrgChart({
                    chartElement: '#unitsTree'
                });
       }
    });


    $("#org").jOrgChart({
        chartElement: '#testTree'
    });

/*
function getLi(unit){
    html = '<ul><li>';
    html_+= unit.description;
    html += '</li></ul>';
}
*/
function getLi(units) {
    for (var i in units) {
        if (units[i].hasOwnProperty('children') && units[i].children !== null && units[i].children.length>0) {
            html += '<li>'+units[i].id+units[i].description+'<ul data-id="'+units[i].id+'">';

            getLi(units[i].children);

            html += '</ul></li>';

        } else if (!units[i].hasOwnProperty('children')) {

            html += '<li data-id="'+units[i].id+'">';
            html += units[i].id+units[i].description;
            html += '</li>';
        }
    }
}
</script>
@stop