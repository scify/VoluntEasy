<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Εκκρεμότητες</h3>
            </div>
            <div class="panel-body">
                @if($pending==0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default smallHeading">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Ο εθελοντής δεν έχει καμία εκκρεμότητα.</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        @if($volunteer->permitted)
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#selectUnit">
                                            <i class="fa fa-home"></i> Ένταξη σε μονάδα
                                        </button>
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
                        <th>Οργανωτική Μονάδα</th>
                        <th>Βήμα 1</th>
                        <th>Βήμα 2</th>
                        <th>Βήμα 3</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- For each volunteer unit, show its steps and their statuses --}}

                    @foreach($volunteer->units as $unit)
                    @if($unit->status=='Pending')
                    <tr>
                        <td>{{ $unit->description }}</td>
                        @foreach($unit->steps as $i => $step)
                        <td>
                            @if($step->type=='Assignment')
                            @if(sizeof($unit->actions)>0)
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση σε δράση/μονάδα</span>
                            @else
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση σε μονάδα</span>
                            @endif
                            @else
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
                            @endif

                            @if($volunteer->permitted && (($i==0 &&
                            $step->statuses[0]->status->description=='Incomplete') ||
                            ($i>0
                            && $unit->steps[$i-1]->statuses[0]->status->description=='Complete' &&
                            $step->statuses[0]->status->description=='Incomplete')))
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                    data-target="#step-{{ $step->statuses[0]->id }}">
                                <i class="fa fa-2x fa-edit"></i>
                            </button>
                            @elseif($step->statuses[0]->status->description=='Complete')
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                    data-target="#step-{{ $step->statuses[0]->id }}">
                                <i class="fa fa-2x fa-info-circle"></i>
                            </button>
                            @endif
                            @include('main.volunteers.partials._step_modal', ['step' => $step])

                        </td>
                        @endforeach
                        <td>
                            @if($volunteer->permitted)
                            <a href="{{url('/volunteers/'.$volunteer->id.'/unit/detach/'.$unit->id)}}"
                               data-toggle="tooltip"
                               data-placement="bottom" title="Αφαίρεση από τη μονάδα"><i class="fa fa-remove fa-2x"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        @if($volunteer->permitted)
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#selectUnit">
                            <i class="fa fa-home"></i> Ένταξη σε μονάδα
                        </button>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <div class="pull-right">
                            <h5>Υπόμνημα:</h5>
                            <i class="fa fa-square" style="color:#f25656;"></i> Το βήμα εκκρεμεί | <i
                                class="fa fa-square"
                                style="color:#22BAA0;"></i>
                            Το βήμα έχει ολοκληρωθεί
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Select unit modal -->
<div class="modal fade" id="selectUnit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Επιλογή μονάδας</h4>
            </div>
            <div class="modal-body">
                @if(sizeof($volunteer->availableUnits)==0)
                <p>Δεν υπάρχει διαθέσιμη μονάδα.</p>

                <p class="text-right">
                    <small><em>*Διαθέσιμες θεωρούνται οι άμεσες υπομονάδες σας στις οποίες δεν ανήκει ήδη ο
                        εθελοντής.</em>
                    </small>
                </p>
                @else
                {!! Form::formInput('', 'Ανάθεση στη μονάδα*:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $volunteer->availableUnits, 'id' => 'moreUnits']) !!}
                <p class="text-right">
                    <small><em>*Μπορείτε να αναθέσετε τον εθελοντή μόνο στις άμεσες υπομονάδες της μονάδας σας.</em>
                    </small>
                </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-success assignToMoreUnits"
                        data-volunteer-id="{{ $volunteer->id }}">Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->


@section('footerScripts')
<script>

    //save a step
    $(".saveStep").click(function () {
        var id = $(this).attr('data-id');

        var stepStatus = {
            'id': id,
            'comments': $('#stepTextarea-' + id).val(),
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
            'status': 'Complete'
        };

        changeStepStatus(stepStatus, true);
    });


    //assign to a unit after completing step 3
    $(".assignToNextUnit").click(function () {
        var id = $(this).attr('data-id');
        var unitSelect = $('#unitSelect-' + id);

        var stepStatus = {
            'id': id,
            'comments': unitSelect.text(),
            'status': 'Complete'
        };

        var step = {
            'volunteer_id': $(this).attr('data-volunteer-id'),
            'assign_id': unitSelect.val(),
            'parent_unit_id': unitSelect.attr('data-parent')
        };

        $.when(changeStepStatus(stepStatus, false))
                .then(assignToUnit(step));
    });


    //assign to an action after completing step 3
    $(".assignToAction").click(function () {
        var id = $(this).attr('data-id');

        var stepStatus = {
            'id': id,
            'comments': $('#actionSelect-' + id + ' option:selected').text(),
            'status': 'Complete'
        };

        var step = {
            'volunteer_id': $(this).attr('data-volunteer-id'),
            'assign_id': $('#actionSelect-' + id).val(),
            'parent_unit_id': ''
        };

        $.when(changeStepStatus(stepStatus, false))
                .then(assignToAction(step));

    });


    //after completing step 3, the volunteer might be to unit
    //that has actions. the user can assign the volunteer either to an action
    //or keep thme to the unit they currently are.
    $(".assignToActionOrUnit").click(function () {
        var id = $(this).attr('data-id');
        var assignmentRadio = $('input:radio[name="assignment"]:checked');
        var stepStatus, step;

        if (assignmentRadio.val() == 'unit') {
            stepStatus = {
                'id': id,
                'comments': assignmentRadio.val(),
                'status': 'Complete'
            };

            step = {
                'volunteer_id': $(this).attr('data-volunteer-id'),
                'assign_id': assignmentRadio.attr('data-unit-id'),
                'parent_unit_id': assignmentRadio.attr('data-unit-id')
            };

            $.when(changeStepStatus(stepStatus, false))
                    .then(assignToUnit(step));
        } else {
            stepStatus = {
                'id': id,
                'comments': $('#actionSelect-' + id + ' option:selected').text(),
                'status': 'Complete'
            };

            step = {
                'volunteer_id': $(this).attr('data-volunteer-id'),
                'assign_id': $('#actionSelect-' + id).val(),
                'parent_unit_id': ''
            };

            $.when(changeStepStatus(stepStatus, false))
                    .then(assignToAction(step));
        }
    });

    //moreUnits button
    $(".assignToMoreUnits").click(function () {
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
