@extends('default')

@section('title')
    Προβολή Εθελοντών
@stop
@section('pageTitle')
    Προβολή Εθελοντών
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
           <div class="panel-heading clearfix">
              <h4 class="panel-title">Εθελοντές</h4>
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
                       <th></th>
                    </tr>
                 </thead>
                 <tbody>
                 @foreach ($volunteers as $volunteer)
                     <tr>
                        <td>{{ $volunteer->id }}</td>
                        <td><a href="{{ url('main/users/one/'.$volunteer->id) }}">{{ $volunteer->name }} {{ $volunteer->last_name }} </a></td>
                        <td>{{ $volunteer->email }}</td>
                        <td>{{ $volunteer->address}}</td>
                        <td>{{ $volunteer->tel }}</td>
                        <td><a href="{{ url('main/steps/one/'.$volunteer->id) }}" class="btn btn-info">Προβολή Βημάτων</a></td>
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
    $(".delete").click(function(){
        if (confirm("Delete user?") == true) {
            $.ajax({
                url: '/main/users/delete/'+$(this).attr('data-id'),
                method: 'POST',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function (data) {
                    window.location.href = "/main/users";
                }
            });
        }
    });
</script>
@stop
