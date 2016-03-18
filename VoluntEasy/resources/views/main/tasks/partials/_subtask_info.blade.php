<div class="subTaskInfo" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ trans('entities/subtasks.info') }}</h3>

            <div class="padding">
                <p><strong>{{ trans('entities/subtasks.name') }}:</strong> <span class="name"></span></p>

                <p><strong>{{ trans('entities/subtasks.expiresAt') }}:</strong> <span class="due_date"></span></p>

                <p><strong>{{ trans('entities/subtasks.priority') }}:</strong> <span class="priority"></span></p>

                <p><strong>{{ trans('entities/subtasks.description') }}:</strong> <span class="description"></span></p>
            </div>

            <h3>{{ trans('entities/subtasks.workDateDiagram') }}</h3>

            <div class="workDatesInfo">
                <p class="padding noWorkDates" style="display:none;"><em>{{ trans('entities/subtasks.noWorkDateDiagram') }}</em></p>
                <table class="table table-condensed table-bordered workDatesTable">
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
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-info addWorkDate" data-subtask-id="" data-task-id=""
                        title="{{ trans('default.addWorkDate') }}"><i class="fa fa-calendar"></i>
                </button>
                <button type="button" class="btn btn-success editSubTask" data-subtask-id="" data-task-id=""
                        title="{{ trans('default.edit') }}"><i class="fa fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger deleteSubTask" data-subtask-id="" title="{{ trans('default.delete') }}"><i
                            class="fa fa-trash"></i></button>
            </div>
        </div>
    @endif
</div>
