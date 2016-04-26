<div class="taskInfo" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ trans('entities/tasks.info') }}</h3>

            <div class="padding">

                <h4><span class="priority"></span>
                    <strong><span class="name"></span></strong>, {{ trans('entities/tasks.expires') }} <span class="due_date"></span>
                </h4>
                <p><span class="description"></span></p>

                <p class="assignedTo"></p>

            </div>
        </div>

    </div>
    @if($isPermitted)
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-info addTaskShift" data-subtask-id="" data-task-id=""
                    title="{{ trans('default.addShift') }}"><i class="fa fa-calendar"></i>
            </button>
            <button type="button" class="btn btn-info viewTaskChecklist" data-subtask-id="" data-task-id=""
                    title="{{ trans('default.addChecklist') }}"><i class="fa fa-check-square-o"></i>
            </button>
            <button type="button" class="btn btn-success editTask" data-task-id="">{{ trans('default.edit') }}</button>
            <button type="button" class="btn btn-danger deleteTask" data-task-id="">{{ trans('default.delete') }}
            </button>
        </div>
    </div>
    @endif
</div>
