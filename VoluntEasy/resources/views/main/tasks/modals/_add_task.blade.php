<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="addTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/tasks.addTask') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'createTask', 'method' => 'POST', 'action' => ['TaskController@store']]) !!}

                @include('main.tasks.modals._task_form')

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success', 'id' => 'storeTask']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
