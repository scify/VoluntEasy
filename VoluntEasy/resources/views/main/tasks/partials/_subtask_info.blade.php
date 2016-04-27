<div class="subTaskInfo" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ trans('entities/subtasks.subtaskInfo') }}</h3>

            <div class="padding">
                <h4><span class="priority"></span>
                    <strong><span class="name"></span></strong><span class="due_date"></span>
                </h4>

                <p><span class="description"></span></p>

                <p class="assignedTo"></p>
            </div>


            <h3>{{ trans('entities/subtasks.shiftDiagram') }}</h3>

            <div class="shiftInfo">
                <p class="padding noShifts" style="display:none;"><em>{{ trans('entities/subtasks.noShiftDiagram')
                        }}</em></p>
                <table class="table table-condensed table-bordered shiftsTable">
                    <thead>
                    <th>{{ trans('entities/subtasks.description') }}</th>
                    <th>{{ trans('entities/subtasks.date') }}</th>
                    <th>{{ trans('entities/subtasks.time') }}</th>
                    <th>{{ trans('entities/subtasks.volunteerSum') }}</th>
                    @if($isPermitted)
                    <td></td>
                    @endif
                    </thead>
                    <tbody class="body">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if($isPermitted)
                        <td></td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>

            <h3>To-do</h3>

            <div class="padding">
                <div class="todo-list">
                </div>
            </div>
        </div>

    </div>
    @if($isPermitted)
    <div class="row top-margin">
        <div class="col-md-6">
            <button type="button" class="btn btn-info addSubtaskShift" data-subtask-id="" data-task-id=""
                    title="{{ trans('default.addShift') }}"><i class="fa fa-calendar"></i>
            </button>
            <button type="button" class="btn btn-info viewSubtaskChecklist" data-subtask-id="" data-task-id=""
                    title="{{ trans('default.addChecklist') }}"><i class="fa fa-check-square-o"></i>
            </button>
        </div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-success editSubTask" data-subtask-id="" data-task-id=""
                    title="{{ trans('default.edit') }}"><i class="fa fa-edit"></i>
            </button>
            <button type="button" class="btn btn-danger deleteSubTask" data-subtask-id=""
                    title="{{ trans('default.delete') }}"><i
                    class="fa fa-trash"></i></button>
        </div>
    </div>
    @endif
</div>
