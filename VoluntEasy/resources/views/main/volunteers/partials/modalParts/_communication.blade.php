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
