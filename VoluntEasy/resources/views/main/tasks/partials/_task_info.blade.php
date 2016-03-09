<div class="taskInfo" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <h3>Στοιχεία task</h3>

            <div class="padding">
            <p><strong>Όνομα:</strong> <span class="name"></span></p>

            <p><strong>Λήγει στις:</strong> <span class="due_date"></span></p>

            <p><strong>Προτεραιότητα:</strong> <span class="priority"></span></p>

            <p><strong>Περιγραφή:</strong> <span class="description"></span></p>
            </div>
        </div>

    </div>
    @if($isPermitted)
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-success editTask" data-task-id="">Επεξεργασία</button>
            <button type="button" class="btn btn-danger deleteTask" data-task-id="">Διαγραφή</button>
        </div>
    </div>
        @endif
</div>
