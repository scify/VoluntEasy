<p><strong>{{ trans('entities/volunteers.volunteeringDepartments') }}:</strong>
    @if($volunteer->extras!=null && sizeof($volunteer->volunteeringDepartments)==0)
    -
    @else
    @foreach($volunteer->volunteeringDepartments as $i => $dep)
        @if($i<=(sizeof($volunteer->volunteeringDepartments)-1))
        {{ $dep->description }},
        @else
        {{ $dep->description }}
        @endif
    @endforeach
    @endif
</p>
<p><strong>{{ trans('entities/volunteers.otherDepartment') }}:</strong> {{ $volunteer->extras!=null && ($volunteer->extras->other_department!=null || $volunteer->extras->other_department!='') ? $volunteer->extras->other_department : '-' }}</p>

<p><strong>{{ trans('entities/volunteers.hasPreviousVolunteeringExperience') }}:</strong> {{ $volunteer->extras!=null && $volunteer->extras->has_previous_volunteer_experience ? 'Ναι' : 'Όχι' }}</p>

<p><strong>{{ trans('entities/volunteers.previousVolunteeringExperience') }}:</strong> {{ $volunteer->extras!=null && ($volunteer->participation_actions!=null ||
    $volunteer->participation_actions!='') ? $volunteer->participation_actions : '-' }}</p>

<p><strong>{{ trans('entities/volunteers.hasPreviousWorkingExperience') }}:</strong> {{ $volunteer->extras!=null && $volunteer->extras->has_previous_work_experience ? 'Ναι' : 'Όχι' }}</p>

<p><strong>{{ trans('entities/volunteers.previousWorkingExperience') }}:</strong> {{ $volunteer->extras!=null && ($volunteer->work_description!=null ||
    $volunteer->work_description!='') ? $volunteer->work_description : '-'}}</p>
