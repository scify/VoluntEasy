<!-- Modal -->
<div class="modal fade scrollable tabbedModal" id="viewSubtask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/subtasks.info') }}</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="tabs-left" role="tabpanel">
                            <h4>{{ trans('entities/subtasks.menu') }}</h4>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#subtaskDetails" role="tab"
                                                                          data-toggle="tab">{{ trans('entities/subtasks.taskDetails') }}</a></li>
                                <li role="presentation"><a href="#subtaskShifts" role="tab" data-toggle="tab">{{ trans('entities/subtasks.shifts') }}</a>
                                </li>
                                <li role="presentation"><a href="#subtaskChecklist" role="tab" data-toggle="tab">{{ trans('entities/subtasks.toDo') }}</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active fade in" id="subtaskDetails">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            {!! Form::model(null, ['id' => 'editSubTaskForm', 'method' => 'POST', 'action'
                                            =>
                                            ['SubTaskController@update']]) !!}

                                            @include('main.tasks.modals._subtask_form', ['mode' => 'edit'])

                                            {!! Form::submit( trans('default.save') , ['class' => 'btn btn-success
                                            edit pull-right', 'id' => 'updateSubTask']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="subtaskShifts">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            @include('main.tasks.modals._shifts', ['mode' => 'edit'])
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="subtaskChecklist">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <h4><i class="fa fa-check-square-o"></i> To-do <br/>
                                                <small>{{ trans('entities/subtasks.toDoExplained') }}</small>
                                            </h4>

                                            <form action="javascript:void(0);">
                                                <input type="text" class="form-control add-task"
                                                       placeholder="{{ trans('entities/subtasks.newToDo') }}"
                                                       data-mode="subtask">
                                            </form>
                                            <div class="todo-list">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
