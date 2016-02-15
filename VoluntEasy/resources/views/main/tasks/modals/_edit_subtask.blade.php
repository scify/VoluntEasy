<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="editSubTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Επεξεργασία sub-task</h4>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['id' => 'editSubTaskForm', 'method' => 'POST', 'action' => ['TaskController@updateSubTask']]) !!}

                <input type="hidden" name="subTaskId" id="subTaskId" value="">

                @include('main.tasks.modals._subtask_form')

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'updateSubTask']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
