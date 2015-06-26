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
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($unit->volunteers as $volunteer)
            <tr>
                <td>{{ $volunteer->id }}</td>
                <td><a href="{{ url('main/units/one/'.$volunteer->id) }}">{{ $volunteer->name.' '.$volunteer->last_name}}</a></td>
                <td>{{ $volunteer->comments }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr/>
    </div>
</div>
