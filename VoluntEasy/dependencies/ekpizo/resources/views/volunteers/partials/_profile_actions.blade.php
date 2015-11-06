<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Συμμετοχή σε δράσεις</h3>
            </div>
            <div class="panel-body">
                @if($actionsCount==0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default smallHeading">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Ο εθελοντής δεν έχει πάρει μέρος σε καμία δράση.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Δράση</th>
                        <th>Υπεύθυνος</th>
                        <th>Διάρκεια</th>
                        <th>'Ωρες απασχόλησης</th>
                        <th>Αξιολόγηση</th>
                        <th>Σχόλια</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($actionsRatings as $action)
                    <tr>
                        <td class="col-md-2"><a href="{{ url('actions/one/'.$action->id) }}">{{ $action->description }}</a>
                        </td>
                        <td class="col-md-3">
                            @if($action->name!=null && $action->name!='')
                            {{ $action->name }} <br/>
                            @endif
                            @if($action->email!=null && $action->email!='') <i
                                class="fa fa-envelope"></i> <a href="mailto:{{ $action->email }}">{{$action->email }}</a>
                            @endif
                            @if($action->phone_number!=null && $action->phone_number!='')
                            <i class="fa fa-phone"></i> {{ $action->phone_number }}
                            @endif
                        </td>
                        <td class="col-md-2">
                            {{ $action->start_date }} - {{ $action->end_date }}
                        </td>
                        <td class="col-md-2">
                            @if(sizeof($action->ratings)>0 && isset($action->ratingHours) && isset($action->ratingMinutes))
                            {{ $action->ratingHours<10 ? '0'.$action->ratingHours : $action->ratingHours }}:{{ $action->ratingMinutes<10 ? '0'.$action->ratingMinutes : $action->ratingMinutes }}
                            @else
                            <p style="color:#aaa;"><em>Δεν έχουν σημειωθεί ώρες απασχόλησης</em></p>
                            @endif
                        </td>
                        <td class="col-md-5">
                            @if(sizeof($action->ratings)>0)
                            @foreach($action->ratings as $i => $rating)
                            <span class="attribute rating" data-score="{{ $rating['rating']/$action->ratingCount}}"></span>
                            <small><span> {{ $i }} </span></small>
                            <br/>
                            @endforeach
                            @else
                            <p style="color:#aaa;"><em>Δεν έχει γίνει αξιολόγηση</em></p>
                            @endif
                        </td>
                        <td class="col-md-2">
                            @if(sizeof($action->ratings)>0 && isset($action->ratingComments) && $action->ratingComments!='')
                            {{ $action->ratingComments }}
                            @else
                            <p style="color:#aaa;"><em>Δεν υπάρχουν σχόλια</em></p>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr/>
                <h3 class="text-right">Συνολικές ώρες απασχόλησης: <strong>{{ $totalWorkingHours['hours'] }} ώρες, {{ $totalWorkingHours['minutes'] }} λεπτά</strong></h3>
                @endif
            </div>
        </div>
    </div>
</div>