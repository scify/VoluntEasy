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
                <h4 class="panel-title">Αναζήτηση</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['VolunteerController@search'], 'class' => 'form-inline']) !!}
                @include('main.volunteers.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

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
                       <th></th>
                    </tr>
                 </thead>
                 <tbody>
                 @foreach ($volunteers as $volunteer)
                     <tr>
                        <td>{{ $volunteer->id }}</td>
                        <td>
                            <a href="{{ url('volunteers/one/'.$volunteer->id) }}">{{ $volunteer->name }} {{ $volunteer->last_name }} </a></td>
                        <td>{{ $volunteer->email }}</td>
                        <td>{{ $volunteer->address}}</td>
                        <td>{{ $volunteer->tel }}</td>
                        <td>
                            @if(sizeof($volunteer->units)>0)
                            <a href="{{ url('steps/volunteer/'.$volunteer->id) }}" class="btn btn-info">Προβολή Βημάτων/Εκκρεμοτήτων</a>
                            @endif
                        </td>
                         <td><ul class="list-inline">
                             <li><a href="#" data-toggle="tooltip"
                                    data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                             </li>
                             <li><a href="#" data-toggle="tooltip"
                                    data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                             </li>
                         </ul></td>
                     </tr>
                 @endforeach
                 </tbody>
              </table>
              {!! $volunteers->render() !!}
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
                url: $("body").attr('data-url') + '/users/delete/'+$(this).attr('data-id'),
                method: 'POST',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/users";
                }
            });
        }
    });
</script>
@stop
