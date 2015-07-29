@if($step->statuses[0]->status->description=='Incomplete')
@if(sizeof($unit->actions)>0)

<div class="form-group">

    <label>
        {!! Form::formInput('assignment', '', $errors, ['class' => 'form-control', 'type' => 'radio', 'value' =>
        'action', 'checked' => 'true', 'data-id' => $step->statuses[0]->id]) !!} Ανάθεση στη δράση
    </label>
    {!! Form::formInput('actionSelect', '', $errors, ['class' => 'form-control',
    'type' => 'select', 'id' => 'actionSelect-'.$step->statuses[0]->id, 'value' =>
    $unit->actions->lists('description', 'id')]) !!}
</div>

<div class="form-group">
    <label>
        {!! Form::formInput('assignment', '', $errors, ['class' => 'form-control', 'type' => 'radio', 'value' => $unit->description,
        'checked' => 'false', 'data-id' => $step->statuses[0]->id, 'data-unit-id' => $unit->id]) !!} Ανάθεση στη μονάδα <strong>{{ $unit->description
        }}</strong>
    </label>
</div>
@else
{!! Form::formInput('', 'Ανάθεση στη μονάδα*:', $errors, ['class' => 'form-control',
'type' => 'select', 'id' => 'unitSelect-'.$step->statuses[0]->id, 'value' => $unit->availableUnits, 'data-parent' => $unit->id]) !!}
<p class="text-right">
    <small><em>*Μπορείτε να αναθέσετε τον εθελοντή μόνο στις άμεσες υπομονάδες της μονάδας σας.</em>
    </small>
</p>
@endif
@else
@if(sizeof($unit->actions)>0)
<p>Ανατέθηκε στη δράση/μονάδα <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
@else
<p>Ανατέθηκε στη μονάδα <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
@endif
@endif


@section('footerScripts')
//disable/enable the actions dropdown
<script>
    $('input:radio[name="assignment"]').change(function () {
        if ($(this).val() == 'action') {
            $('#actionSelect-' + $(this).attr('data-id')).removeAttr('disabled');
        } else {
            $('#actionSelect-' + $(this).attr('data-id')).attr('disabled', 'disabled');
        }
    });
</script>
@append
