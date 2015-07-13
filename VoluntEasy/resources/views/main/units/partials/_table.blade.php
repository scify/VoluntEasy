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

