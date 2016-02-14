<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="editSubTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη sub-task</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'addSubTask', 'method' => 'POST', 'action' =>
                ['TaskController@addSubTask']]) !!}
               <input type="hidden" name="taskId" id="taskId" value="">
               <input type="hidden" name="actionId" id="actionId" value="{{$action->id}}">

                <div class="row">
                    <div class="col-md-8">
                        {!! Form::formInput('name', 'Όνομα sub-task:', $errors, ['class' => 'form-control']) !!}

                        <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
                    </div>
                    <div class="col-md-4">
                        <label>Προτεραιότητα:</label>
                        <select class="form-control m-b-sm" id="priorities" name="priority">
                            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
                            <option value="3">{{ trans($lang.'priority-high')}}</option>
                            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
                            <option value="1">{{ trans($lang.'priority-low')}}</option>
                        </select>

                        <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::formInput('description', 'Περιγραφή sub-task:', $errors,
                            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x3']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'storeSubTask']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('footerScripts')

<script>
/*
    $("#storeSubTask").click(function () {
        if ($("#name").val() == null || $("#name").val() == '')
            $("#name_err").show();
        else {
            $("#name_err").hide();

            $.ajax({
                url: $("body").attr('data-url') + "/actions/task/create",
                method: 'GET',
                data: $("#createTask").serialize(),
                success: function (result) {
                    location.reload();
                }
            });
        }
    });
*/
</script>

@append
