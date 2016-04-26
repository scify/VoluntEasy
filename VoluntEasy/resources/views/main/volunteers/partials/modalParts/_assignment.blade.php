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
{{--*/ $availableUnitsWithParent = $unit->availableUnits /*--}}
{{--*/ $availableUnitsWithParent[$unit->id] = $unit->description /*--}}

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
    //disable/enable the actions dropdown
    $('input:radio[name="assignment"]').change(function () {
        if ($(this).val() == 'action') {
            $('#actionSelect-' + $(this).attr('data-id')).removeAttr('disabled');
        } else {
            $('#actionSelect-' + $(this).attr('data-id')).attr('disabled', 'disabled');
        }
    });
</script>
@append
