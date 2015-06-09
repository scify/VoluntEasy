@extends('default')

@section('title')
    Προβολή λίστας-Αναζήτηση
@stop
@section('pageTitle')
    Προβολή λίστας-Αναζήτηση
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Χρήστες</h4>
           </div>
           <div class="panel-body">
              <table class="table table-striped">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>Όνομα</th>
                       <th>Email</th>
                       <th>Διεύθυνση</th>
                       <th>Τηλέφωνο</th>
                       <th>Level</th>
                    </tr>
                 </thead>
                 <tbody>
                 @foreach ($users as $user)
                     <tr>
                        <td>{{ $user->id }}</td>
                        <td><a href="{{ url('main/users/'.$user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->addr }}</td>
                        <td>{{ $user->tel }}</td>
                        <td>{{ $user->level }}</td>
                     </tr>
                 @endforeach
                 </tbody>
              </table>
           </div>
        </div>
    </div>
</div>










@stop