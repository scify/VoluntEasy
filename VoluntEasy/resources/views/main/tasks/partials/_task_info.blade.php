<div class="taskInfo" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ trans('entities/tasks.info') }}</h3>

            <div class="padding">
            <p><strong>{{ trans('entities/tasks.name') }}:</strong> <span class="name"></span></p>

            <p><strong>{{ trans('entities/tasks.expires') }}:</strong> <span class="due_date"></span></p>

            <p><strong>{{ trans('entities/tasks.priority') }}:</strong> <span class="priority"></span></p>

            <p><strong>{{ trans('entities/tasks.description') }}:</strong> <span class="description"></span></p>
            </div>
        </div>

    </div>
    @if($isPermitted)
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-success editTask" data-task-id="">{{ trans('default.edit') }}</button>
            <button type="button" class="btn btn-danger deleteTask" data-task-id="">{{ trans('default.delete') }}</button>
        </div>
    </div>
        @endif
</div>
