<div class="col-md-4">
    <div class="form-group">
        @if (isset($volunteer))
        {!! Form::formInput('work_status_id', 'Εργασιακή κατάσταση:', $errors, ['class' => 'form-control',
        'type' => 'select', 'value' => $workStatuses, 'key' => $volunteer->work_status_id]) !!}
        @else
        {!! Form::formInput('work_status_id', 'Εργασιακή κατάσταση:', $errors, ['class' => 'form-control',
        'type' => 'select', 'value' => $workStatuses]) !!}
        @endif
    </div>
    <div class="form-group">
        {!! Form::formInput('work_description', 'Εργασία:', $errors, ['class' => 'form-control', 'type' =>
        'textarea', 'placeholder' => 'Περιγράψτε τη θέση σας στην παρούσα ή πιο πρόσφατη εργασία.']) !!}
    </div>

    <div class="form-group">
        {!! Form::formInput('participation_reason', 'Λόγος συμμετοχής:', $errors, ['class' => 'form-control',
        'required' => 'true', 'type' => 'textarea', 'placeholder' => 'Περιγράψτε τους λόγους που θέλετε να
        γίνετε εθελοντής.']) !!}
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        {!! Form::formInput('participation_actions', 'Εθελοντική οργάνωση:', $errors, ['class' =>
        'form-control',
        'type' => 'textarea', 'placeholder' => 'Εαν ανήκετε ή ανήκατε σε κάποιες εθελοντικές οργανώσεις ποιο
        ήταν το αντικείμενο τους και για πόσο χρονικό διάστημα είχατε συμετοχή.']) !!}
    </div>
    <div class="form-group">
        {!! Form::formInput('participation_previous', 'Εθελοντικές δράσεις:', $errors, ['class' =>
        'form-control', 'type' => 'textarea', 'placeholder' => 'Εαν έχετε πάρει μέρος σε εθελοντικές δράσεις στο
        παρελθόν περιγράψτε ποιο ήταν/είναι το αντικείμενο.']) !!}
    </div>
</div>
