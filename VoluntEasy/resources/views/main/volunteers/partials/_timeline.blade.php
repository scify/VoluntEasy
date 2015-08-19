@if(sizeof($timeline)==0)
<h3>Το ιστορικό του εθελοντή είναι άδειο.</h3>
@else
<section id="cd-timeline" class="cd-container">
    @foreach($timeline as $timelineBlock)

    @if($timelineBlock->type=='action')

    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-primary">
            <i class="fa fa-bullseye"></i>
        </div>
        <!-- cd-timeline-img -->

        <div class="cd-timeline-content">
            <h2>Ανάθεση στη δράση <strong>{{ $timelineBlock->action->description }}</strong></h2>

            <p>Διάρκεια δράσης: {{ $timelineBlock->action->start_date }} - {{ $timelineBlock->action->end_date }}</p>

            <!-- RATING STARS -->
            @if($timelineBlock->action->rating!=null)
            <div class="row">
                <div class="col-md-4">
                    <h4>Συνέπεια</h4>

                    <div id="attr1" class="attribute rating"
                         data-score="{{ $volunteer->ratings->rating_attr1 / $volunteer->ratings->rating_attr1_count }}"></div>
                </div>
                <div class="col-md-4">
                    <h4>Στυλ</h4>

                    <div id="attr2" class="attribute rating"
                         data-score="{{ $volunteer->ratings->rating_attr2 / $volunteer->ratings->rating_attr2_count }}"></div>
                </div>
                <div class="col-md-4">
                    <h4>Αγάπη για γάτες</h4>

                    <div id="attr3" class="attribute rating"
                         data-score="{{ $volunteer->ratings->rating_attr3 / $volunteer->ratings->rating_attr3_count }}"></div>
                </div>
            </div>
            <p>Η αξιολόγηση έγινε από τον υπεύθυνο της δράσης (email: <a
                    href="mailto:{{$timelineBlock->action->email}}">{{$timelineBlock->action->email}}</a>)</p>
            @endif

            <small class="pull-right">Η ανάθεση έγινε από το χρήστη {{ $timelineBlock->user->name }}</small>

            <span class="cd-date">{{ Carbon::parse($timelineBlock->created_at)->format('d/m/Y') }}</span>
        </div>
        <!-- cd-timeline-content -->
    </div>

    @elseif($timelineBlock->type=='unit')

    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-success">
            <i class="fa fa-home"></i>
        </div>
        <div class="cd-timeline-content">
            <h2>Ένταξη στη μονάδα <strong>{{ $timelineBlock->unit->description }}</strong></h2>

            @foreach($timelineBlock->unit->steps as $i => $step)
            @if($step->type=='Assignment')
            <p><span
                    class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση στη {{ $step->statuses[0]->assignedTo=='action' ? 'δράση' : 'μονάδα'}} <strong>{{
                $step->statuses[0]->comments }}</strong></span>
                @else

            <p><span
                    class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
            </p>
            @if(in_array($timelineBlock->unit->id, $userUnits) && ($step->statuses[0]->comments!=null && $step->statuses[0]->comments!=''))
            <p>Σχόλια: {{ $step->statuses[0]->comments}}</p>
            @endif

            @endif
            @endforeach

            <p><small class="pull-right">Η ένταξη έγινε από το χρήστη {{ $timelineBlock->user->name }}</small></p>

            <span class="cd-date">{{ Carbon::parse($timelineBlock->created_at)->format('d/m/Y') }}</span>
        </div>
        <!-- cd-timeline-content -->
    </div>
    @endif
    @endforeach


</section> <!-- cd-timeline -->
@endif

@section('footerScripts')
<script>
    $('.attribute.rating').raty({
        starOff: '{{ asset("assets/plugins/raty/lib/images/star-off.png")}}',
        starOn: '{{ asset("assets/plugins/raty/lib/images/star-on.png")}}',
        starHalf: '{{ asset("assets/plugins/raty/lib/images/star-half.png")}}',
        readOnly: true,
        score: function () {
            return $(this).attr('data-score');
        }
    });
</script>
@append
