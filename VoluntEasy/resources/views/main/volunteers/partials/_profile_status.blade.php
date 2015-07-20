<div class="row">
    <div class="col-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Κατάσταση Εθελοντή</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Κατάσταση</th>
                        <th>Οργανωτική Μονάδα</th>
                        <th>Ημ. Ισχύος</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($volunteer->units as $unit)
                        <td>Ενεργός</td>
                        <td>Μπλα μπλα</td>
                        <td>Λαλαλα</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Εκκρεμότητες</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Οργανωτική Μονάδα</th>
                        <th>Βήμα 1</th>
                        <th>Βήμα 2</th>
                        <th>Βήμα 3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($volunteer->units as $unit)
                        <td>{{ $unit->description }}</td>
                            @foreach($unit->steps as $step)
                                <td>
                                    <span class="{{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
                                    <a href="{{ url('volunteers/dsads/'.$volunteer->id) }}"><i class="fa fa-2x fa-edit"></i></a>
                                    <a href="{{ url('volunteers/dsds/'.$volunteer->id) }}"><i class="fa fa-2x fa-info"></i></a>
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
