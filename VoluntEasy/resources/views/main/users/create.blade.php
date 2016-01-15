@extends('default')

@section('title')
Προσθήκη Χρήστη
@stop

@section('pageTitle')
Προσθήκη Χρήστη
@stop

@section('bodyContent')


<div class="row">
    {!! Form::open(['method' => 'POST', 'action' => ['UserController@store'], 'files'=>true]) !!}
    @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση'])
    {!! Form::close() !!}
</div>


@stop


@section('footerScripts')
<script>

    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        multiple: true,
        ulId: "#tree",
        children: true
    });


</script>
@append
