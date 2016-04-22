<?php $lang = "default."; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">

                @if(sizeof($action->tasks)>0)

                    <div class="row board">
                        <div class="col-md-8 allTasks">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">

                                    @foreach($action->tasks as $task)

                                        {{-- Task title and info --}}

                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse-{{ $task->id }}"
                                                   aria-expanded="false" aria-controls="collapse-{{ $task->id }}"
                                                   class="arrow collapsed task-title task-{{ $task->id }}"
                                                   data-task-id="{{ $task->id }}"
                                                   onclick="showTaskInfo({{ $task->id }})"> {{$task->name}}</a>

                                                @if($task->status=="todo")
                                                    <span class="status todo task-{{$task->id}}">{{ trans('entities/tasks.todoCapitals') }}</span>
                                                @elseif($task->status=="done")
                                                    <span class="status done task-{{$task->id}}">{{ trans('entities/tasks.doneCapitals') }}</span>
                                                @elseif($task->status=="doing")
                                                    <span class="status doing task-{{$task->id}}">{{ trans('entities/tasks.doingCapitals') }}</span>
                                                @endif

                                                <small> {{ sizeof($task->todoSubtasks) + sizeof($task->doingSubtasks) +
                sizeof($task->doneSubtasks) }} subtasks
                                                </small>

                                                @if($task->priority==1)
                                                    <i class="fa fa-arrow-up priority-{{$task->priority}}"
                                                       title="{{ trans('entities/tasks.lowPriority') }}"></i>
                                                @elseif($task->priority==2)
                                                    <i class="fa fa-arrow-up priority-{{$task->priority}}"
                                                       title="{{ trans('entities/tasks.mediumPriority') }}"></i>
                                                @elseif($task->priority==3)
                                                    <i class="fa fa-arrow-up priority-{{$task->priority}}"
                                                       title="{{ trans('entities/tasks.mediumPriority') }}"></i>
                                                @elseif($task->priority==4)
                                                    <i class="fa fa-arrow-up priority-{{$task->priority}}"
                                                       title="{{ trans('entities/tasks.urgentPriority') }}"></i>
                                                @endif

                                                <span>
                                                            @if($task->expires==null)
                                                        <span></span>
                                                    @elseif($task->expires==-1)
                                                        <i class="fa fa-calendar"></i>
                                                        <small
                                                                class="text-danger" title="{{ trans('entities/tasks.yesterdayExpired') }}">{{ trans('entities/tasks.yesterday') }}
                                                        </small>
                                                    @elseif($task->expires==0)
                                                        <i class="fa fa-calendar"></i>
                                                        <small
                                                                class="text-warning" title="{{ trans('entities/tasks.todayExpires') }}">
                                                            {{ trans('entities/tasks.today') }}
                                                        </small>
                                                    @elseif($task->expires==1)
                                                        <i class="fa fa-calendar" title="{{ trans('entities/tasks.tomorrowExpires') }}"></i>
                                                        <small
                                                                class="text-info">
                                                            {{ trans('entities/tasks.tomorrow') }}
                                                        </small>
                                                    @elseif($task->expires>1)
                                                        <i class="fa fa-calendar"></i>
                                                        <small
                                                                title="{{ trans('entities/tasks.expiresAt') }} {{ $task->due_date }}">{{ $task->due_date
                                                 }}
                                                        </small>
                                                    @elseif($task->expires<-1)
                                                        <i class="fa fa-calendar"></i>
                                                        <small
                                                                class="text-danger"
                                                                title="{{ trans('entities/tasks.expired') }}">{{ $task->due_date }}
                                                        </small>
                                                    @endif
                                         </span>
                                            </h4>
                                        </div>

                                        <div id="collapse-{{ $task->id }}" class="panel-collapse collapse"
                                             role="tabpanel"
                                             aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">

                                                @if(sizeof($task->todoSubtasks)+sizeof($task->doingSubtasks)+sizeof($task->doneSubtasks)>0)

                                                    <div class="row task-{{ $task->id }} board-row">

                                                        {{-- To Do subtasks --}}
                                                        <div class="col-md-4">
                                                            <h3 class="panel-title">{{ trans('entities/tasks.todo') }}</h3>

                                                            <div class="board-column todo">
                                                                @foreach($task->todoSubtasks as $subtask)
                                                                    <div class="board-card priority-{{ $subtask->priority }}"
                                                                         data-task="{{ $task->id }}"
                                                                         data-subtask="{{ $subtask->id }}"
                                                                         data-status="todo">
                                                                        <p><a href="javascript:void(0);"
                                                                              onclick="showSubTaskInfo({{ $subtask->id }})">{{$subtask->name}}</a>
                                                        <span class="pull-right">
                                                            @if($subtask->expires=='null')
                                                                <small></small>
                                                            @elseif($subtask->expires==-1)
                                                                <small class="text-danger">{{ trans('entities/tasks.yesterday') }}</small>
                                                            @elseif($subtask->expires==0)
                                                                <small class="text-warning">{{ trans('entities/tasks.today') }}</small>
                                                            @elseif($subtask->expires==1)
                                                                <small class="text-info">{{ trans('entities/tasks.tomorrow') }}</small>
                                                            @elseif($subtask->expires>1)
                                                                <small>{{ $subtask->due_date }}</small>
                                                            @elseif($subtask->expires<-1)
                                                                <small class="text-danger">{{ $subtask->due_date }}
                                                                </small>
                                                            @endif
                                                            </span></p>
                                                                        <div>
                                                                            @if(sizeof($subtask->work_dates) >0 )
                                                                                <i class="fa fa-calendar"
                                                                                   title="{{ sizeof($subtask->work_dates) }} {{ trans('entities/tasks.daysHours') }}"></i> {{ sizeof($subtask->work_dates) }}
                                                                            @endif
                                                                            @if($subtask->ctaVolunteersCount >0 )
                                                                                <i class="fa fa-leaf"
                                                                                   title="{{ $subtask->ctaVolunteersCount }} {{ trans('entities/tasks.interestedVolunteers') }}"></i> {{ $subtask->ctaVolunteersCount }}
                                                                            @endif
                                                                            @if(sizeof($subtask->checklist) >0 )
                                                                                <i class="fa fa-list"
                                                                                   title="{{ sizeof($subtask->checklist) }} to-dos"></i> {{ sizeof($subtask->checklist) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        {{-- Doing subtasks --}}
                                                        <div class="col-md-4">
                                                            <h3 class="panel-title">{{ trans('entities/tasks.doing') }}</h3>

                                                            <div class="board-column doing">
                                                                @foreach($task->doingSubtasks as $subtask)
                                                                    <div class="board-card priority-{{ $subtask->priority }}"
                                                                         data-task="{{ $task->id }}"
                                                                         data-subtask="{{ $subtask->id }}"
                                                                         data-status="todo">
                                                                        <p><a href="javascript:void(0);"
                                                                              onclick="showSubTaskInfo({{ $subtask->id }})">{{$subtask->name}}</a>
                                                        <span class="pull-right">
                                                            @if($subtask->expires=='null')
                                                                <small></small>
                                                            @elseif($subtask->expires==-1)
                                                                <small class="text-danger">{{ trans('entities/tasks.yesterday') }}</small>
                                                            @elseif($subtask->expires==0)
                                                                <small class="text-warning">{{ trans('entities/tasks.today') }}</small>
                                                            @elseif($subtask->expires==1)
                                                                <small class="text-info">{{ trans('entities/tasks.tomorrow') }}</small>
                                                            @elseif($subtask->expires>1)
                                                                <small>{{ $subtask->due_date }}</small>
                                                            @elseif($subtask->expires<-1)
                                                                <small class="text-danger">{{ $subtask->due_date }}
                                                                </small>
                                                            @endif
                                                            </span></p>
                                                                        <div>
                                                                            @if(sizeof($subtask->work_dates) >0 )
                                                                                <i class="fa fa-calendar"
                                                                                   title="{{ sizeof($subtask->work_dates) }} {{ trans('entities/tasks.daysHours') }}"></i> {{ sizeof($subtask->work_dates) }}
                                                                            @endif
                                                                            @if($subtask->ctaVolunteersCount >0 )
                                                                                <i class="fa fa-leaf"
                                                                                   title="{{ $subtask->ctaVolunteersCount }} {{ trans('entities/tasks.interestedVolunteers') }}"></i> {{ $subtask->ctaVolunteersCount }}
                                                                            @endif
                                                                            @if(sizeof($subtask->checklist) >0 )
                                                                                <i class="fa fa-list"
                                                                                   title="{{ sizeof($subtask->checklist) }} to-dos"></i> {{ sizeof($subtask->checklist) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>


                                                        {{-- Done subtasks --}}
                                                        <div class="col-md-4">
                                                            <h3 class="panel-title">{{ trans('entities/tasks.done') }}</h3>

                                                            <div class="board-column done">
                                                                @foreach($task->doneSubtasks as $subtask)
                                                                    <div class="board-card priority-{{ $subtask->priority }}"
                                                                         data-task="{{ $task->id }}"
                                                                         data-subtask="{{ $subtask->id }}"
                                                                         data-status="todo">
                                                                        <p><a href="javascript:void(0);"
                                                                              onclick="showSubTaskInfo({{ $subtask->id }})">{{$subtask->name}}</a>
                                                        <span class="pull-right">
                                                            @if($subtask->expires=='null')
                                                                <small></small>
                                                            @elseif($subtask->expires==-1)
                                                                <small class="text-danger">{{ trans('entities/tasks.yesterday') }}</small>
                                                            @elseif($subtask->expires==0)
                                                                <small class="text-warning">{{ trans('entities/tasks.today') }}</small>
                                                            @elseif($subtask->expires==1)
                                                                <small class="text-info">{{ trans('entities/tasks.tomorrow') }}</small>
                                                            @elseif($subtask->expires>1)
                                                                <small>{{ $subtask->due_date }}</small>
                                                            @elseif($subtask->expires<-1)
                                                                <small class="text-danger">{{ $subtask->due_date }}
                                                                </small>
                                                            @endif
                                                            </span></p>
                                                                        <div>
                                                                            @if(sizeof($subtask->work_dates) >0 )
                                                                                <i class="fa fa-calendar"
                                                                                   title="{{ sizeof($subtask->work_dates) }} {{ trans('entities/tasks.daysHours') }}"></i> {{ sizeof($subtask->work_dates) }}
                                                                            @endif
                                                                            @if($subtask->ctaVolunteersCount >0 )
                                                                                <i class="fa fa-leaf"
                                                                                   title="{{ $subtask->ctaVolunteersCount }} {{ trans('entities/tasks.interestedVolunteers') }}"></i> {{ $subtask->ctaVolunteersCount }}
                                                                            @endif
                                                                            @if(sizeof($subtask->checklist) >0 )
                                                                                <i class="fa fa-list"
                                                                                   title="{{ sizeof($subtask->checklist) }} to-dos"></i> {{ sizeof($subtask->checklist) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif
                                                @if($isPermitted)
                                                    <div class="row top-margin">
                                                        <div class="col-md-12 subtask">
                                                            <a href="javascript:void(0);" data-toggle="modal"
                                                               data-target="#addSubTask"
                                                               data-task-id="{{$task->id}}" class="addSubTask"><i
                                                                        class="fa fa-plus"></i> {{ trans('entities/tasks.addSubtask') }}</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 infoSidebar">
                            @include('main.tasks.partials._task_info')
                            @include('main.tasks.partials._subtask_info')
                        </div>
                    </div>

                    @if($isPermitted)
                        <div class="row top-margin">
                            <div class="col-md-12">
                                <a href="#" data-toggle="modal" data-target="#addTask"><i
                                            class="fa fa-plus"></i> {{ trans('entities/tasks.addTask') }}</a>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <p><strong>{{ trans('default.legend') }}:</strong> <br/>
                                <i class="fa fa-calendar"></i> {{ trans('entities/tasks.hoursSum') }} |
                                <i class="fa fa-list"></i> {{ trans('entities/tasks.todoSum') }} <br/>
                                <i class="fa fa-leaf"></i> {{ trans('entities/tasks.volunteerSum') }}
                            </p>
                        </div>
                    </div>
                @else
                    <p>{{ trans('entities/tasks.noTask') }}</p>

                    @if($isPermitted)
                        <div class="row top-margin">
                            <div class="col-md-12">
                                <a href="#" data-toggle="modal" data-target="#addTask"><i
                                            class="fa fa-plus"></i> {{ trans('entities/tasks.addTask') }}</a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

@include('main.tasks.modals._add_task', ['mode' =>'store'])
@include('main.tasks.modals._edit_task', ['mode' =>'store'])
@include('main.tasks.modals._add_subtask', ['mode' =>'store'])
@include('main.tasks.modals._edit_subtask', ['mode' =>'store'])
@include('main.tasks.modals._add_work_date')
@include('main.tasks.modals._edit_work_date')


@section('footerScripts')
    <script src="{{ asset('assets/js/pages/task_board/task_board.js')}}"></script>
    <script src="{{ asset('assets/js/pages/task_board/tasks.js')}}"></script>
    <script src="{{ asset('assets/js/pages/task_board/subtasks.js')}}"></script>
    <script src="{{ asset('assets/js/pages/task_board/workdates.js')}}"></script>
    <script src="{{ asset('assets/plugins/multiselect/multiselect.min.js')}}"></script>
    <script>
        setOpenTask();
    </script>
@append
