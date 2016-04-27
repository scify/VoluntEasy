<!-- Modal -->
<div class="modal fade" id="taskChecklist" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/tasks.addChecklist') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row todos">
                    <div class="col-md-12">
                        <h4><i class="fa fa-check-square-o"></i> To-do <br/>
                            <small>{{ trans('entities/subtasks.toDoExplained') }}</small>
                        </h4>

                        <form action="javascript:void(0);">
                            <input type="text" class="form-control add-task" placeholder="{{ trans('entities/subtasks.newToDo') }}" data-mode="task">
                        </form>
                        <div class="todo-list">

                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default closeAndRefresh" data-dismiss="modal">{{ trans('default.close') }}</button>
            </div>
        </div>
    </div>
</div>
