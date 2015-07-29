<div class="row">
    <div class="col-md-12">
        @if(sizeof($currentVolunteers)==0)
        Δεν υπάρχουν εθελοντές στην οργανωτική μονάδα.
        @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Όνομα</th>
                <th>Email</th>
                <th>Τηλέφωνα</th>
                <th>Διεύθυνση</th>
                <th>Κατάσταση</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($currentVolunteers as $volunteer)
            <tr>
                <td>{{ $volunteer->id }}</td>
                <td><a href="{{ url('volunteers/one/'.$volunteer->id) }}">{{ $volunteer->name }} {{
                    $volunteer->last_name }}</a>
                </td>
                <td><a href="mailto:{{ $volunteer->email }}">{{ $volunteer->email}}</a></td>
                <td>@if($volunteer->cell_tel!=null || $volunteer->cell_tel!=""){{ $volunteer->cell_tel }}@endif
                    @if($volunteer->home_tel!=null || $volunteer->city!=""), {{ $volunteer->home_tel }}@endif
                    @if($volunteer->work_tel!=null || $volunteer->country!=""), {{ $volunteer->work_tel }}@endif</td>
                <td>
                    {{ $volunteer->address}}
                    @if($volunteer->city!=null || $volunteer->city!=""), {{ $volunteer->city }}@endif
                    @if($volunteer->country!=null || $volunteer->country!=""), {{ $volunteer->country }}@endif
                </td>
                <td>
                    @if($volunteer->units[0]->status=='Pending')
                    <span class="status pending">Υπό ένταξη</span>
                    @elseif($volunteer->units[0]->status=='Available')
                    <span class="status available">Διαθέσιμος</span>
                    @elseif($volunteer->units[0]->status=='Active')
                    <span class="status active">Ενεργός</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr/>
    </div>
</div>
