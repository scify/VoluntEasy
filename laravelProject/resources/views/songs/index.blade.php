@extends('master')

@section('bodyContent')
    <h1>List of the songs</h1>
    @foreach($songs as $index => $song)
        <li><a href="/songs/{{$index}}"> {{$song}} </a></li>
    @endforeach
@stop