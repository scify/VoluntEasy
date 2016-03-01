<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="editTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη task στη δράση</h4>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['id' => 'editTaskForm', 'method' => 'POST', 'action' => ['TaskController@update']]) !!}

                @include('main.tasks.modals._task_form')

            </div>
            <div class="modal-footer">
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'storeTask']) !!}
                <button type="button" class="btn btn-danger" id="deleteTask">Διαγραφή</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>