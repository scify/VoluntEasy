<section id="cd-timeline" class="cd-container">

    @foreach($timeline as $timelineBlock)

    @if($timelineBlock->type=='action')

    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-primary">
            <i class="fa fa-bookmark"></i>
        </div>
        <!-- cd-timeline-img -->

        <div class="cd-timeline-content">
            <h2>Ανάθεση στη δράση <strong>{{ $timelineBlock->action->description }}</strong></h2>

            <!-- DUMMY STARS -->
            <p><i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i></p>

            <p>Διάρκεια δράσης: {{ $timelineBlock->action->start_date }} - {{ $timelineBlock->action->end_date }}</p>
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
        <!-- cd-timeline-img -->

        <div class="cd-timeline-content">
            <h2>Ένταξη στη μονάδα <strong>{{ $timelineBlock->unit->description }}</strong></h2>

            @foreach($timelineBlock->unit->steps as $i => $step)
            @if($step->type=='Assignment')
            <p><span
                    class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση στη δράση/μονάδα <strong>{{ $step->statuses[0]->comments }}</strong></span>
            @else
            <p><span
                    class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
                <br/>
                Σχόλια:
                @if($step->statuses[0]->status->comments==null || $step->statuses[0]->comments=='')
                -
                @else
                {{ $step->statuses[0]->status->comments}}
                @endif
            </p>
            @endif
            @endforeach

            <small class="pull-right">Η ένταξη έγινε από το χρήστη {{ $timelineBlock->user->name }}</small>

            <span class="cd-date">{{ Carbon::parse($timelineBlock->created_at)->format('d/m/Y') }}</span>
        </div>
        <!-- cd-timeline-content -->
    </div>
    @endif

    @endforeach


</section> <!-- cd-timeline -->
