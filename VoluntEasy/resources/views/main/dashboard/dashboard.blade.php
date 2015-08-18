@extends('default')
@section('title')
Αρχική
@stop
@section('pageTitle')
Αρχική
@stop

@section('bodyContent')
<div class="row">
    <div class="col-lg-3 col-md-3">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter"><a href="{{ url('volunteers/new') }}">{{ $new }}</a></p>
                    <span class="info-box-title">ΝΕΟΙ ΕΘΕΛΟΝΤΕΣ</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-leaf"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="counter">{{ $available }}</p>
                        <span class="info-box-title">ΔΙΑΘΕΣΙΜΟΙ ΕΘΕΛΟΝΤΕΣ</span>
                    </div>
                    <div class="info-box-icon">
                        <i class="fa fa-leaf"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $active }}</p>
                            <span class="info-box-title">ΕΝΕΡΓΟΙ ΕΘΕΛΟΝΤΕΣ</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa-leaf"></i>
                        </div>
                    </div>
                </div>
            </div>
    <div class="col-lg-3 col-md-3">
        <div class="panel info-box panel-white">
            <div class="panel-body">
                <div class="info-box-stats">
                    <p class="counter"><a href="{{ url('actions/') }}"> {{ $actions }} </a></p>
                    <span class="info-box-title">ΕΝΕΡΓΕΣ ΔΡΑΣΕΙΣ</span>
                </div>
                <div class="info-box-icon">
                    <i class="fa fa-bullseye"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    @if($isAdmin)
    <div class="col-md-6">
        <div class="panel panel-info smallHeading mini-panel">
            <div class="panel-heading clearfix ">
                <h4 class="panel-title">Νέοι Εθελοντές</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.dashboard._new')
            </div>
        </div>
    </div>
    @endif
    <div class="{{ $isAdmin ? 'col-md-6' : 'col-md-12' }} ">
        <div class="panel panel-warning smallHeading mini-panel">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Υπό Ένταξη Εθελοντές</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.dashboard._pending')
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-success smallHeading mini-panel">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Διαθέσιμοι Εθελοντές</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.dashboard._available')
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary smallHeading mini-panel">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Ενεργοί Εθελοντές</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.dashboard._active')
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default smallHeading mini-panel">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Ημερολόγιο Δράσεων</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.dashboard._calendar')
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default smallHeading mini-panel">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Διάγραμμα Εθελοντών</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.dashboard._donut')
            </div>
        </div>
    </div>
</div>
@stop
