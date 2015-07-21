@if(sizeof($volunteer->units)==0)
<div class="row">
    <div class="col-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-body">
                <h3>Ο εθελοντής δεν ανήκει σε καμία οργανωτική μονάδα ή δράση.</h3>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
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
                        <th>Ημ. Ισχύος</th>
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
                            @else
                             dsa
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($volunteer->units as $unit)
                    <tr>
                        <td>{{ $unit->description }}</td>
                        @foreach($unit->steps as $i => $step)
                        <td>
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ $step->description }}</span>
                            @if(($i==0 && $step->statuses[0]->status->description=='Incomplete') || ($i>0 &&
                            $unit->steps[$i-1]->statuses[0]->status->description=='Complete' &&
                            $step->statuses[0]->status->description=='Incomplete'))
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                    data-target="#step-{{ $step->statuses[0]->id }}">
                                <i class="fa fa-2x fa-edit"></i>
                            </button>
                            @elseif($step->statuses[0]->status->description=='Complete' && $step->type!='Assignment')
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                    data-target="#step-{{ $step->statuses[0]->id }}">
                                <i class="fa fa-2x fa-info-circle"></i>
                            </button>
                            @endif
                            @include('main.volunteers.partials._step_modal', ['step' => $step])

                        </td>
                        @endforeach
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

        changeStepStatus(stepStatus);

    });

    //complete a step
    $(".completeStep").click(function () {
        var id = $(this).attr('data-id');

        var stepStatus = {
            'id': id,
            'comments': $('#stepTextarea-' + id).val(),
            'status': 'Complete'
        };

        changeStepStatus(stepStatus);
    });

    //assign volunteer to unit
    //and complete step
    $(".assignToUnit").click(function () {
        var id = $(this).attr('data-id');

        var stepStatus = {
            'id': id,
            'comments': '',
            'status': 'Complete'
        };

        $.when(changeStepStatus(stepStatus))
                .then(function () {
                    var data = {
                        'volunteer_id': $(this).attr('data-volunteer-id'),
                        'unit_id': $('#unitSelect').val()
                    };

                    $.ajax({
                        url: $("body").attr('data-url') + '/volunteers/addToUnit',
                        method: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                        },
                        success: function (data) {
                            //    console.log(data);
                            window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
                        }
                    });
                });
    });

    function changeStepStatus(stepStatus) {

        console.log(stepStatus);

        return $.ajax({
            url: $("body").attr('data-url') + '/volunteers/stepStatus/update',
            method: 'POST',
            data: stepStatus,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                //    console.log(data);
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    }


</script>
@stop
