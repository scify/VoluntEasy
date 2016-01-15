<div class="modal fade" id="add-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Προσθήκη ρόλου</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::formInput('role_id', 'Ρόλος:', $errors, ['class' => 'form-control',
                            'type' => 'select', 'value' => $roles]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id="units" style="display: none;">
                            <p>Οργανωτικές Μονάδες:</p>
                            <select class="js-states form-control" id="unitList" multiple="multiple"
                                    name="unitsSelect[]"
                                    tabindex="-1"
                                    style=" width: 100%">

                                @foreach($units as $unit_id => $unit)
                                <option value="{{ $unit->id }}" name="unit-{{$unit->id}}">{{ $unit->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="actions" style="display: none;">
                            <p>Δράσεις:</p>
                            <select class="js-states form-control" id="actionList" multiple="multiple"
                                    name="unitsSelect[]"
                                    tabindex="-1"
                                    style="width: 100%">

                                @foreach($actions as $action)
                                <option value="{{ $action->id }}" name="action-{{$action->id}}">{{
                                    $action->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-success available">
                    Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


