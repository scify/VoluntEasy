<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="editShift" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/subtasks.editShift') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['id' => 'editShiftForm', 'method' => 'POST', 'action' => ['ShiftController@update']]) !!}

                <input type="hidden" name="shiftId" class="shiftId" value="">
                @include('main.tasks.modals._shift_form', ['parentId' => '#editSubTask', 'showVolunteers' => true])

            </div>
            <div class="modal-footer">
                {!! Form::submit(trans('default.save') , ['class' => 'btn btn-success', 'id' => 'updateShift']) !!}
                <button type="button" class="btn btn-danger" id="deleteShift">{{ trans('default.delete') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
