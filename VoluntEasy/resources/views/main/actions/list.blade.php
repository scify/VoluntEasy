@extends('default')

@section('title')
Προβολή Δράσεων
@stop
@section('pageTitle')
Προβολή Δράσεων
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Δράσεις</h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Περιγραφή</th>
                        <th>Σχόλια</th>
                        <th>Μονάδα</th>
                        <th>Ημ. Έναρξης</th>
                        <th>Ημ. Λήξης</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($actions as $action)
                    <tr>
                        <td>{{ $action->id }}</td>
                        <td><a href="{{ url('main/actions/one/'.$action->id) }}">{{ $action->description }}</a></td>
                        <td>{{ $action->comments }}</td>
                        <td>{{ $action->unit->description }}</td>
                        <td>{{ $action->start_date }}</td>
                        <td>{{ $action->end_date }}</td>
                        <td>
                            @if(in_array($action->unit->id, $userUnits))
                            <ul class="list-inline">
                                <li><a href="{{ url('main/actions/edit/'.$action->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                                </li>
                                <li><a href="{{ url('main/actions/delete/'.$action->id) }}" data-toggle="tooltip"
                                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                                </li>
                            </ul>
                            @endif
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
