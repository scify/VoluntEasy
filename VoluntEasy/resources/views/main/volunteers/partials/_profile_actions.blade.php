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
                    @foreach($timeline as $block)
                    @if($block->type=='action')
                    <tr>
                        <td class="col-md-2"><a href="{{ url('actions/one/'.$block->action->id) }}">{{
                                $block->action->description }}</a>
                        </td>
                        <td class="col-md-3">
                            @if($block->action->name!=null && $block->action->name!='')
                                {{ $block->action->name }} <br/>
                            @endif
                            @if($block->action->email!=null && $block->action->email!='') <i
                                class="fa fa-envelope"></i> <a href="mailto:{{ $block->action->email }}">{{
                                $block->action->email }}</a>
                            @endif
                            @if($block->action->phone_number!=null && $block->action->phone_number!='')
                            <i class="fa fa-phone"></i> {{ $block->action->phone_number }}
                            @endif
                        </td>
                        <td class="col-md-2">
                            {{ $block->action->start_date }} - {{ $block->action->end_date }}
                        </td>
                        <td class="col-md-2">
                            @if(sizeof($block->action->ratings)>0)
                            {{ $block->action->ratings[0]->volunteerRatings[0]->hours<10 ? '0'.$block->action->ratings[0]->volunteerRatings[0]->hours : $block->action->ratings[0]->volunteerRatings[0]->hours }}:{{ $block->action->ratings[0]->volunteerRatings[0]->minutes<10 ? '0'.$block->action->ratings[0]->volunteerRatings[0]->minutes : $block->action->ratings[0]->volunteerRatings[0]->minutes }}
                            @else
                            <p style="color:#aaa;"><em>Δεν έχουν σημειωθεί ώρες απασχόλησης</em></p>
                            @endif
                        </td>
                        <td class="col-md-5">
                            @if(sizeof($block->action->ratings)>0)
                                @foreach($block->action->ratings[0]->volunteerRatings[0]->ratings as $i => $rating)
                                            <span class="attribute rating" data-score="{{ $rating->rating }}"></span>
                                            <small><span> {{ $rating->attribute->description }} </span></small>
                                            <br/>
                                @endforeach
                            @else
                                <p style="color:#aaa;"><em>Δεν έχει γίνει αξιολόγηση</em></p>
                            @endif
                        </td>
                        <td class="col-md-2">
                            @if(sizeof($block->action->ratings)>0)
                            {{ $block->action->ratings[0]->volunteerRatings[0]->comments }}
                            @else
                            <p style="color:#aaa;"><em>Δεν υπάρχουν σχόλια</em></p>
                            @endif
                        </td>
                    </tr>
                    @endif
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
