<!-- Select unit modal -->
<div class="modal fade text-left" id="{{$divId}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Επιλογή δράσης</h4>
            </div>
            <div class="modal-body">
                {!! Form::formInput('', 'Ανάθεση στη δράση:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $unit->actions->lists('description', 'id'), 'id' => 'addToAction-'.$unit->id]) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-success assignToAction"
                        data-volunteer-id="{{ $volunteer->id }}" data-unit-id="{{ $unit->id }}">Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->