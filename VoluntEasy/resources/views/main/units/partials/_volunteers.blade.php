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
                <th>Βήμα 1</th>
                <th>Βήμα 2</th>
                <th>Βήμα 3</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($currentVolunteers as $volunteer)
            <tr>
                <td>{{ $volunteer->id }}</td>
                <td><a href="{{ url('volunteers/one/'.$volunteer->id) }}">{{ $volunteer->name }} {{
                    $volunteer->last_name }}</a> <br/>
                    <small><i class="fa fa-envelope"></i> <a href="mailto:{{ $volunteer->email }}">{{ $volunteer->email
                        }}</a> |
                        <i class="fa fa-home"></i> {{ $volunteer->cell_tel }} |
                        <i class="fa fa-phone"></i> {{ $volunteer->cell_tel }}
                    </small>
                </td>

                @foreach($volunteer->units[0]->steps as $i => $step)
                <td>
                    @if($step->type=='Assignment')
                    @if(sizeof($unit->actions)>0)
                    <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση σε δράση/μονάδα</span>
                    @else
                    <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση σε μονάδα</span>
                    @endif
                    @else
                    <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
                    @endif
                </td>
                @endforeach

            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr/>
    </div>
</div>
