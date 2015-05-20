@extends('master')
@section('cssStyle')
    <link rel="stylesheet" type="text/css" href="/css/styler.css">
@stop

@section('bodyContent')

    <h2> {{$name}} </h2>
    @foreach($lessons as $lesson)
        <h3> {{$lesson}}</h3>
    @endforeach
@stop