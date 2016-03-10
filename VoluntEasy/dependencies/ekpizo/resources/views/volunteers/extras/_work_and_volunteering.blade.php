<div class="col-md-4">
    <p>Τομείς προσφοράς εθελοντικής υπηρεσίας:</p>
    @foreach($volunteeringDepartments as $department)
        <div class="form-group">
            @if (isset($volunteer) && in_array($department->id, $volunteer->volunteeringDepartments->lists('id')->all())
            )
                {!! Form::formInput('departments['.$department->id.']', $department->description , $errors, ['class'
                =>
                'form-control',
                'type' => 'checkbox', 'value' => $department->id, 'checked' => 'true']) !!}
            @else
                {!! Form::formInput('departments['.$department->id.']', $department->description, $errors, ['class' =>
                'form-control','type' => 'checkbox', 'value' => $department->id, 'checked' => 'false']) !!}
            @endif
        </div>
    @endforeach

    <div class="form-group">
        @if (isset($volunteer) && $volunteer->extras!=null && $volunteer->extras->other_department)
        {!! Form::formInput('other_department', 'Άλλος τομέας ενασχόλησης:', $errors, ['class' =>
        'form-control', 'type' => 'textarea', 'size' => '2x3', 'value' => $volunteer->extras->other_department]) !!}
        @else
        {!! Form::formInput('other_department', 'Άλλος τομέας ενασχόλησης:', $errors, ['class' =>
        'form-control', 'type' => 'textarea', 'size' => '2x3']) !!}
        @endif

    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        @if (isset($volunteer) && $volunteer->extras!=null && $volunteer->extras->has_previous_volunteer_experience)
            {!! Form::formInput('has_previous_volunteer_experience', 'Εθελοντική Εμπειρία', $errors, ['class'
            =>'form-control', 'type' => 'checkbox', 'checked' => 'true']) !!}
        @else
            {!! Form::formInput('has_previous_volunteer_experience', 'Εθελοντική εμπειρία', $errors, ['class'
            =>'form-control',  'type' => 'checkbox', 'checked' => 'false']) !!}
        @endif
    </div>

    <div class="form-group">
        {!! Form::formInput('participation_actions', 'Εθελοντική εμπειρία - σχόλια:', $errors, ['class' =>
        'form-control', 'type' => 'textarea']) !!}
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        @if (isset($volunteer) && $volunteer->extras!=null && $volunteer->extras->has_previous_work_experience)
            {!! Form::formInput('has_previous_work_experience', 'Εργασιακή Εμπειρία', $errors, ['class'
            =>'form-control',
            'type' => 'checkbox', 'checked' => 'true'])
            !!}
        @else
            {!! Form::formInput('has_previous_work_experience', 'Εργασιακή Εμπειρία', $errors, ['class'
            =>'form-control',
            'type' => 'checkbox', 'checked' => 'false']) !!}
        @endif
    </div>

    <div class="form-group">
        {!! Form::formInput('work_description', 'Εργασιακή Εμπειρία - σχόλια', $errors, ['class' =>
        'form-control', 'type' => 'textarea']) !!}
    </div>
</div>
