<?php $lang = "default."; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Ρόλοι χρήστη</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">

                        @foreach($roles as $role)
                        <div class="roles">
                            <input name="roles[]" type="checkbox" value="{{$role->name}}" id="{{$role->name}}">
                            <label for="{{$role->name}}">{{trans($lang.$role->name)}}</label>
                            <br/>
                            <small>{{trans($lang.$role->name.'-descr')}}</small>
                        </div>
                        @endforeach

                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="units" style="display: none;">
                            <p>Οργανωτικές Μονάδες:</p>
                            <select class="js-states form-control" id="unitList" multiple="multiple"
                                    name="unitsSelect[]"
                                    tabindex="-1"
                                    style=" width: 100%">

                                @foreach($units as $unit_id => $unit)
                                <option value="{{ $unit->id }}" name="unit-{{$unit->id}}">{{ $unit->description }}
                                </option>
                                @endforeach
                            </select>
                            <p class="help-block">Κρατήστε πατημένο το πλήκτρο CTRL για να επιλέξετε παραπάνω από μία μονάδες.</p>
                        </div>

                        <div class="form-group" id="actions" style="display: none;">
                            <p>Δράσεις:</p>
                            <select class="js-states form-control" id="actionList" multiple="multiple"
                                    name="unitsSelect[]"
                                    tabindex="-1"
                                    style="width: 100%">

                                @foreach($actions as $action)
                                <option value="{{ $action->id }}" name="action-{{$action->id}}">{{
                                    $action->description }}
                                </option>
                                @endforeach
                            </select>
                            <p class="help-block">Κρατήστε πατημένο το πλήκτρο CTRL για να επιλέξετε παραπάνω από μία δράσεις.</p>
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
    $("#role_id").change(function () {
        var role = $('option:selected', this).val();

        if (role == 'action_manager') {
            $("#actions").show();
            $("#units").hide();
        }
        else if (role == 'unit_manager') {
            $("#units").show();
            $("#actions").hide();
        }
        else if (role == 'admin') {
            $("#units").hide();
            $("#actions").hide();
        }
    });


    $(".roles").children("input:checkbox").click(function (e) {
        var role = $(this).val();

        if ($(this).prop('checked')) {

            if (role == 'action_manager') {
                $("#actions").show();
                $("#units").hide();
            }
            else if (role == 'unit_manager') {
                $("#units").show();
                $("#actions").hide();
            }
            else if (role == 'admin') {
                $("#units").hide();
                $("#actions").hide();
                $("#action_manager").attr("disabled", true);
                $("#unit_manager").attr("disabled", true);
                $("#action_manager").parent().removeClass('checked');
                $("#unit_manager").parent().removeClass('checked');
            }
        }
        else {
            if (role == 'action_manager') {
                $("#actions").hide();
            }
            else if (role == 'unit_manager') {
                $("#units").hide();
            }
            else if (role == 'admin') {
                $("#units").hide();
                $("#actions").hide();
                $("#action_manager").attr("disabled", false);
                $("#unit_manager").attr("disabled", false);
            }
        }
    });


</script>
@append
