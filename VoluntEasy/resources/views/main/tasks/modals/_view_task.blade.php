<<<<<<< HEAD
<!-- Modal -->
<div class="modal fade scrollable tabbedModal" id="viewTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
=======
<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade scrollable tabbedModal" id="viewTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
>>>>>>> cf0a9fae55543a318ff16a2faadc1ae79e97d69d
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/tasks.addSubtask') }}</h4>
            </div>
            <div class="modal-body">
<<<<<<< HEAD
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="tabs-left" role="tabpanel">
                            <h4>Επιλογές</h4>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#taskDetails" role="tab"
                                                                          data-toggle="tab">Task
                                        details</a></li>
                                <li role="presentation"><a href="#taskShifts" role="tab" data-toggle="tab">Shifts</a>
                                </li>
                                <li role="presentation"><a href="#taskChecklist" role="tab" data-toggle="tab">To-Do</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active fade in" id="taskDetails">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            {!! Form::model(null, ['id' => 'editTaskForm', 'method' => 'POST', 'action'
                                            =>
                                            ['TaskController@update']]) !!}

                                            @include('main.tasks.modals._task_form', ['mode' => 'edit'])

                                            {{-- {!! Form::submit( trans('default.save') , ['class' => 'btn btn-success
                                            edit', 'id' => 'updateTask']) !!} --}}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="taskShifts">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            @include('main.tasks.modals._shift_form', ['mode' => 'edit'])
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="taskChecklist">
                                    <div class="row">
                                        <div class="col-sm-10 col-md-10 col-lg-10">
                                            <h4><i class="fa fa-check-square-o"></i> To-do <br/>
                                                <small>{{ trans('entities/subtasks.toDoExplained') }}</small>
                                            </h4>

                                            <form action="javascript:void(0);">
                                                <input type="text" class="form-control add-task"
                                                       placeholder="{{ trans('entities/subtasks.newToDo') }}"
                                                       data-mode="task">
                                            </form>
                                            <div class="todo-list">

                                            </div>
                                        </div>
                                    </div>
                                </div>
=======

                <div class="row">
                    <div class="row-height">
                        <div class="col-md-2 col-height tabs">

                            <p class="active"><a href="#task-details">Task details</a></p>

                            <p><a href="#shifts" data-toggle="tab">Shifts</a></p>

                            <p><a href="#to-do" data-toggle="tab">To-Do</a></p>
                        </div>
                        <div class="col-md-9 col-height">
                            <div class="active" id="task-details">
                                {!! Form::model(null, ['id' => 'editTaskForm', 'method' => 'POST', 'action' =>
                                ['TaskController@update']]) !!}

                                @include('main.tasks.modals._task_form', ['mode' => ''])
                                {!! Form::submit( trans('default.save') , ['class' => 'btn btn-success edit', 'id' =>
                                'updateTask']) !!}
                                <button type="button" class="btn btn-danger" id="deleteTask">{{ trans('default.delete')
                                    }}
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{
                                    trans('default.close') }}
                                </button>
                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane" id="shifts">
                                <p>Data 2.</p>
                            </div>
                            <div class="tab-pane" id="to-do">
                                <p>Data 2.</p>
>>>>>>> cf0a9fae55543a318ff16a2faadc1ae79e97d69d
                            </div>
                        </div>
                    </div>
                </div>


            </div>
<<<<<<< HEAD

=======
>>>>>>> cf0a9fae55543a318ff16a2faadc1ae79e97d69d
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}
                </button>
                {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success store', 'id' =>
                'storeSubTask'])
                !!}
                {!! Form::close() !!}
            </div>
<<<<<<< HEAD

=======
>>>>>>> cf0a9fae55543a318ff16a2faadc1ae79e97d69d
        </div>
    </div>
</div>
