<!-- Select unit modal -->
<div class="modal fade text-left" id="{{$divId}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Επιλογή μονάδας</h4>
            </div>
            <div class="modal-body">
                @if(sizeof($units)==0)
                <p>Δεν υπάρχει διαθέσιμη υπομονάδα.</p>
                @else
                {!! Form::formInput('', 'Ανάθεση στη μονάδα*:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $units, 'id' => 'moreUnits']) !!}
                <p class="text-right">
                    <small><em>*Μπορείτε να αναθέσετε τον εθελοντή είτε στις άμεσες υπομονάδες των μονάδων σας είτε στις μονάδες όπου είστε υπεύθυνος.</em>
                    </small>
                </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                @if(sizeof($units)>0)
                <button type="button" class="btn btn-success assignToNextUnit"
                        data-volunteer-id="{{ $volunteer->id }}" {{ isset($parentId) ? 'data-parent='.$parentId : '' }}">Αποθήκευση
                </button>
                @endif
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
