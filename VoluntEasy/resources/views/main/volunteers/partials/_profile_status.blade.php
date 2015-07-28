@if(sizeof($volunteer->units)==0)
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-body">
                <h3>Ο εθελοντής δεν ανήκει σε καμία οργανωτική μονάδα ή δράση.</h3>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Κατάσταση Εθελοντή</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Οργανωτική Μονάδα</th>
                        <th>Κατάσταση</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($volunteer->units as $unit)
                    <tr>
                        <td>{{ $unit->description }}</td>
                        <td>
                            @if($unit->status=='Pending')
                            <span class="status pending">Υπό ένταξη</span>
                            @elseif($unit->status=='Available')
                            <span class="status available">Διαθέσιμος</span>
                            @elseif($unit->status=='Active')
                            <span class="status active">Ενεργός</span>
                            @else
                            @endif
                        </td>
                        <td>
                            @if($unit->status=='Active')
                            @foreach($volunteer->actions as $action)
                            @if($action->unit_id==$unit->id)
                            <div class="row">
                                <div class="col-md-5">
                                    <p>Δράση <strong><a href="{{ url('actions/one/'.$action->id) }}">{{
                                        $action->description
                                        }}</a></strong><br/>
                                        <small>{{ $action->start_date }} - {{ $action->end_date }}</small>
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    @if($permitted==1)
                                    <a href="{{url('/volunteers/'.$volunteer->id.'/action/detach/'.$action->id)}}"
                                       data-toggle="tooltip"
                                       data-placement="bottom" title="Αφαίρεση από τη δράση"><i
                                            class="fa fa-remove fa-2x"></i></a>
                                    @endif
                                </div>
                            </div>

                            @endif
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
