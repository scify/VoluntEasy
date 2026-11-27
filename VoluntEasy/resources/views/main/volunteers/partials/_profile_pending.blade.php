<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans_choice('entities/volunteers.pendingStuff', 1) }}</h3>
            </div>
            <div class="panel-body">
                @if($pending==0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default smallHeading">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>{{ trans('entities/volunteers.noPendingStuff') }}</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        @if($volunteer->permitted)
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#selectUnit">
                                            <i class="fa fa-home"></i> {{ trans('entities/volunteers.assignToUnit') }}
                                        </button>
                                        @include('main.volunteers.partials.modals._select_unit', ['units' =>
                                        $volunteer->availableUnits, 'divId' => 'selectUnit', 'selectId'=>'moreUnits'])
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('entities/units.unit') }}</th>
                        <th>
                            <small> {{ trans('entities/volunteers.step') }} 1:</small>
                            <br/> {{ trans('entities/volunteers.communicationStep') }}
                        </th>
                        <th>
                            <small> {{ trans('entities/volunteers.step') }} 2:</small>
                            <br/> {{ trans('entities/volunteers.interviewStep') }}
                        </th>
                        <th>
                            <small> {{ trans('entities/volunteers.step') }} 3:</small>
                            <br/> {{ trans('entities/volunteers.assignmentStep') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- For each volunteer unit, show its steps and their statuses --}}
                    {{-- (only if the user has permissions to that unit) --}}

                    @foreach($volunteer->units as $unit)
                    @if(in_array($unit->id, $userUnits))
                    @if($unit->status=='Pending')
                    <tr>
                        <td>{{ $unit->description }}</td>
                        @foreach($unit->steps as $i => $step)
                        <td>
                            @if($volunteer->permitted && (($i==0 &&
                            $step->statuses[0]->status->description=='Incomplete') ||
                            ($i>0 && $unit->steps[$i-1]->statuses[0]->status->description=='Complete' &&
                            $step->statuses[0]->status->description=='Incomplete')))
                            <button type="button" class="btn btn-danger btn-sm width-110" data-toggle="modal"
                                    data-target="#step-{{ $step->statuses[0]->id }}">
                                <i class="fa fa-edit"></i> {{ trans('default.edit') }}
                            </button>
                            @elseif($step->statuses[0]->status->description=='Complete')
                            <button type="button" class="btn btn-success btn-sm  width-110" data-toggle="modal"
                                    data-target="#step-{{ $step->statuses[0]->id }}">
                                <i class="fa fa-info-circle"></i> {{ trans('default.view') }}
                            </button>
                            @else
                            <button type="button" class="btn btn-danger disabled btn-sm width-110">
                                <i class="fa fa-edit"></i> {{ trans('default.edit') }}
                            </button>
                            @endif
                            @include('main.volunteers.partials.modals._step', ['step' => $step, 'parentId' =>
                            $unit->id])
                        </td>
                        @endforeach
                    </tr>
                    @endif
                    @endif
                    @endforeach
                    </tbody>
                </table>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        @if($volunteer->permitted)
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#selectUnit">
                            <i class="fa fa-home"></i> {{ trans('entities/volunteers.assignToUnit') }}
                        </button>
                        @include('main.volunteers.partials.modals._select_unit', ['units' => $volunteer->availableUnits,
                        'divId' => 'selectUnit', 'selectId'=>'moreUnits'])
                        @endif
                    </div>
                    <div class="col-md-10">
                        <div class="pull-right">
                            <h5>{{ trans('default.legend') }}:</h5>
                            <i class="fa fa-square" style="color:#f25656;"></i> {{
                            trans('entities/volunteers.pendingStep') }} | <i
                                class="fa fa-square"
                                style="color:#22BAA0;"></i>
                            {{ trans('entities/volunteers.completedtep') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@section('footerScripts')
<script>
VE.ready(function () {
    function goToProfile(id) {
        window.location.href = VE.url('/volunteers/one/' + id);
    }

    // change the step status
    function changeStepStatus(stepStatus) {
        return VE.http.post('/volunteers/stepStatus/update', stepStatus);
    }

    function assignToUnit(step) {
        return VE.http.post('/volunteers/addToUnit', step).then(goToProfile);
    }

    function assignToAction(step) {
        return VE.http.post('/volunteers/addToAction', step).then(goToProfile);
    }

    function selectedText(select) {
        var option = select && select.options[select.selectedIndex];
        return option ? option.text : '';
    }

    function stepComments(id) {
        var textarea = document.getElementById('stepTextarea-' + id);
        return textarea ? textarea.value : '';
    }

    // save a step
    VE.on(document, 'click', '.saveStep', function (event, button) {
        var id = button.getAttribute('data-id');
        changeStepStatus({id: id, comments: stepComments(id), assignTo: '', status: 'Incomplete'})
            .then(goToProfile).catch(VE.fail);
    });

    // complete a step
    VE.on(document, 'click', '.completeStep', function (event, button) {
        var id = button.getAttribute('data-id');
        changeStepStatus({id: id, comments: stepComments(id), assignTo: '', status: 'Complete'})
            .then(goToProfile).catch(VE.fail);
    });

    // assign to a unit (after completing step 3, or to a sub-unit, or to a first unit)
    VE.on(document, 'click', '.assignToNextUnit', function (event, button) {
        var parentId = button.getAttribute('data-parent'),
            volunteerId = button.getAttribute('data-volunteer-id'),
            select;

        if (parentId != null) {
            select = document.getElementById(button.getAttribute('data-select-id') || ('unitSelect-' + parentId));
            var step = {volunteer_id: volunteerId, assign_id: select.value, parent_unit_id: parentId};
            var stepStatusId = button.getAttribute('data-id');

            if (stepStatusId) {
                // the button of step 3: complete the step, then assign
                changeStepStatus({id: stepStatusId, comments: selectedText(select), assignTo: 'unit', status: 'Complete'})
                    .then(function () { return assignToUnit(step); })
                    .catch(VE.fail);
            } else {
                assignToUnit(step).catch(VE.fail);
            }
        } else {
            select = document.getElementById(button.getAttribute('data-select-id') || 'moreUnits');
            assignToUnit({volunteer_id: volunteerId, assign_id: select.value, parent_unit_id: ''}).catch(VE.fail);
        }
    });

    // assign to an action
    VE.on(document, 'click', '.assignToAction', function (event, button) {
        assignToAction({
            volunteer_id: button.getAttribute('data-volunteer-id'),
            assign_id: document.getElementById('addToAction-' + button.getAttribute('data-unit-id')).value,
            parent_unit_id: ''
        }).catch(VE.fail);
    });

    // after step 3, the volunteer can be assigned to an action of the unit,
    // or stay in the unit they currently are
    VE.on(document, 'click', '.assignToActionOrUnit', function (event, button) {
        var id = button.getAttribute('data-id'),
            volunteerId = button.getAttribute('data-volunteer-id'),
            modal = button.closest('.modal') || document,
            radio = modal.querySelector('input[type="radio"][name="assignment"]:checked');

        if (!radio) return;

        if (radio.value == 'action') {
            var actionSelect = document.getElementById('actionSelect-' + id);
            changeStepStatus({id: id, comments: selectedText(actionSelect), assignTo: 'action', status: 'Complete'})
                .then(function () {
                    return assignToAction({volunteer_id: volunteerId, assign_id: actionSelect.value, parent_unit_id: ''});
                })
                .catch(VE.fail);
        } else {
            var unitId = radio.getAttribute('data-unit-id');
            changeStepStatus({id: id, comments: radio.value, assignTo: 'unit', status: 'Complete'})
                .then(function () {
                    return assignToUnit({volunteer_id: volunteerId, assign_id: unitId, parent_unit_id: unitId});
                })
                .catch(VE.fail);
        }
    });

    // "assign to unit" button
    VE.on(document, 'click', '.assignToAnotherUnit', function (event, button) {
        assignToUnit({
            volunteer_id: button.getAttribute('data-volunteer-id'),
            assign_id: document.getElementById('moreUnits').value,
            parent_unit_id: ''
        }).catch(VE.fail);
    });
});
</script>
@append
