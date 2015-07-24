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

                <h4>{{ $volunteer->name }} {{ $volunteer->last_name }}</h4>

                <h5>Τρόποι επικοινωνίας: </h5>

                <p>Email: {{ $volunteer->email=='' ? '-' : $volunteer->email }}
                    @if ($volunteer->comm_method_id==1) <i class="fa fa-star" data-toggle="tooltip"
                                                           title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif </p>

                @if($volunteer->cell_tel!='')
                <p>Κινητό: {{ $volunteer->cell_tel=='' ? '-' : $volunteer->cell_tel }}
                    @if($volunteer->comm_method_id==4) <i class="fa fa-star" data-toggle="tooltip"
                                                          title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif </p>
                @endif

                @if($volunteer->work_tel!='')
                <p>Τηλέφωνο εργασίας: {{ $volunteer->work_tel=='' ? '-' : $volunteer->work_tel}}
                    @if ($volunteer->comm_method_id==3) <i class="fa fa-star" data-toggle="tooltip"
                                                           title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif </p>
                @endif


                @if($volunteer->home_tel!='')
                <p>Τηλέφωνο οικίας: {{ $volunteer->home_tel=='' ? '-' : $volunteer->home_tel }}
                    @if ($volunteer->comm_method_id==2) <i class="fa fa-star" data-toggle="tooltip"
                                                           title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif </p>
                @endif

                @if($volunteer->fax!='')
                <p>Φαξ: {{ $volunteer->fax=='' ? '-' : $volunteer->fax }}</p>
                @endif

                <hr/>

                @if($step->statuses[0]->status->description=='Incomplete')
                {!! Form::formInput('comments', 'Σχόλια: ', $errors,
                ['class' => 'form-control', 'type' => 'textarea', 'placeholder' => $step->comments, 'id' =>
                'stepTextarea-'.$step->statuses[0]->id, 'value' => $step->statuses[0]->comments]) !!}
                @else
                <h4>Σχόλια:</h4>
                     @if($step->statuses[0]->comments==null || $step->statuses[0]->comments=='')
                     <p>-</p>
                     @else
                    <p>{{ $step->statuses[0]->comments }}</p>
                    @endif
                    @endif

                @elseif($step->type=='Interview')
                <!-- Interview step -->

                @if($step->statuses[0]->status->description=='Incomplete')
                {!! Form::formInput('comments', 'Σχόλια: ', $errors,
                ['class' => 'form-control', 'type' => 'textarea', 'placeholder' => $step->comments, 'id' =>
                'stepTextarea-'.$step->statuses[0]->id, 'value' => $step->statuses[0]->comments]) !!}
                @else
                <h4>Σχόλια:</h4>
                    @if($step->statuses[0]->comments==null || $step->statuses[0]->comments=='')
                     <p>-</p>
                    @else
                    <p>{{ $step->statuses[0]->comments }}</p>
                    @endif
                @endif

                @elseif($step->type=='Assignment')
                <!-- Assignment step -->
                @if($step->statuses[0]->status->description=='Incomplete')

                @if(sizeof($unit->actions)>0)

                {!! Form::formInput('actionSelect', 'Ανάθεση στη δράση:', $errors, ['class' => 'form-control',
                'type' => 'select', 'id' => 'actionSelect-'.$step->statuses[0]->id, 'value' =>
                $unit->actions->lists('description', 'id')]) !!}
                @else
                {!! Form::formInput('', 'Ανάθεση στη μονάδα*:', $errors, ['class' => 'form-control',
                'type' => 'select', 'id' => 'unitSelect-'.$step->statuses[0]->id, 'value' =>$unit->availableUnits, 'data-parent' => $unit->id]) !!}
                <p class="text-right">
                    <small><em>*Μπορείτε να αναθέσετε τον εθελοντή μόνο στις άμεσες υπομονάδες της μονάδας σας.</em>
                    </small>
                </p>

                @endif
                @else
                @if(sizeof($unit->actions)>0)
                <p>Ανατέθηκε στη δράση <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
                @else
                <p>Ανατέθηκε στη μονάδα <strong>{{ $step->statuses[0]->comments}}</strong>.</p>
                @endif
                @endif
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
