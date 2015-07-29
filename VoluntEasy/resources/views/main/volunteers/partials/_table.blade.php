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
        <td>{{ $volunteer->cell_tel }}</td>
        <td>
            @if($volunteer->blacklisted)
            <div class="status blacklisted">Μη διαθέσιμος</div>
            @else
            @if($root && sizeof($volunteer->units)==0)
                    <a href="{{ url('volunteers/addToRootUnit/'.$volunteer->id) }}" class="btn btn-info">Ένταξη στη Μονάδα μου</a>
            @elseif(!$root && sizeof($volunteer->units)==0)
            <p>-</p>
            @else
               @foreach($volunteer->units as $i => $unit)
                    @if($unit->status=='Pending')
                    <div class="status pending" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι υπό ανάθεση στη μονάδα {{ $unit->description }}">{{ $unit->description }}</div>
                    @elseif($unit->status=='Available')
                    <div class="status available" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι διαθέσιμος στη μονάδα {{ $unit->description }}">{{ $unit->description }}</div>
                    @elseif($unit->status=='Active')
                    <div class="status active" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι ενεργός σε δράσεις στη μονάδα {{ $unit->description }}">{{ $unit->description }}</div>
                    @else
                    @endif
               @endforeach
           @endif
           @endif
        </td>
        <td>
            @if(in_array($volunteer->id, $permittedVolunteers))
            <ul class="list-inline">
                <li><a href="{{url('volunteers/edit/'.$volunteer->id)}}" data-toggle="tooltip"
                       data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a>
                </li>
                <li><a href="#" class="delete" data-id="{{ $volunteer->id }}" data-toggle="tooltip"
                       data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>
                </li>
            </ul>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

