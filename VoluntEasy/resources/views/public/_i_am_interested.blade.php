<div class="modal fade" tabindex="-1" role="dialog" id="i_am_interested"
     aria-labelledby="actionModal"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Ενδιαφέρομαι για τη δράση {{ $action->description }}</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::formInput('first_name', 'Όνομα:', $errors, ['class' => 'form-control', 'id' =>
              'first_name', 'required' => 'true']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::formInput('last_name', 'Επώνυμο:', $errors, ['class' => 'form-control', 'id' =>
             'last_name', 'required' => 'true']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control', 'id' =>
              'email', 'required' => 'true']) !!}
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p>Ενδιαφέρομαι για τις θέσεις:</p>

                        <div class="form-group">
                            {!! Form::formInput('test', 'Υποδοχή', $errors, ['class' => 'form-control',
                    'type' => 'checkbox', 'checked' => 'false']) !!}
                            {!! Form::formInput('test', 'Υποδοχή', $errors, ['class' => 'form-control',
                    'type' => 'checkbox', 'checked' => 'false']) !!}
                            {!! Form::formInput('test', 'Υποδοχή', $errors, ['class' => 'form-control',
                    'type' => 'checkbox', 'checked' => 'false']) !!}
                        </div>
                    </div>
                </div>
                <p>Είμαι διαθέσιμος:</p>

                <div class="row">
                    <div class="col-md-4">
                        <p>Ημέρα:</p>

                        <div class="form-group">
                            {!! Form::formInput('date', '', $errors, ['class' => 'form-control date']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>Από:</p>

                        <div class="form-group">
                            {!! Form::formInput('time', '', $errors, ['class' => 'form-control time']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>Έως:</p>

                        <div class="form-group">
                            {!! Form::formInput('time', '', $errors, ['class' => 'form-control time']) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p><a href="#"><i class="fa fa-plus-circle"></i> Προσθήκη διαθεσιμότητας</a></p>
                    </div>
                </div>

                {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' => 'textarea',
                        'size' =>
                        '5x5', 'id' => 'comments']) !!}

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="saveVolunteers">Αποθήκευση</button>
            </div>
        </div>
    </div>
</div>


@section('footerScripts')
    <script>
        $('.date').datepicker({
            language: 'el',
            format: 'dd/mm/yyyy',
            autoclose: true
        }).on('changeDate', function (selected) {
            var birthDate = new Date(selected.date.valueOf());
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            //display message that the volunteer is underage
            if (age < 18)
                $(".under18").show();
            else if (age > 18)
                $(".under18").hide();

        });

        $('.time').timepicker({
            lang: {
                'am': ' π.μ.',
                'pm': ' μ.μ.'
            }
        });
    </script>
@append