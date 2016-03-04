<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="addWorkDate" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη ημέρας/ώρας</h4>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['id' => 'addWorkDateForm', 'method' => 'POST', 'action' => ['WorkDateController@store']]) !!}

                @include('main.tasks.modals._work_date_form', ['parentId' => '#editSubTask'])

            </div>
            <div class="modal-footer">
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'storeWorkDate']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
