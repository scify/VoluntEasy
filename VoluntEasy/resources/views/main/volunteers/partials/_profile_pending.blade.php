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

//save a step
$(".saveStep").click(function () {
    var id = $(this).attr('data-id');

    var stepStatus = {
        'id': id,
        'comments': $('#stepTextarea-' + id).val(),
        'assignTo': '',
        'status': 'Incomplete'
    };

    changeStepStatus(stepStatus, true);

});

//complete a step
$(".completeStep").click(function () {
    var id = $(this).attr('data-id');

    var stepStatus = {
        'id': id,
        'comments': $('#stepTextarea-' + id).val(),
        'assignTo': '',
        'status': 'Complete'
    };

    changeStepStatus(stepStatus, true);
});


//assign to a unit after completing step 3
$(".assignToNextUnit").click(function () {
    var id = $(this).attr('data-parent'),
        step, stepStatus;
    console.log(id);
    if (id != null) {
        var selectId;

        if (typeof $(this).attr('data-select-id') === "undefined")
            selectId = '#unitSelect-' + id;
        else
            selectId = "#" + $(this).attr('data-select-id');


        step = {
            'volunteer_id': $(this).attr('data-volunteer-id'),
            'assign_id': $(selectId).val(),
            'parent_unit_id': $(this).attr('data-parent')
        };

        stepStatus = {
            'id': id,
            'comments': $(selectId + ' option:selected').text(),
            'assignTo': 'unit',
            'status': 'Complete'
        };

        console.log(step);
        console.log(stepStatus);


        $.when(changeStepStatus(stepStatus, false))
            .then(assignToUnit(step));

    }
    else {
        console.log(id);

        step = {
            'volunteer_id': $(this).attr('data-volunteer-id'),
            'assign_id': $('#moreUnits').val(),
            'parent_unit_id': null
        };

        // console.log(step);
        assignToUnit(step);
    }
})
;


//assign to an action after completing step 3
$(".assignToAction").click(function () {
    var step = {
        'volunteer_id': $(this).attr('data-volunteer-id'),
        'assign_id': $('#addToAction-' + $(this).attr('data-unit-id')).val(),
        'parent_unit_id': ''
    };
    console.log(step);

    assignToAction(step);
});


//after completing step 3, the volunteer might be to unit
//that has actions. the user can assign the volunteer either to an action
//or keep them to the unit they currently are.
$(".assignToActionOrUnit").click(function () {
    var id = $(this).attr('data-id');
    var assignmentRadio = $('input:radio[name="assignment"]:checked');
    var stepStatus, step;

    if (assignmentRadio.val() == 'action') {
        stepStatus = {
            'id': id,
            'comments': $('#actionSelect-' + id + ' option:selected').text(),
            'assignTo': 'action',
            'status': 'Complete'
        };

        step = {
            'volunteer_id': $(this).attr('data-volunteer-id'),
            'assign_id': $('#actionSelect-' + id).val(),
            'parent_unit_id': ''
        };
        /*  console.log('action');
         console.log(stepStatus);
         console.log(step);*/

        $.when(changeStepStatus(stepStatus, false))
            .then(assignToAction(step));

    } else {
        stepStatus = {
            'id': id,
            'comments': assignmentRadio.val(),
            'assignTo': 'unit',
            'status': 'Complete'
        };

        step = {
            'volunteer_id': $(this).attr('data-volunteer-id'),
            'assign_id': assignmentRadio.attr('data-unit-id'),
            'parent_unit_id': assignmentRadio.attr('data-unit-id')
        };

        /* console.log('unit');
         console.log(stepStatus);
         console.log(step);
         */

        $.when(changeStepStatus(stepStatus, false))
            .then(assignToUnit(step));
    }
});

//'entaksi se monada' button
$(".assignToAnotherUnit").click(function () {
    var step = {
        'volunteer_id': $(this).attr('data-volunteer-id'),
        'assign_id': $('#moreUnits').val(),
        'parent_unit_id': ''
    };

    assignToUnit(step);
});

//change the step status
function changeStepStatus(stepStatus, redirect) {
    if (redirect)
        return $.ajax({
            url: $("body").attr('data-url') + '/volunteers/stepStatus/update',
            method: 'POST',
            data: stepStatus,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    else
        return $.ajax({
            url: $("body").attr('data-url') + '/volunteers/stepStatus/update',
            method: 'POST',
            data: stepStatus,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
}

function assignToUnit(step) {
    return $.ajax({
        url: $("body").attr('data-url') + '/volunteers/addToUnit',
        method: 'POST',
        data: step,
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
            window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
        }
    });
}

function assignToAction(step) {
    return $.ajax({
        url: $("body").attr('data-url') + '/volunteers/addToAction',
        method: 'POST',
        data: step,
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        },
        success: function (data) {
            window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
        }
    });
}

</script>
@append
