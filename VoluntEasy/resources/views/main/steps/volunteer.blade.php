@extends('default')

@section('title')
Προβολή Βημάτων Εθελοντή
@stop

@section('pageTitle')
Προβολή Βημάτων Εθελοντή
@stop


@section('bodyContent')

<div class="row">


    @foreach($volunteer->units as $unit)

    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{$unit->description}}</h2>

                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">


                        @foreach($unit->steps as $step)

                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-grey panel-steps">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p>{{$step->step_order}}. {{$step->description}}</p>
                                        <span class="info-box-title">
                                            @if($step->step_order==1)
                                            <i class="fa fa-envelope"></i> <a href="mailto:{{ $volunteer->email }}">{{$volunteer->email }}</a> |
                                            <i class="fa fa-home"></i> {{ $volunteer->address }} |
                                            <i class="fa fa-phone"></i> {{ $volunteer->phone_number }}
                                            @elseif($step->step_order==2)
                                            <i class="fa fa-clock-o"></i> 25/07/2015, 17:30 |
                                            <i class="fa fa-map-marker"></i> Athens
                                            @elseif($step->step_order==3)
                                            <button class="btn btn-group-sm btn-info">Unit</button>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fa fa-circle {{sizeof($step->status)==0 ||
                                        (sizeof($step->status)>0 && $step->status[0])=='Inactive' ? 'inactive' : 'active'}}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </div>

    @endforeach

</div>


@stop


@section('footerScripts')
<script>

</script>
@stop
