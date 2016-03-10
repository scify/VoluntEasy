<p><strong>Τομείς προσφοράς εθελοντικής υπηρεσίας:</strong>
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
<p><strong>Άλλος τομέας ενασχόλησης:</strong> {{ $volunteer->extras!=null && ($volunteer->extras->other_department!=null || $volunteer->extras->other_department!='') ? $volunteer->extras->other_department : '-' }}</p>
<p><strong>Εθελοντική Εμπειρία:</strong> {{ $volunteer->extras!=null && $volunteer->extras->has_previous_volunteer_experience ? 'Ναι' : 'Όχι' }}</p>
<p><strong>Εθελοντική εμπειρία - σχόλια:</strong> {{ $volunteer->extras!=null && ($volunteer->participation_actions!=null ||
    $volunteer->participation_actions!='') ? $volunteer->participation_actions : '-' }}</p>
<p><strong>Εργασιακή Εμπειρία:</strong> {{ $volunteer->extras!=null && $volunteer->extras->has_previous_work_experience ? 'Ναι' : 'Όχι' }}</p>
<p><strong>Εργασιακή εμπειρία - σχόλια:</strong> {{ $volunteer->extras!=null && ($volunteer->work_description!=null ||
    $volunteer->work_description!='') ? $volunteer->work_description : '-'}}</p>
