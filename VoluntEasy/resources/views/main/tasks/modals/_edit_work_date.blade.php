<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="editWorkDate" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Επεξεργασία ημέρας/ώρας</h4>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['id' => 'editWorkDateForm', 'method' => 'POST', 'action' => ['WorkDateController@update']]) !!}

                <input type="hidden" name="workdateId" class="workdateId" value="">
                @include('main.tasks.modals._work_date_form', ['parentId' => '#editSubTask', 'showVolunteers' => true])

            </div>
            <div class="modal-footer">
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'updateWorkDate']) !!}
                <button type="button" class="btn btn-danger" id="deleteWorkDate">Διαγραφή</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
