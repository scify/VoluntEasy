{{-- <div class="row">
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
                            <th>Task > Subtask</th>
                            <th>Διάρκεια</th>
                            <th>'Ωρες απασχόλησης</th>
                            <th>Αξιολόγηση</th>
                            <th>Σχόλια</th>
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
                                        <p style="color:#aaa;"><em>Δεν έχουν σημειωθεί ώρες απασχόλησης</em></p>
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
                    <h3 class="text-right">Συνολικές ώρες απασχόλησης: <strong>{{ $totalWorkingHours['hours'] }}
                            ώρες, {{ $totalWorkingHours['minutes'] }} λεπτά</strong></h3>
                @endif
            </div>
        </div>
    </div>
</div>
--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans('entities/volunteers.participationToActions') }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        @if(sizeof($volunteer->actions)>0)
                            <table class="table table-condensed timesheet">
                                <thead>
                                <th></th>
                                <th>{{ trans('entities/volunteers.date') }}</th>
                                <th>{{ trans_choice('entities/volunteers.time', 10) }}</th>
                                <th>{{ trans('entities/volunteers.comments') }}</th>
                                <th>{{ trans('entities/volunteers.totalHours') }}</th>
                                </thead>
                                <tbody>
                                @foreach($volunteer->actions as $action)
                                    @if(sizeof($action->tasks)>0)
                                        <tr class="action">
                                            <td>{{ trans('entities/actions.action') }} <a href="{{  url('actions/one/'.$action->id) }}"
                                                         target="_blank">{{ $action->description }}</a></td>
                                            <td colspan="3">
                                                <small>{{ $action->start_date }} - {{ $action->end_date }}</small>
                                            </td>
                                            <td class="col-md-2 text-center">{{ $action->workHours }}</td>
                                        </tr>
                                        @foreach($action->tasks as $task)
                                            <tr class="task">
                                                <td colspan="4">{{ trans('entities/tasks.task') }} {{ $task->name }}</td>
                                                <td class="col-md-2 text-center">
                                                    <strong>{{ $task->work_hours }}</strong></td>
                                            </tr>
                                            @foreach($task->subtasks as $subtask)
                                                @if(sizeof($subtask->workDates)>0)
                                                    <tr class="subtask">
                                                        <td colspan="4">{{ trans('entities/subtasks.subtask') }} {{ $subtask->name }}</td>
                                                        <td class="col-md-2 text-center">
                                                            <strong>{{ $subtask->workHours }}</strong></td>
                                                    </tr>
                                                    @foreach($subtask->workDates as $workDate)
                                                        <tr>
                                                            <td>{{ $workDate->comments }}</td>
                                                            <td>{{ $workDate->from_date }}</td>
                                                            <td>{{ $workDate->from_hour }}
                                                                - {{ $workDate->to_hour }}</td>
                                                            <td>-</td>
                                                            <td class="col-md-2 text-center">
                                                                <strong>{{ $workDate->workHours }}</strong></td>
                                                        </tr>
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
