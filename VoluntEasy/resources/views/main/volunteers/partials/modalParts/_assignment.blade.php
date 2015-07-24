@if($step->statuses[0]->status->description=='Incomplete')
@if(sizeof($unit->actions)>0)

{!! Form::formInput('actionSelect', 'Ανάθεση στη δράση:', $errors, ['class' => 'form-control',
'type' => 'select', 'id' => 'actionSelect-'.$step->statuses[0]->id, 'value' =>
$unit->actions->lists('description', 'id')]) !!}
@else
{!! Form::formInput('', 'Ανάθεση στη μονάδα*:', $errors, ['class' => 'form-control',
'type' => 'select', 'id' => 'unitSelect-'.$step->statuses[0]->id, 'value' =>$unit->availableUnits, 'data-parent' => $unit->id]) !!}
<p class="text-right">
    <small><em>*Μπορείτε να αναθέσετε τον εθελοντή μόνο στις άμεσες υπομονάδες της μονάδας σας.</em>
    </small>
</p>

@endif
@else
@if(sizeof($unit->actions)>0)
<p>Ανατέθηκε στη δράση <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
@else
<p>Ανατέθηκε στη μονάδα <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
@endif
@endif
