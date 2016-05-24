@if(sizeof($timeline)==0)
<h3>{{ trans('entities/volunteers.noHistory') }}</h3>
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
            <h2>{{ trans('entities/volunteers.assignToAction') }} <strong>{{ $timelineBlock->action->description
                    }}</strong></h2>

            <p>{{ trans('entities/volunteers.actionDuration') }}: {{ $timelineBlock->action->start_date }}
                - {{ $timelineBlock->action->end_date }}</p>

            <small class="pull-right">{{ trans('entities/volunteers.assignedFromUser') }} {{ $timelineBlock->user->name
                }} {{ $timelineBlock->user->last_name }}
            </small>

            <span class="cd-date">{{ Carbon::parse($timelineBlock->created_at)->format('d/m/Y') }}</span>
        </div>
    </div>

    @elseif($timelineBlock->type=='unit')

    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-success">
            <i class="fa fa-home"></i>
        </div>
        <div class="cd-timeline-content">
            <h2>{{ trans('entities/volunteers.assignedToUnit') }} <strong>{{ $timelineBlock->unit->description
                    }}</strong></h2>

            @foreach($timelineBlock->unit->steps as $i => $step)
            @if($step->type=='Assignment')
                                <span>
                                    <i class="fa fa-circle status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}"></i>
                                    {{ trans('entities/volunteers.assignedTo') }} {{ $step->statuses[0]->assignedTo=='action' ? trans('entities/actions.action') : trans('entities/units.unit') }}
                                    <strong>{{
                                        $step->statuses[0]->comments }}</strong></span>
            @else

            <span>  <i
                    class="fa fa-circle status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}"></i>{{ $step->description }}</span>

            @if(in_array($timelineBlock->unit->id, $userUnits) && ($step->statuses[0]->comments!=null &&
            $step->statuses[0]->comments!=''))
            <p> {{ trans('entities/volunteers.comments') }}: {{ $step->statuses[0]->comments}}</p>
            @endif

            @endif
            @endforeach

            <p>
                <small class="pull-right"> {{ trans('entities/volunteers.assignedFromUser') }} {{
                    $timelineBlock->user->name }}
                </small>
            </p>

            <span class="cd-date">{{ Carbon::parse($timelineBlock->created_at)->format('d/m/Y') }}</span>
        </div>
    </div>

    @elseif($timelineBlock->type=='status')

    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-success">
            <i class="fa fa-exclamation"></i>
        </div>
        <div class="cd-timeline-content">
            <h4>{{ trans('entities/volunteers.volunteerWasNotAvailableFromTo') }} {{ $timelineBlock->from_date}}
                - {{ $timelineBlock->to_date}}</h4>

            @if($timelineBlock->comments!=null && $timelineBlock->comments!='')
            <p>{{ trans('entities/volunteers.comments') }}: {{ $timelineBlock->comments}}</p>
            @endif

            <span class="cd-date">{{ $timelineBlock->to_date }}</span>
        </div>
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
