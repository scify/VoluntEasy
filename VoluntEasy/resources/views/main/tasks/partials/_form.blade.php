<input type="hidden" name="actionId" id="actionId" value="{{$actionId}}">
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
            <input type="radio" name="status" id="complete"
                   value="complete" {{ isset($task) && $task->isComplete ? 'checked' :'' }}>
            <label for="complete">Ολοκληρωμένο</label><br/>
            <input type="radio" name="status" id="incomplete"
                   value="incomplete" {{ !isset($task) || (isset($task) && !$task->isComplete) ? 'checked' :'' }}>
            <label for="incomplete">Μη ολοκληρωμένο</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            {!! Form::formInput('description', 'Περιγραφή:', $errors,
            ['class' => 'form-control', 'type' => 'textarea', 'size' => '2x5']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4>Εθελοντές</h4>
        <p>
            <small>Προσθέστε εθελοντές στο task και μια περιγραφή της εργασίας που θα εκτελέσουν.</small>
        </p>

        @if(isset($task) && sizeof($task->volunteers)>0)
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Όνομα εθελοντή</th>
                    <th>Περιγραφή εργασίας</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        @else
            <p>Δεν έχουν προστεθεί εθελοντές στο task.</p>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group text-right">
            <button type="button" class="btn btn-info btn-sm " data-toggle="modal"
                    data-target="#addVolunteer">
                Προσθήκη εθελοντή
            </button>
            {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'saveAction']) !!}
        </div>
    </div>
</div>
