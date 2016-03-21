<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans('entities/volunteers.completeSteps') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('entities/units.unit') }}</th>
                        <th>{{ trans('entities/volunteers.step') }} 1</th>
                        <th>{{ trans('entities/volunteers.step') }} 2</th>
                        <th>{{ trans('entities/volunteers.step') }} 3</th>
                    </tr>
                    </thead>
                    <tbody>

                    {{-- For each volunteer unit, show its steps and their statuses --}}

                    @foreach($volunteer->units as $unit)
                    @if($unit->status=='Available' || $unit->status=='Active')
                    <tr>
                        <td>{{ $unit->description }}</td>
                        @foreach($unit->steps as $i => $step)
                        <td>
                            @if($step->type=='Assignment')
                            @if(sizeof($unit->actions)>0)
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ trans('entities/volunteers.assignToAction') }}</span>
                            @else
                            <span class="status {{ $step->statuses[0]->status->description=='Incomplete' ? 'incomplete' : 'completed' }}">{{ trans('entities/volunteers.assignToUnit') }}</span>
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
                            @include('main.volunteers.partials.modals._step', ['step' => $step])

                        </td>
                        @endforeach
                    </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
