@extends('default')

@section('title')
Reports
@stop
@section('pageTitle')
Reports
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Καταστάσεις εθελοντών ανά μήνα</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                 @include('main.reports._volunteersByMonth')
            </div>
        </div>
    </div>
</div>
@stop



