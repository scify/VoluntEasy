<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="volunteersModal"
     aria-labelledby="actionModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">{{ trans('entities/volunteers.addVolunteers') }}</h4>
            </div>
            <div class="modal-body">
                @if(sizeof($allVolunteers)>0)
                <select class="js-states form-control" id="volunteerList" multiple="multiple" tabindex="-1"
                        style="display: none; width: 100%">
                    @foreach($allVolunteers as $volunteer)
                    <option value="{{ $volunteer->id }}" {{ in_array($volunteer->id, $active->volunteers->lists('id')->all()) ? 'selected' : '' }}>{{$volunteer->name.' '.$volunteer->last_name}}</option>
                    @endforeach
                </select>
                @else
                <h3>{{ trans('entities/volunteers.noVolunteersAvailable') }}</h3>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="saveVolunteers" data-id="{{ $active->id }}">{{ trans('default.save') }}</button>
            </div>
        </div>
    </div>
</div>
