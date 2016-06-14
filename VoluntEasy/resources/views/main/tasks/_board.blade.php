<?php $lang = "default."; ?>

<div class="row">
<div class="col-md-12">
<div class="panel panel-white">
<div class="panel-body">

@if(sizeof($action->tasks)>0)

<div class="row board">
    <div class="col-md-12 allTasks">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">

                @if($isPermitted)
                <div class="row bottom-margin text-right">
                    <div class="col-md-12">
                        <a href="#" data-toggle="modal" data-target="#addTask" class="btn btn-info"><i
                                class="fa fa-plus"></i> {{ trans('entities/tasks.addTask') }}</a>
                    </div>
                </div>
                @endif
                @foreach($action->tasks as $task)


                {{-- Task title and info --}}

                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse-{{ $task->id }}"
                           aria-expanded="false" aria-controls="collapse-{{ $task->id }}"
                           class="arrow collapsed task-title task-{{ $task->id }}"
                           data-task-id="{{ $task->id }}"> </a>
                        @if($task->priority==1)
                        <i class="fa fa-circle priority-{{$task->priority}}"
                           title="{{ trans('entities/tasks.lowPriority') }}"></i>
                        @elseif($task->priority==2)
                        <i class="fa fa-circle priority-{{$task->priority}}"
                           title="{{ trans('entities/tasks.mediumPriority') }}"></i>
                        @elseif($task->priority==3)
                        <i class="fa fa-circle priority-{{$task->priority}}"
                           title="{{ trans('entities/tasks.mediumPriority') }}"></i>
                        @elseif($task->priority==4)
                        <i class="fa fa-circle priority-{{$task->priority}}"
                           title="{{ trans('entities/tasks.urgentPriority') }}"></i>
                        @endif
                        <a href="javascript:void(0);" class="viewTask"
                           data-task-id="{{ $task->id }}">{{$task->name}}</a>

                        @if($task->status=="todo")
                            <span
                                class="status todo task-{{$task->id}}">{{ trans('entities/tasks.todoCapitals') }}</span>
                        @elseif($task->status=="done")
                            <span
                                class="status done task-{{$task->id}}">{{ trans('entities/tasks.doneCapitals') }}</span>
                        @elseif($task->status=="doing")
                            <span
                                class="status doing task-{{$task->id}}">{{ trans('entities/tasks.doingCapitals') }}</span>
                        @endif


                        @if(sizeof($task->checklist) > 0)
                        <small class="margin-right-3"><i class="fa fa-check-square-o"
                                                         title="{{ sizeof($task->checklist) }} to-dos"></i> {{
                            $task->completedChecklistItems
                            }}/{{ sizeof($task->checklist) }}
                        </small>
                        @endif


                        @if(sizeof($task->shifts) > 0)
                        <small class="margin-right-3"><i class="fa fa-clock-o"
                                                         title="{{ sizeof($task->shifts) }} {{ trans('entities/tasks.daysHours') }}"></i>
                            {{ sizeof($task->shifts) }}
                        </small>
                        @endif


                        @if($task->expires===0)
                        <small><i class="fa fa-calendar"
                                                         title="{{ trans('entities/tasks.expires') }}"></i></small>
                        <small
                            class="text-warning margin-right-3"
                            title="{{ trans('entities/tasks.todayExpires') }}">
                            {{ trans('entities/tasks.today') }}
                        </small>
                        @elseif($task->expires==-1)
                        <small><i class="fa fa-calendar"
                                                         title="{{ trans('entities/tasks.expires') }}"></i></small>
                        <small
                            class="text-danger margin-right-3"
                            title="{{ trans('entities/tasks.yesterdayExpired') }}">
                            <i class="fa fa-calendar"></i>{{trans('entities/tasks.yesterday') }}
                        </small>
                        @elseif($task->expires==1)
                        <small><i class="fa fa-calendar"
                                                         title="{{ trans('entities/tasks.expires') }}"></i></small>
                        <small
                            class="text-info margin-right-3">
                            {{ trans('entities/tasks.tomorrow') }}
                        </small>
                        @elseif($task->expires>1)
                        <small><i class="fa fa-calendar"
                                                         title="{{ trans('entities/tasks.expires') }}"></i></small>
                        <small class=" margin-right-3"
                               title="{{ trans('entities/tasks.expiresAt') }} {{ $task->dueDateMin }}">
                            {{ $task->dueDateMin }}
                        </small>
                        @elseif($task->expires<-1)
                        <small><i class="fa fa-calendar"
                                                         title="{{ trans('entities/tasks.expires') }}"></i></small>
                        <small class="text-danger margin-right-3"
                             title="{{ trans('entities/tasks.expired') }}">{{
                            $task->due_date }}
                        </small>
                        @endif


                        @if(sizeof($task->users)>0 || sizeof($task->volunteers)>0)
                        <small class="margin-right-3">
                            @foreach($task->users as $user)
                            <img class="img-circle avatar userImage" src="{{ ($user->image_name==null || $user->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$user->image_name) }}"
                                 width="30" height="30"
                                 alt="{{ trans('entities/tasks.assignedTo') }} {{ $user->name }} {{ $user->last_name }}"
                                 title="{{ trans('entities/tasks.assignedTo') }} {{ $user->name }} {{ $user->last_name }}">

                            @endforeach
                            @foreach($task->volunteers as $volunteer)
                            <img class="img-circle avatar userImage" src="{{ ($volunteer->image_name==null || $volunteer->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$volunteer->image_name) }}"
                                 width="30" height="30"
                                 alt="{{ trans('entities/tasks.assignedTo') }} {{ $volunteer->name }} {{ $volunteer->last_name }}"
                                 title="{{ trans('entities/tasks.assignedTo') }} {{ $volunteer->name }} {{ $volunteer->last_name }}">
                            @endforeach
                        </small>
                        @endif
                    </h4>
                </div>
                <div id="collapse-{{ $task->id }}" class="panel-collapse collapse"
                     role="tabpanel"
                     aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        @if(sizeof($task->todoSubtasks)+sizeof($task->doingSubtasks)+sizeof($task->doneSubtasks)>0)
                        <div class="row task-{{ $task->id }} board-row">
                            {{-- To Do subtasks --}}
                            <div class="col-md-4 status-columns">
                                <h3 class="panel-title">{{ trans('entities/tasks.todo') }}</h3>

                                <div class="board-column todo">
                                    @include('main.tasks._subtasks', ['subtasks' => $task->todoSubtasks,
                                    'status' => 'todo'])
                                </div>
                            </div>
                            {{-- Doing subtasks --}}
                            <div class="col-md-4 status-columns">
                                <h3 class="panel-title">{{ trans('entities/tasks.doing') }}</h3>

                                <div class="board-column doing">
                                    @include('main.tasks._subtasks', ['subtasks' => $task->doingSubtasks,
                                    'status' => 'doing'])
                                </div>
                            </div>
                            {{-- Done subtasks --}}
                            <div class="col-md-4 status-columns">
                                <h3 class="panel-title">{{ trans('entities/tasks.done') }}</h3>

                                <div class="board-column done">
                                    @include('main.tasks._subtasks', ['subtasks' => $task->doneSubtasks,
                                    'status' => 'done'])
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if($isPermitted)
                    <div class="row top-margin bottom-margin">
                        <div class="col-md-12 subtask text-right">
                            <a href="javascript:void(0);" data-toggle="modal"
                               data-target="#addSubTask"
                               data-task-id="{{$task->id}}" class="addSubTask btn btn-info"><i
                                    class="fa fa-plus"></i> {{ trans('entities/tasks.addSubtask') }}</a>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-12 text-right">
        <p><strong>{{ trans('default.legend') }}:</strong> <br/>
            <i class="fa fa-calendar"></i> {{ trans('entities/tasks.hoursSum') }} |
            <i class="fa fa-list"></i> {{ trans('entities/tasks.todoSum') }} |
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
@include('main.tasks.modals._add_subtask', ['mode' =>'store'])
@include('main.tasks.modals._view_task')
@include('main.tasks.modals._view_subtask')


@section('footerScripts')
<script src="{{ asset('assets/js/pages/task_board/task_board.js')}}"></script>
<script src="{{ asset('assets/js/pages/task_board/tasks.js')}}"></script>
<script src="{{ asset('assets/js/pages/task_board/subtasks.js')}}"></script>
<script src="{{ asset('assets/js/pages/task_board/shifts.js')}}"></script>
<script src="{{ asset('assets/js/pages/task_board/checklist.js')}}"></script>
<script src="{{ asset('assets/plugins/multiselect/multiselect.min.js')}}"></script>
<script>
    setOpenTask();
</script>
@append
