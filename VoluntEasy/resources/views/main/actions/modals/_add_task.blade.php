<!-- Modal -->
<div class="modal fade" id="addTask" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη αρμοδιότητας στη δράση</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'POST', 'action' => ['TaskController@store']]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::formInput('task_name', 'Αρμοδιότητα:', $errors, ['class' => 'form-control',
                            'required'
                            =>
                            'true']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::formInput('task_date', 'Ημέρα:', $errors, ['class' => 'form-control datepicker',
                            'required'
                            =>
                            'true'])
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::formInput('task_time', 'Ώρα:', $errors, ['class' => 'form-control', 'required'
                            =>
                            'true'])
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::formInput('volunteer_id', 'Εθελοντής:', $errors, ['class' => 'form-control'])
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::formInput('status', 'Κατάσταση:', $errors, ['class' => 'form-control', 'type' =>
                            'select', 'value' => $taskStatuses]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::formInput('working_hours', 'Ώρες Εργασίας:', $errors, ['class' => 'form-control'])
                            !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::formInput('comments', 'Σχόλια:', $errors,
                            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-success assignToAction">Αποθήκευση
                </button>
            </div>
        </div>
    </div>
</div>

@section('footerScripts')

<script>
    $('#task_date').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('#task_time').timepicker();

</script>

@append
