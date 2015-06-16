@extends('default')

@section('title')
    Επεξεργασία Χρήστη
@stop

@section('pageTitle')
    Επεξεργασία Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
           <div class="panel-body">

                {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id' => $user->id]]) !!}
                    @include('main.users._form', ['submitButtonText' => 'Αποθήκευση', 'user' => $user])
                {!! Form::close() !!}
           </div>
        </div>
    </div>
</div>

@stop



@section('footerScripts')
<script>
    $(".unit").click(function(event){
        event.preventDefault();


        $("#unit-"+$(this).attr('data-id')).jOrgChart({
            chartElement: '#unitsTree'
        });

    })


</script>
@stop