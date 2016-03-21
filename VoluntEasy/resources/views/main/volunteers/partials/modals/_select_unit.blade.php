<!-- Select unit modal -->
<div class="modal fade text-left" id="{{$divId}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/volunteers.selectUnit') }}</h4>
            </div>
            <div class="modal-body">
                @if(sizeof($units)==0)
                <p>{{ trans('entities/volunteers.noUnitAvailable') }}</p>
                @else
                {!! Form::formInput('', trans('entities/volunteers.assignToUnit').'*:', $errors, ['class' => 'form-control',
                'type' => 'select', 'value' => $units, 'id' => 'moreUnits']) !!}
                <p class="text-right">
                    <small><em>*{{ trans('entities/volunteers.selectUnitExpl') }}</em>
                    </small>
                </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                @if(sizeof($units)>0)
                <button type="button" class="btn btn-success assignToNextUnit"
                        data-volunteer-id="{{ $volunteer->id }}" {{ isset($parentId) ? 'data-parent='.$parentId : '' }}">{{ trans('default.save') }}
                </button>
                @endif
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
