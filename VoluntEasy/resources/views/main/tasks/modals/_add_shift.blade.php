<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="addShift" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/subtasks.addShift') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::model(null, ['id' => 'addShiftForm', 'method' => 'POST', 'action' => ['ShiftController@store']]) !!}

                @include('main.tasks.modals._shift_form', ['parentId' => '#editSubTask'])

            </div>
            <div class="modal-footer">
                {!! Form::submit( trans('default.save'), ['class' => 'btn btn-success', 'id' => 'storeShift']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
