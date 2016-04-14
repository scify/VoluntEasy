@if(!$customRatings)
 <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans('entities/volunteers.participationToActions') }}</h3>
            </div>
            <div class="panel-body">
                @if($actionsCount==0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default smallHeading">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>{{ trans('entities/volunteers.volunteerHasnotParticipated') }}</h4>
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
                            <th>{{ trans('entities/actions.action') }}</th>
                            <th>{{ trans('entities/tasks.task') }} > {{ trans('entities/subtasks.subtask') }}</th>
                            <th>{{ trans('entities/volunteers.duration') }}</th>
                            <th>{{ trans('entities/volunteers.workHours') }}</th>
                            <th>{{ trans('entities/volunteers.rating') }}</th>
                            <th>{{ trans('entities/volunteers.comments') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($actionsRatings as $action)
                            <tr>
                                <td class="col-md-2"><a
                                            href="{{ url('actions/one/'.$action->id) }}">{{ $action->description }}</a>
                                    <br/><small>{{ $action->start_date }} - {{ $action->end_date }}</small>
                                </td>
                                <td class="col-md-3">
                                    @if($action->name!=null && $action->name!='')
                                        {{ $action->name }} <br/>
                                    @endif
                                    @if($action->email!=null && $action->email!='') <i
                                            class="fa fa-envelope"></i> <a
                                            href="mailto:{{ $action->email }}">{{$action->email }}</a>
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
                                        {{ $action->ratingHours<10 ? '0'.$action->ratingHours : $action->ratingHours }}
                                        :{{ $action->ratingMinutes<10 ? '0'.$action->ratingMinutes : $action->ratingMinutes }}
                                    @else
                                        <p style="color:#aaa;"><em>{{ trans('entities/volunteers.noWorkHours') }}</em></p>
                                    @endif
                                </td>
                                <td class="col-md-5">
                                    @if(sizeof($action->ratings)>0)
                                        @foreach($action->ratings as $i => $rating)
                                            <span class="attribute rating"
                                                  data-score="{{ $rating['rating']/$action->ratingCount}}"></span>
                                            <small><span> {{ $i }} </span></small>
                                            <br/>
                                        @endforeach
                                    @else
                                        <p style="color:#aaa;"><em>{{ trans('entities/volunteers.noRating') }}</em></p>
                                    @endif
                                </td>
                                <td class="col-md-2">
                                    @if(sizeof($action->ratings)>0 && isset($action->ratingComments) && $action->ratingComments!='')
                                        {{ $action->ratingComments }}
                                    @else
                                        <p style="color:#aaa;"><em>{{ trans('entities/volunteers.noComments') }}</em></p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr/>
                    <h3 class="text-right">{{ trans('entities/volunteers.noComments') }}: <strong>{{ $totalWorkingHours['hours'] }}
                            {{ trans('entities/volunteers.hours') }}, {{ $totalWorkingHours['minutes'] }} {{ trans('entities/volunteers.minutes') }}</strong></h3>
                @endif
            </div>
        </div>
    </div>
</div>

@else

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans('entities/volunteers.participationToActions') }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        @if(sizeof($volunteer->actionHistory)>0)
                            <table class="table table-condensed timesheet">
                                <thead>
                                <th></th>
                                <th>{{ trans('entities/volunteers.date') }}</th>
                                <th>{{ trans_choice('entities/volunteers.time', 10) }}</th>
                                <th>{{ trans('entities/volunteers.comments') }}</th>
                                <th>{{ trans('entities/volunteers.totalHours') }}</th>
                                </thead>
                                <tbody>
                                @foreach($volunteer->actionHistory as $history)
                                    @if(sizeof($history->action->allTasks)>0)
                                        <tr class="action">
                                            <td>{{ trans('entities/actions.action') }} <a href="{{  url('actions/one/'.$history->action->id) }}"
                                                         target="_blank">{{ $history->action->description }}</a></td>
                                            <td colspan="3">
                                                <small>{{ $history->action->start_date }} - {{ $history->action->end_date }}</small>
                                            </td>
                                            <td class="col-md-2 text-center">{{ $history->action->workHours }}</td>
                                        </tr>
                                        @foreach($history->action->allTasks as $task)
                                            <tr class="task">
                                                <td colspan="4">{{ trans('entities/tasks.task') }} {{ $task->name }}</td>
                                                <td class="col-md-2 text-center">
                                                    <strong>{{ $task->work_hours }}</strong></td>
                                            </tr>
                                            @foreach($task->allSubtasks as $subtask)
                                                @if(sizeof($subtask->allWorkDates)>0)
                                                    <tr class="subtask">
                                                        <td colspan="4">{{ trans('entities/subtasks.subtask') }} {{ $subtask->name }}</td>
                                                        <td class="col-md-2 text-center">
                                                            <strong>{{ $subtask->workHours }}</strong></td>
                                                    </tr>
                                                    @foreach($volunteer->workDateHistory as $wdHistory)
                                                        @if($wdHistory->workDate->trashedSubtask->id==$subtask->id)
                                                        <tr>
                                                            <td>{{ $wdHistory->workDate->comments }}</td>
                                                            <td>{{ $wdHistory->workDate->from_date }}</td>
                                                            <td>{{ $wdHistory->workDate->from_hour }}
                                                                - {{ $wdHistory->workDate->to_hour }}</td>
                                                            <td>-</td>
                                                            <td class="col-md-2 text-center">
                                                                <strong>{{ $wdHistory->workDate->workHours }}</strong></td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <br/>
                            <h4>{{ trans('entities/volunteers.volunteerHasnotParticipated') }}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans('entities/volunteers.ctaInterested') }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        @if(sizeof($volunteer->ctaVolunteers)>0)
                            <h4>{{ trans('entities/volunteers.volunteerIsInterestedIn') }}:</h4>
                            <table class="table table-condensed timesheet">
                                <thead>
                                <th>{{ trans('entities/actions.action') }}</th>
                                <th>{{ trans('entities/tasks.task') }}</th>
                                <th>{{ trans('entities/subtask.subtask') }}</th>
                                <th>{{ trans('entities/volunteers.date') }}</th>
                                <th>{{ trans_choice('entities/volunteers.time', 10) }}</th>
                                </thead>
                                <tbody>
                                @foreach($volunteer->ctaVolunteers[0]->dates as $date)
                                   <tr>
                                       <td>{{ $date->date->subtask->task->action->description }}</td>
                                       <td>{{ $date->date->subtask->task->name }}</td>
                                       <td>{{ $date->date->subtask->name }}</td>
                                       <td>{{ $date->date->from_date }}</td>
                                       <td>{{ $date->date->from_hour }} - {{ $date->date->to_hour }}</td>
                                   </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <br/>
                            <h4>{{ trans('entities/volunteers.volunteerNotInterested') }}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
