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
                        <td>{{ $unit->parent_unit_id }} </td>
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