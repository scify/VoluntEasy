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
                <h4 class="panel-title">Αναζήτηση</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@search']]) !!}
                @include('main.units.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($units as $unit)
                    <tr>
                        <td>{{ $unit->id }}</td>
                        <td><a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a><br/>
                            @if($unit->parent!=null)
                            <small>Ανήκει σε {{ $unit->parent->description }}</small>
                            @endif
                        </td>
                        <td>{{ $unit->comments }}</td>
                        <td>
                            @if(in_array($unit->id, $userUnits))
                            <ul class="list-inline">
                                <li><a href="{{ url('units/edit/'.$unit->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                                </li>
                                <li><a href="{{ url('units/delete/'.$unit->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                                </li>
                            </ul>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $units->render() !!}
            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@stop
