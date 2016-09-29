<div class="col-md-4">
    <div class="form-group">
        @if (isset($volunteer))
        {!! Form::formInput('work_status_id', trans('entities/volunteers.workStatus').':', $errors, ['class' => 'form-control',
        'type' => 'select', 'value' => $workStatuses, 'key' => $volunteer->work_status_id, 'required' => 'true']) !!}
        @else
        {!! Form::formInput('work_status_id', trans('entities/volunteers.workStatus').':', $errors, ['class' => 'form-control',
        'type' => 'select', 'value' => $workStatuses, 'required' => 'true']) !!}
        @endif
    </div>
    <div class="form-group">
        {!! Form::formInput('work_description', trans('entities/volunteers.workDescription').':', $errors, ['class' => 'form-control', 'type' =>
        'textarea', 'placeholder' => trans('entities/volunteers.workDescriptionExpl')]) !!}
    </div>

    <div class="form-group">
        {!! Form::formInput('participation_reason', trans('entities/volunteers.participationReason'), $errors, ['class' => 'form-control',
        'required' => 'true', 'type' => 'textarea', 'placeholder' => trans('entities/volunteers.participationReasonExpl')]) !!}
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        {!! Form::formInput('participation_actions', trans('entities/volunteers.volunteeringOrg').':', $errors, ['class' =>
        'form-control',
        'type' => 'textarea', 'placeholder' => trans('entities/volunteers.volunteeringOrgExpl')]) !!}
    </div>
    <div class="form-group">
        {!! Form::formInput('participation_previous', trans('entities/volunteers.volunteeringPrev').':', $errors, ['class' =>
        'form-control', 'type' => 'textarea', 'placeholder' => trans('entities/volunteers.volunteeringPrevExpl')]) !!}
    </div>
</div>
