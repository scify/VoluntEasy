<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">{{ trans_choice('entities/volunteers.volunteerStatus', 1) }}</h3>
            </div>
            <div class="panel-body">
                @if(sizeof($volunteer->units)==0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default smallHeading">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>{{ trans('entities/volunteers.volunteerDoesnotBelongToUnitAction') }}</h4>
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
                            <th>{{ trans('entities/volunteers.status') }}</th>
                            <th>{{ trans('entities/actions.action') }}</th>
                            <th class="text-center">
                                @if($hasTasks)
                                    <small>{{ trans('entities/volunteers.assignToSubUnit') }}</small>
                                @else
                                    <small>{{ trans('entities/volunteers.assignToActionOrUnit') }}</small>
                                @endif
                            </th>
                            <th class="text-center">
                                <small>{{ trans('entities/volunteers.removeFromUnit') }}</small>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($volunteer->units as $unit)
                            <tr>
                                <td class="col-md-2"><a
                                            href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
                                </td>
                                <td class="col-md-2">
                                    @if($unit->status=='Pending')
                                        <div class="status pending width-110">{{ trans('entities/volunteers.pending') }}</div>
                                    @elseif($unit->status=='Available')
                                        <div class="status available width-110">{{ trans('entities/volunteers.availableOne') }}</div>
                                    @elseif($unit->status=='Active')
                                        <div class="status active width-110">{{ trans('entities/volunteers.activeOne') }}</div>
                                    @endif
                                </td>
                                <td class="col-md-4">
                                    @if($unit->status=='Active')
                                        @foreach($volunteer->actions as $action)
                                            @if($action->unit_id==$unit->id)
                                                {{ trans('entities/actions.action') }} <strong><a
                                                            href="{{ url('actions/one/'.$action->id) }}">{{
                                $action->description
                                }}</a></strong>
                                                <small>({{ $action->start_date }} - {{ $action->end_date }})</small>
                                                <br/>
                                            @endif
                                        @endforeach
                                    @elseif(sizeof($unit->actions)>0 && $unit->status=='Available')
                                        <p style="color:#aaa;">
                                            <em>{{ trans('entities/volunteers.volunteerNotInAction') }}</em></p>
                                    @elseif(sizeof($unit->actions)==0)
                                        <p style="color:#aaa;"><em>{{ trans('entities/volunteers.unitNoActions') }}</em>
                                        </p>
                                    @endif
                                </td>
                                <td class="col-md-2">
                                    <div class="text-center">

                                        @if($volunteer->permitted && $unit->status=='Available' && sizeof($unit->actions)>0)
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#selectAction-unit{{$unit->id}}">
                                                <i class="fa fa-bullseye"></i>
                                            </button>
                                            @include('main.volunteers.partials.modals._select_action', ['divId' =>
                                            'selectAction-unit'.$unit->id])
                                        @endif


                                        @if($volunteer->permitted && $unit->status=='Available' && sizeof($unit->children)>0)
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#selectUnit-unit{{$unit->id}}">
                                                <i class="fa fa-home"></i>
                                            </button>
                                            @include('main.volunteers.partials.modals._select_unit', ['units' =>
                                            $unit->availableUnits, 'divId' => 'selectUnit-unit'.$unit->id, 'parentId' => $unit->id, 'selectId'=>'moreUnits-unit'.$unit->id])
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center col-md-2">
                                    @if($volunteer->permitted && in_array($unit->id, $userUnits))
                                        <a href="#"
                                           class="btn btn-danger btn-sm removeFromUnit"
                                           data-volunteer-id="{{ $volunteer->id }}"
                                           data-unit-id="{{ $unit->id }}"><i
                                                    class="fa fa-remove fa-1x"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

@section('footerScripts')
    <script>

        //display appropriate message before removing volunteer from action
        $(".removeFromAction").click(function (event) {
            event.preventDefault();
            if (confirm(Lang.get('js-components.removeVolunteerFromAction')) == true) {
                volunteerId = $(this).attr('data-volunteer-id');
                actionId = $(this).attr('data-action-id');

                $.ajax({
                    url: $("body").attr('data-url') + '/volunteers/' + volunteerId + '/action/detach/' + actionId,
                    method: 'GET',
                    headers: {
                        'X-CSRF-Token': $('#token').val()
                    },
                    success: function () {
                        location.reload();
                    }
                });
            }
        });

        //display appropriate message before removing volunteer from unit
        $(".removeFromUnit").click(function (event) {
            event.preventDefault();
            console.log($(this).attr('data-unit-id'))
            if (confirm(Lang.get('js-components.removeVolunteerFromUnit')) == true) {
                volunteerId = $(this).attr('data-volunteer-id');
                unitId = $(this).attr('data-unit-id');

                $.ajax({
                    url: $("body").attr('data-url') + '/volunteers/' + volunteerId + '/unit/detach/' + unitId,
                    method: 'GET',
                    headers: {
                        'X-CSRF-Token': $('#token').val()
                    },
                    success: function () {
                        location.reload();
                    }
                });

            }
        });

    </script>
@append
