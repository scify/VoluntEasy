<div class="row">
    <div class="col-md-12">
        @if(sizeof($unit->volunteers)==0)
        Δεν υπάρχουν εθελοντές στην οργανωτική μονάδα.
        @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Όνομα</th>
                <th>Email</th>
                <th>Διεύθυνση</th>
                <th>Τηλέφωνο</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($unit->volunteers as $volunteer)
            <tr>
                <td>{{ $volunteer->id }}</td>
                <td><a href="{{ url('volunteers/one/'.$volunteer->id) }}">{{ $volunteer->name }} {{ $volunteer->last_name }}</a></td>
                <td>{{ $volunteer->email }}</td>
                <td>{{ $volunteer->address}}
                    @if($volunteer->city!=null || $volunteer->city!=""), {{ $volunteer->city }}@endif
                    @if($volunteer->country!=null || $volunteer->country!=""), {{ $volunteer->country }}@endif
                </td>
                <td>@if($volunteer->home_tel!=null || $volunteer->home_tel!="") {{ $volunteer->home_tel }}@endif
                    @if($volunteer->work_tel!=null || $volunteer->home_tel!="") {{ $volunteer->work_tel }}@endif
                    @if($volunteer->cell_tel!=null || $volunteer->home_tel!="") {{ $volunteer->cell_tel }}@endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr/>
    </div>
</div>
