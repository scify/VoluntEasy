@foreach($subtasks as $subtask)
<div class="board-card priority-{{ $subtask->priority }} viewSubtask"
     data-task="{{ $task->id }}"
     data-subtask="{{ $subtask->id }}"
     data-status="{{$status}}">

    <div class="row no-left-margin bottom-margin-10">
        <div class="col-12"><strong>{{$subtask->name}}</strong></div>
    </div>

    <div class="row no-left-margin">
        <div class="col-md-10 no-padding">
            <small class="margin-right-3">
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
            </small>

            @if($subtask->expires==-1)
            <small><i class="fa fa-calendar" title="{{ trans('entities/tasks.expires') }}"></i></small>
            <small class="text-danger margin-right-3">{{
                trans('entities/tasks.yesterday') }}
            </small>
            @elseif($subtask->expires==0)
            <small><i class="fa fa-calendar" title="{{ trans('entities/tasks.expires') }}"></i></small>
            <small class="text-warning margin-right-3">{{
                trans('entities/tasks.today') }}
            </small>
            @elseif($subtask->expires==1)
            <small><i class="fa fa-calendar" title="{{ trans('entities/tasks.expires') }}"></i></small>
            <small class="text-info margin-right-3">{{
                trans('entities/tasks.tomorrow') }}
            </small>
            @elseif($subtask->expires>1)
            <small><i class="fa fa-calendar" title="{{ trans('entities/tasks.expires') }}"></i></small>
            <small class="margin-right-3">{{ $subtask->dueDateMin }}</small>
            @elseif($subtask->expires<-1)
            <small><i class="fa fa-calendar" title="{{ trans('entities/tasks.expires') }}"></i></small>
            <small class="text-danger margin-right-3">{{ $subtask->due_date }}
            </small>
            @endif
        </div>
        <div class="col-md-2">
            @if(sizeof($subtask->users)>0 || sizeof($subtask->volunteers)>0)
            <small>
                @foreach($subtask->users as $user)
                <img class="img-circle avatar userImage" src="{{ ($user->image_name==null || $user->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$user->image_name) }}"
                     width="30" height="30"
                     alt="{{ trans('entities/tasks.assignedTo') }} {{ $user->name }} {{ $user->last_name }}"
                     title="{{ trans('entities/tasks.assignedTo') }} {{ $user->name }} {{ $user->last_name }}">
                @endforeach
                @foreach($subtask->volunteers as $volunteer)
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
