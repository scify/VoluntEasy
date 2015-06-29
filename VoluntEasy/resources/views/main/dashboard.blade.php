@extends('default')
@section('title')
    VoluntEasy Αρχική
@stop
@section('pageTitle')
    Dashboard
@stop

@section('bodyContent')
    <div id="main-wrapper">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter"><a href="{{ url('main/volunteers/new') }}">{{ $volunteers }}</a></p>
                                    <span class="info-box-title">ΝΕΟΙ ΕΘΕΛΟΝΤΕΣ</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{ $actions }}</p>
                                    <span class="info-box-title">ΔΡΑΣΕΙΣ</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-eye"></i>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p>$<span class="counter">653,000</span></p>
                            <span class="info-box-title">Monthly revenue goal</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-basket"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">47,500</p>
                            <span class="info-box-title">New emails recieved</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
