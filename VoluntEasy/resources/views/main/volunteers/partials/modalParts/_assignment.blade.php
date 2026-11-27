@if($step->statuses[0]->status->description=='Incomplete')
@if(sizeof($unit->actions)>0)


<div class="form-group">
    <label>
        {!! Form::formInput('assignment', '', $errors, ['class' => 'form-control', 'type' => 'radio', 'value' =>
        $unit->description,
        'checked' => 'false', 'data-id' => $step->statuses[0]->id, 'data-unit-id' => $unit->id]) !!} {!!
        trans('entities/volunteers.assignToUnitAndMakeAvailable', ['unit' => $unit->description]) !!}
    </label>
</div>

@else
{{-- also add the parent unit to the available units --}}
@php
    $availableUnitsWithParent = $unit->availableUnits;
    $availableUnitsWithParent[$unit->id] = $unit->description;
@endphp

{!! Form::formInput('', trans('entities/volunteers.assignToUnit') .'*:', $errors, ['class' => 'form-control',
'type' => 'select', 'id' => 'unitSelect-'.$unit->id, 'value' => $availableUnitsWithParent, 'data-parent' => $unit->id]) !!}

<p class="text-right">
    <small><em>*{{ trans('entities/volunteers.assignToUnitExpl') }}</em>
    </small>
</p>
@endif

@else
@if(sizeof($unit->actions)>0)
<p>{{ trans('entities/volunteers.assignedToUnit') }} <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
@else
<p>{{ trans('entities/volunteers.assignedToActionOrUnit') }} <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
@endif
@endif


@section('footerScripts')
<script>
    VE.ready(function () {
        // this partial is included once for each step: add the handler only once
        if (window.VEAssignmentRadios) return;
        window.VEAssignmentRadios = true;

        // disable/enable the actions dropdown
        VE.on(document, 'change', 'input[type="radio"][name="assignment"]', function (event, radio) {
            var select = document.getElementById('actionSelect-' + radio.getAttribute('data-id'));
            if (select) select.disabled = radio.value != 'action';
        });
    });
</script>
@append
