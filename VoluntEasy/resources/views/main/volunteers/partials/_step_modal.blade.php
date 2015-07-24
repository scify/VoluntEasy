<!-- Modal -->
<div class="modal fade" id="step-{{ $step->statuses[0]->id }}" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Βήμα {{ $step->step_order }}: {{ $step->description }}</h4>

                <small>
                    @if($step->statuses[0]->status->description=='Incomplete')
                    <span class="incomplete"><em>Βήμα μη ολοκληρωμένο</em></span>
                    @else
                    <span class="complete"><em>Βήμα ολοκληρωμένο</em></span>
                    @endif
                </small>
            </div>
            <div class="modal-body">
                <!-- Communication step -->
                @if($step->type=='Communication')
                    @include('main.volunteers.partials.modalParts._communication')

                <!-- Interview step -->
                @elseif($step->type=='Interview')
                    @include('main.volunteers.partials.modalParts._interview')

                <!-- Assignment step -->
                @elseif($step->type=='Assignment')
                   @include('main.volunteers.partials.modalParts._assignment')
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>

                @if($step->statuses[0]->status->description=='Incomplete')
                    @if($step->type!='Assignment')
                    <button type="button" class="btn btn-primary saveStep" data-id="{{ $step->statuses[0]->id }}">
                        Αποθήκευση
                    </button>
                    <button type="button" class="btn btn-success completeStep" data-id="{{ $step->statuses[0]->id }}"
                            data-type="{{ $step->type }}">
                        Ολοκλήρωση
                    </button>
                    @else
                    <button type="button" class="btn btn-success assignToUnit" data-id="{{ $step->statuses[0]->id }}"
                            data-volunteer-id="{{ $volunteer->id }}" data-type="{{ $step->type }}">
                        Ολοκλήρωση
                    </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
