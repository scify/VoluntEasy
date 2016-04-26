@foreach($subtasks as $subtask)
<div class="board-card priority-{{ $subtask->priority }}"
     data-task="{{ $task->id }}"
     data-subtask="{{ $subtask->id }}"
     data-status="{{$status}}">

    <div class="row no-left-margin bottom-margin-10">
        <div class="col-12"><a href="javascript:void(0);"
                               onclick="showSubTaskInfo({{ $subtask->id }})">{{$subtask->name}}</a>
        </div>
    </div>

    <div class="row no-left-margin">
        <div class="col-md-10 no-padding">
            @if(sizeof($subtask->shifts) >0 )
            <i class="fa fa-clock-o"
               title="{{ sizeof($subtask->shifts) }} {{ trans('entities/tasks.daysHours') }}"></i>
            {{ sizeof($subtask->shifts) }}
            @endif
            @if($subtask->ctaVolunteersCount >0 )
            <i class="fa fa-leaf"
               title="{{ $subtask->ctaVolunteersCount }} {{ trans('entities/tasks.interestedVolunteers') }}"></i>
            {{ $subtask->ctaVolunteersCount }}
            @endif
            @if(sizeof($subtask->checklist) >0 )
            <i class="fa fa-list"
               title="{{ sizeof($subtask->checklist) }} to-dos"></i> {{ $subtask->completedChecklistItems
            }}/{{ sizeof($subtask->checklist) }}
            @endif

            @if($subtask->expires=='null')
            <small></small>
            @elseif($subtask->expires==-1)
            <i class="fa fa-clock-o" title="{{ trans('entities/tasks.expires') }}"></i>
            <small class="text-danger">{{
                trans('entities/tasks.yesterday') }}
            </small>
            @elseif($subtask->expires==0)
            <i class="fa fa-clock-o" title="{{ trans('entities/tasks.expires') }}"></i>
            <small class="text-warning">{{
                trans('entities/tasks.today') }}
            </small>
            @elseif($subtask->expires==1)
            <i class="fa fa-clock-o" title="{{ trans('entities/tasks.expires') }}"></i>
            <small class="text-info">{{
                trans('entities/tasks.tomorrow') }}
            </small>
            @elseif($subtask->expires>1)
            <i class="fa fa-clock-o" title="{{ trans('entities/tasks.expires') }}"></i>
            <small>{{ $subtask->dueDateMin }}</small>
            @elseif($subtask->expires<-1)
            <i class="fa fa-clock-o" title="{{ trans('entities/tasks.expires') }}"></i>
            <small class="text-danger">{{ $subtask->due_date }}
            </small>
            @endif
        </div>
        <div class="col-md-2">
            @if(sizeof($task->users)>0 || sizeof($task->volunteers)>0)
            <small>
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
        </div>
    </div>
</div>
@endforeach
