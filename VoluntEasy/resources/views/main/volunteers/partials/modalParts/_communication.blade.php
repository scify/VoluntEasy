<h4>{{ $volunteer->name }} {{ $volunteer->last_name }}</h4>

<h5>{{ trans('entities/volunteers.communicationWays') }}: </h5>

<p>{{ trans('entities/volunteers.email') }}: {{ $volunteer->email=='' ? '-' : $volunteer->email }}
    @if ($volunteer->comm_method_id==1) <i class="fa fa-star" data-toggle="tooltip"
                                           title="{{ trans('entities/volunteers.preferredContactWay') }}"></i> @endif </p>

@if($volunteer->cell_tel!='')
<p>{{ trans('entities/volunteers.cellTel') }}: {{ $volunteer->cell_tel=='' ? '-' : $volunteer->cell_tel }}
    @if($volunteer->comm_method_id==4) <i class="fa fa-star" data-toggle="tooltip"
                                          title="{{ trans('entities/volunteers.preferredContactWay') }}"></i> @endif </p>
@endif

@if($volunteer->work_tel!='')
<p>{{ trans('entities/volunteers.workTel') }}: {{ $volunteer->work_tel=='' ? '-' : $volunteer->work_tel}}
    @if ($volunteer->comm_method_id==3) <i class="fa fa-star" data-toggle="tooltip"
                                           title="{{ trans('entities/volunteers.preferredContactWay') }}"></i> @endif </p>
@endif


@if($volunteer->home_tel!='')
<p>{{ trans('entities/volunteers.homeTel') }}: {{ $volunteer->home_tel=='' ? '-' : $volunteer->home_tel }}
    @if ($volunteer->comm_method_id==2) <i class="fa fa-star" data-toggle="tooltip"
                                           title="{{ trans('entities/volunteers.preferredContactWay') }}"></i> @endif </p>
@endif

@if($volunteer->fax!='')
<p>{{ trans('entities/volunteers.fax') }}: {{ $volunteer->fax=='' ? '-' : $volunteer->fax }}</p>
@endif

<hr/>

@if($step->statuses[0]->status->description=='Incomplete')
{!! Form::formInput('comments', trans('entities/volunteers.comments').':', $errors,
['class' => 'form-control', 'type' => 'textarea', 'placeholder' => $step->comments, 'id' =>
'stepTextarea-'.$step->statuses[0]->id, 'value' => $step->statuses[0]->comments]) !!}
@else
<h4>{{ trans('entities/volunteers.comments') }}:</h4>
@if($step->statuses[0]->comments==null || $step->statuses[0]->comments=='')
<p>-</p>
@else
<p>{{ $step->statuses[0]->comments }}</p>
@endif
@endif
