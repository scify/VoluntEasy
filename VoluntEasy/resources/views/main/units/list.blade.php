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

@stop


@section('footerScripts')
<script>

var html='';
//add spinner while it loads
    $.ajax({
       url: '/main/units/all',
       success: function(data) {
            var ul = '<ul id="org" style="display:none">';

            html +='<li>' + data.id + ' ' + data.description + '<ul>';

            getLi(data.all_children);

             html +='</ul></li>';

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


function getLi(units) {

    for (var i in units) {
    console.log(units[i]);
        if (units[i].hasOwnProperty('all_children') && units[i].all_children !== null && units[i].all_children.length>0) {
            html += '<li>'+units[i].id+units[i].description+'<ul data-id="'+units[i].id+'">';

            getLi(units[i].all_children);

            html += '</ul></li>';

        } else if (units[i].all_children.length==0) {

            html += '<li data-id="'+units[i].id+'">';
            html += units[i].id+units[i].description;
            html += '</li>';
        }
    }
}
</script>
@stop