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
