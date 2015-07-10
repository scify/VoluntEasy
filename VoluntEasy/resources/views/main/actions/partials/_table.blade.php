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
        <td><a href="{{ url('actions/one/'.$action->id) }}">{{ $action->description }}</a></td>
        <td>{{ $action->comments }}</td>
        <td>{{ $action->unit->description }}</td>
        <td>{{ $action->start_date }}</td>
        <td>{{ $action->end_date }}</td>
        <td>
            @if(in_array($action->unit->id, $userUnits))
            <ul class="list-inline">
                <li><a href="{{ url('actions/edit/'.$action->id) }}" data-toggle="tooltip"
                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                </li>
                <li><a href="{{ url('actions/delete/'.$action->id) }}" data-toggle="tooltip"
                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                </li>
            </ul>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
{!! $actions->render() !!}
