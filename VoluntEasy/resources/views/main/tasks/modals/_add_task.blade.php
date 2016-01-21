<?php $lang = "default."; ?>

<!-- Modal -->
<div class="modal fade" id="addTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη task στη δράση</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'createTask', 'method' => 'POST', 'action' => ['TaskController@store']]) !!}
                <input type="hidden" name="taskId" id="taskId">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::formInput('name', 'Όνομα task:', $errors, ['class' => 'form-control',
                            'required' => 'true']) !!}
                            <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p>Κατάσταση:</p>
                            <input type="radio" name="status" id="complete" value="complete">
                            <label for="complete">Ολοκληρωμένο</label><br/>
                            <input type="radio" name="status" id="incomplete" value="incomplete" checked>
                            <label for="incomplete">Μη ολοκληρωμένο</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Προτεραιότητα:</label>
                        <select class="form-control m-b-sm" id="priorities" name="priority">
                            <option value="4">{{ trans($lang.'priority-urgent')}}</option>
                            <option value="3">{{ trans($lang.'priority-high')}}</option>
                            <option value="2" selected>{{ trans($lang.'priority-medium')}}</option>
                            <option value="1">{{ trans($lang.'priority-low')}}</option>
                        </select>

                        <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::formInput('comments', 'Περιγραφή:', $errors,
                            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'saveAction']) !!}
                {!! Form::close() !!}
                </button>
            </div>
        </div>
    </div>
</div>

@section('footerScripts')

<script>

    /*
    $("#storeTask").click(function () {
        console.log('clicky')
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
