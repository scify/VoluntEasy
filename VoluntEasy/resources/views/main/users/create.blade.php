@extends('default')

@section('title')
Προσθήκη Χρήστη
@stop

@section('pageTitle')
Προσθήκη Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">

                {!! Form::open(['method' => 'POST', 'action' => ['UserController@store']]) !!}
                @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}"><span class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.tree._branch', ['unit' => $tree])
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
    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        multiple: true,
        ulId: "#tree",
        children: true
    });


</script>
@stop
