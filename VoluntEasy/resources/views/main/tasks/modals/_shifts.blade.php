<div class="row">
    <div class="col-md-12">
        <div class="shiftInfo">
            <p class="padding noShifts" style="display:none;"><em>{{ trans('entities/subtasks.noShiftDiagram')
                    }}</em></p>
            <table class="table table-condensed table-bordered shiftsTable">
                <thead>
                <th>{{ trans('entities/subtasks.description') }}</th>
                <th>{{ trans('entities/subtasks.date') }}</th>
                <th>{{ trans('entities/subtasks.hourFrom') }}</th>
                <th>{{ trans('entities/subtasks.hourTo') }}</th>
                <th>{{ trans('entities/subtasks.volunteerSum') }}</th>
                <th>{{ trans('entities/subtasks.availableVolunteers') }}</th>
                @if($isPermitted)
                <th></th>
                @endif
                </thead>
                <tbody class="body">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <p class="text-danger" id="shiftError"  style="display:none">{{ trans('entities/subtasks.fillFields') }}</p>
        </div>
    </div>
</div>


@if(isset($showVolunteers) && $showVolunteers)
<div class="row">
    <div class="col-sm-5">
        <p>{{ trans('entities/subtasks.availableVolunteers') }}:</p>
        <select name="from" class="form-control sub_volunteers" id="sub_volunteers" size="8" multiple="multiple">
        </select>
    </div>

    <div class="col-sm-2" style="padding-top:35px;">
        <button type="button" id="sub_volunteers_rightAll" class="btn btn-block"><i
                class="glyphicon glyphicon-forward"></i>
        </button>
        <button type="button" id="sub_volunteers_rightSelected" class="btn btn-block"><i
                class="glyphicon glyphicon-chevron-right"></i></button>
        <button type="button" id="sub_volunteers_leftSelected" class="btn btn-block"><i
                class="glyphicon glyphicon-chevron-left"></i></button>
        <button type="button" id="sub_volunteers_leftAll" class="btn btn-block"><i
                class="glyphicon glyphicon-backward"></i>
        </button>
    </div>

    <div class="col-sm-5">
        <p>{{ trans('entities/subtasks.assignedVolunteers') }}:</p>
        <select name="to" id="sub_volunteers_to" class="form-control" size="8" multiple="multiple">
        </select>
    </div>
</div>

<div class="row top-margin ctaVolunteers">
    <div class="col-md-12">
        <p>{{ trans('entities/subtasks.interestedVolunteers') }}:</p>
        <table class="table table-condensed table-bordered ">
            <thead>
            <th>{{ trans('entities/subtasks.volunteer') }}</th>
            <th>{{ trans('entities/subtasks.info') }}</th>
            <th>{{ trans('entities/subtasks.comments') }}</th>
            <th>{{ trans('entities/subtasks.actions') }}</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


@section('footerScripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("#editShift #sub_volunteers").multiselect();
    });
</script>
@append

@endif
