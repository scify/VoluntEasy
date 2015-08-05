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
                        <th>Δράσεις</th>
                        <th class="text-center">Αφαίρεση από μονάδα</th>
                        <th class="text-center">Ανάθεση σε δράση</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($volunteer->units as $unit)
                    <tr>
                        <td>{{ $unit->description }}</td>
                        <td>
                            @if($unit->status=='Pending')
                            <div class="status pending">Υπό ένταξη</div>
                            @elseif($unit->status=='Available')
                            <div class="status available">Διαθέσιμος</div>
                            @elseif($unit->status=='Active')
                            <div class="status active">Ενεργός</div>
                            @else
                            @endif
                        </td>
                        <td>
                            @if($unit->status=='Active')
                            @foreach($volunteer->actions as $action)
                            @if($action->unit_id==$unit->id)
                            <p>Δράση <strong><a href="{{ url('actions/one/'.$action->id) }}">{{
                                $action->description
                                }}</a></strong>
                                <small>({{ $action->start_date }} - {{ $action->end_date }})</small>
                                <br/>
                                <small><a href="{{url('/volunteers/'.$volunteer->id.'/action/detach/'.$action->id)}}"><i
                                        class="fa fa-remove fa-1x"></i> Αφαίρεση από τη δράση</a></small>
                            </p>
                            @endif
                            @endforeach
                            @else
                            <p style="color:#aaa;"><em>Η μονάδα δεν έχει δράσεις</em></p>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($volunteer->permitted)
                            <a href="{{url('/volunteers/'.$volunteer->id.'/unit/detach/'.$unit->id)}}" class="btn btn-danger btn-sm"><i
                                    class="fa fa-remove fa-1x"></i></a>
                            @endif


                        </td>
                        <td class="text-center">
                            @if(sizeof($unit->actions)>0 && $volunteer->permitted)
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#selectAction">
                                <i class="fa fa-bookmark"></i>
                            </button>
                            @include('main.volunteers.partials._actions_modal')
                            @endif</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
