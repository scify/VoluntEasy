<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Email</th>
        <th>Διεύθυνση</th>
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td><a href="{{ url('users/one/'.$user->id) }}">{{ $user->name }}</a></td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->addr }}</td>
        <td>{{ $user->tel }}</td>
        <td>
            @foreach($user->units as $i => $unit)
            @if($i==0)
            <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
            @else
            , <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
            @endif
            @endforeach
        </td>
        <td>
            @if(in_array($user->id, $permittedUsers))
            <ul class="list-inline">
                <li><a href="{{ url('users/edit/'.$user->id) }}" data-toggle="tooltip"
                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                </li>
                <li><a href="{{ url('users/delete/'.$user->id) }}" data-toggle="tooltip"
                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                </li>
            </ul>
            @endif
    </tr>
    @endforeach
    </tbody>
</table>
