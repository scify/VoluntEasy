<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Email</th>
        <th>Διεύθυνση</th>
        <th>Τηλέφωνο</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($volunteers as $volunteer)
    <tr>
        <td>{{ $volunteer->id }}</td>
        <td>
            <a href="{{ url('volunteers/one/'.$volunteer->id) }}">{{ $volunteer->name }} {{
                $volunteer->last_name }} </a></td>
        <td>{{ $volunteer->email }}</td>
        <td>{{ $volunteer->address}}
            @if($volunteer->city!=null || $volunteer->city!=""), {{ $volunteer->city }}@endif
            @if($volunteer->country!=null || $volunteer->country!=""), {{ $volunteer->country }}@endif
        </td>
        <td>{{ $volunteer->tel }}</td>
        <!--td>
            @if(sizeof($volunteer->units)>0)
            <a href="{{ url('steps/volunteer/'.$volunteer->id) }}" class="btn btn-info">Προβολή
                Βημάτων/Εκκρεμοτήτων</a>
            @endif
        </td-->
        <td>
            <ul class="list-inline">
                <li><a href="#" data-toggle="tooltip"
                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                </li>
                <li><a href="#" data-toggle="tooltip"
                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                </li>
            </ul>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

{!! $volunteers->render() !!}


