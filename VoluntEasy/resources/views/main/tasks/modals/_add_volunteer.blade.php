<?php $lang = "default."; ?>

        <!-- Modal -->
<div class="modal fade" id="addVolunteer" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη εθελοντή σε task</h4>
            </div>
            <div class="modal-body">

                @if(sizeof($volunteers)>0)

                    <p>Επιλέξτε έναν από τους εθελοντές που ανήκουν στη μονάδα {{$unitName}} και είναι διαθέσιμοι προς ανάθεση.</p>

                    {!! Form::open(['id' => 'addVolunteer', 'method' => 'POST', 'action' => ['TaskController@addVolunteer']]) !!}
                    <input type="hidden" name="taskId" id="taskId" value="{{$task->id}}">

                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::formInput('volunteer_id', 'Όνομα εθελοντή:', $errors, ['class' => 'form-control', 'type' => 'select', 'value' => $volunteers]) !!}

                            <p class="text-danger" id="name_err" style="display:none;">Συμπληρώστε το πεδίο.</p>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::formInput('job_descr', 'Περιγραφή εργασίας:', $errors,
                                ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x2']) !!}
                            </div>
                        </div>
                    </div>

                @else
                    <p>Δεν υπάρχουν εθελοντές στη μονάδα {{$unitName}}.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                @if(sizeof($volunteers)>0)
                    {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'saveAction']) !!}
                    {!! Form::close() !!}

                @endif

            </div>
        </div>
    </div>
</div>

@section('footerScripts')

    <script>

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

    </script>

@append
