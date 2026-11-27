<?php $lang = "default."; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/users.userRoles') }}</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">

                        @foreach($roles as $role)
                        <div class="roles role-details" data-role="{{$role->name}}">
                            <input name="roles[]" type="checkbox" value="{{$role->name}}" id="{{$role->name}}" {{
                            isset($user) &&
                            in_array($role->id, $user->roles()->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label>{{trans($lang.$role->name)}}
                                @if($role->name !='admin')
                                <i class="fa fa-chevron-right"></i>
                                @endif
                            </label>
                            <br/>
                            <small>{{trans($lang.$role->name.'-descr')}}</small>
                        </div>
                        @endforeach

                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="units" style="display: none;">
                            <p>{{ trans('entities/units.units') }}:</p>
                            <select class="js-states form-control" id="unitList" multiple="multiple"
                                    name="unitsSelect[]"
                                    tabindex="-1"
                                    style=" width: 100%">

                                @foreach($units as $unit_id => $unit)
                                <option value="{{ $unit->id }}" name="unit-{{$unit->id}}"
                                {{ isset($user) && in_array($unit->id, $user->units()->pluck('id')->toArray()) ?
                                'selected' : '' }} {{ !in_array($unit->id, $permittedUnits) ? 'disabled' : '' }}>{{
                                $unit->description }}
                                </option>
                                @endforeach
                            </select>

                            <p class="help-block">{{ trans('entities/users.unitSelectExpl') }}<br/>
                                {{ trans('entities/users.unitNotSelectable') }}
                            </p>
                        </div>

                        <div class="form-group" id="actions" style="display: none;">
                            <p>{{ trans('entities/actions.actions') }}:</p>
                            <select class="js-states form-control" id="actionList" multiple="multiple"
                                    name="actionsSelect[]"
                                    tabindex="-1"
                                    style="width: 100%">

                                @foreach($actions as $action)
                                <option value="{{ $action->id }}" name="action-{{$action->id}}"
                                    {{ isset($user) && in_array($action->id, $user->actions()->pluck('id')->toArray()) ?
                                    'selected' : '' }} {{ !in_array($action->unit_id, $permittedUnits) ? 'disabled' : '' }}>{{
                                    $action->description }}
                                </option>
                                @endforeach
                            </select>

                            <p class="help-block">{{ trans('entities/users.actionSelectExpl') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 text-right">
                        <div class="form-group">
                            {!! Form::submit($submitButtonText, ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footerScripts')
<script>
    VE.ready(function () {
        // a click on a role shows the units or the actions to choose
        VE.on(document, 'click', '.role-details', function (event, el) {
            if (el.classList.contains('disabled')) return;
            var role = el.getAttribute('data-role');

            Array.prototype.forEach.call(el.parentNode.querySelectorAll('.role-details'), function (other) { other.classList.toggle('active', other === el); });

            if (role == 'action_manager') {
                VE.show('#actions');
                VE.hide('#units');
            } else if (role == 'unit_manager') {
                VE.show('#units');
                VE.hide('#actions');
            } else if (role == 'admin') {
                VE.hide('#units');
                VE.hide('#actions');
            }
        });
    });
</script>
@append
