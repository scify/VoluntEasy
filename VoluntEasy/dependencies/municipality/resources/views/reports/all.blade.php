@extends('default')

@section('title')
Reports
@stop
@section('pageTitle')
Reports
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές ανά φύλο</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersBySex')
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές ανά ηλικιακή ομάδα</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersByAgeGroup')
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές ανά πόλη</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersByCity')
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές ανά επίπεδο εκπαίδευσης</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersByEducationLevel')
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές ανά ενδιαφέρον</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersByInterest')
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Καταστάσεις εθελοντών ανά μήνα</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersByMonth')
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές ανά δράση</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteersByAction')
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Ώρες απασχόλησης εθελοντών ανά δράση</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('municipality.resources.views.reports._volunteerHoursByAction')
            </div>
        </div>
    </div>
</div>

@stop



