<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade scrollable tabbedModal" id="viewTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/tasks.addSubtask') }}</h4>
            </div>
            <div class="modal-body">

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
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}
                </button>
                {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success store', 'id' =>
                'storeSubTask'])
                !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
