@if(sizeof($volunteer->units)==0)
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-body">
                <h3>Ο εθελοντής δεν ανήκει σε καμία οργανωτική μονάδα ή δράση.</h3>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Κατάσταση Εθελοντή</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Οργανωτική Μονάδα</th>
                        <th>Κατάσταση</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($volunteer->units as $unit)
                    <tr>
                        <td>{{ $unit->description }}</td>
                        <td>
                            @if($unit->status=='Pending')
                            <span class="status pending">Υπό ένταξη</span>
                            @elseif($unit->status=='Available')
                            <span class="status available">Διαθέσιμος</span>
                            @elseif($unit->status=='Active')
                            <span class="status active">Ενεργός</span>
                            @else
                            @endif
                        </td>
                        <td>
                            @if($unit->status=='Active')
                            @foreach($volunteer->actions as $action)
                            @if($action->unit_id==$unit->id)
                            <p>Δράση <strong><a href="{{ url('actions/one/'.$action->id) }}">{{ $action->description
                                }}</a></strong><br/>
                                <small>{{ $action->start_date }} - {{ $action->end_date }}</small>
                            </p>
                            @endif
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Εκκρεμότητες</h3>
            </div>
            <div class="panel-body">
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
                    <tr>
                        <td>{{ $unit->description }}</td>
                        @foreach($unit->steps as $i => $step)
                        <td>
                            @if($step->type=='Assignment')
                            @if(sizeof($unit->actions)>0)
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση σε δράση</span>
                            @else
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">Ανάθεση σε μονάδα</span>
                            @endif
                            @else
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
                            @endif

                            @if(($i==0 && $step->statuses[0]->status->description=='Incomplete') || ($i>0 &&
                            $unit->steps[$i-1]->statuses[0]->status->description=='Complete' &&
                            $step->statuses[0]->status->description=='Incomplete'))
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
                            <a href="{{url('/')}}" data-toggle="tooltip"
                               data-placement="bottom" title="Αφαίρεση από τη μονάδα"><i class="fa fa-remove fa-2x"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr/>
                <div class="pull-right">
                    <h5>Υπόμνημα:</h5>
                    <i class="fa fa-square" style="color:#f25656;"></i> Το βήμα εκκρεμεί | <i class="fa fa-square"
                                                                                              style="color:#22BAA0;"></i>
                    Το βήμα έχει ολοκληρωθεί
                </div>
            </div>
        </div>
    </div>
</div>
@endif


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

    //assign volunteer to unit
    //and complete step
    $(".assignToUnit").click(function () {
        var id = $(this).attr('data-id');
        parent_unit_id = '';

        //check if the assignment is to a unit or to an action
        if ($('#unitSelect-' + id).length > 0) {
            comments = $('#unitSelect-' + id + ' option:selected').text();
            url = $("body").attr('data-url') + '/volunteers/addToUnit';
            assign_id = $('#unitSelect-' + id).val();
            parent_unit_id = $('#unitSelect-' + id).attr('data-parent');
        }
        else if ($('#actionSelect-' + id).length > 0) {
            comments = $('#actionSelect-' + id + ' option:selected').text();
            url = $("body").attr('data-url') + '/volunteers/addToAction';
            assign_id = $('#actionSelect-' + id).val();
        }

        var stepStatus = {
            'id': id,
            'comments': comments,
            'status': 'Complete',
            'available': true
        };

        $.when(changeStepStatus(stepStatus, false))
                .then(function (volunteer_id) {
                    var step = {
                        'volunteer_id': volunteer_id,
                        'assign_id': assign_id,
                        'parent_unit_id': parent_unit_id
                    };

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: step,
                        headers: {
                            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                        },
                        success: function (data) {
                            window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
                        }
                    });

                });
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


</script>
@stop
