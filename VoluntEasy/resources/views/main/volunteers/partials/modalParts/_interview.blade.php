
@if($step->statuses[0]->status->description=='Incomplete')
{!! Form::formInput('comments', 'Σχόλια: ', $errors,
['class' => 'form-control', 'type' => 'textarea', 'placeholder' => $step->comments, 'id' =>
'stepTextarea-'.$step->statuses[0]->id, 'value' => $step->statuses[0]->comments]) !!}
@else
<h4>Σχόλια:</h4>
@if($step->statuses[0]->comments==null || $step->statuses[0]->comments=='')
<p>-</p>
@else
<p>{{ $step->statuses[0]->comments }}</p>
@endif
@endif
