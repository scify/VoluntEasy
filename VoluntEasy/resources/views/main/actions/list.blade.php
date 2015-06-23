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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($units as $unit)
                    <tr>
                        <td>{{ $unit->id }}</td>
                        <td><a href="{{ url('main/units/one/'.$unit->id) }}">{{ $unit->description }}</a></td>
                        <td>{{ $unit->comments }}</td>
                        <td>
                            <ul class="list-inline">
                                <li><a href="{{ url('main/units/create/'.$unit->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Προσθήκη Κλαδιού" class=""><i
                                        class="fa fa-plus fa-2x"></i></a></li>
                                <li><a href="{{ url('main/units/edit/'.$unit->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                                </li>
                                <li><a href="{{ url('main/units/delete/'.$unit->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                                </li>
                            </ul>
                        </td>
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
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@stop