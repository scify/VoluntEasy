@extends('default')
@section('title')
    Αρχική
@stop
@section('pageTitle')
    Dashboard
@stop

@section('bodyContent')
    <div id="main-wrapper">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter"><a href="{{ url('volunteers/new') }}">{{ $new }}</a></p>
                                    <span class="info-box-title">ΥΠΟ ΕΝΤΑΞΗ ΕΘΕΛΟΝΤΕΣ</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter"><a href="{{ url('actions/') }}"> {{ $actions }} </a></p>
                                    <span class="info-box-title">ΕΝΕΡΓΕΣ ΔΡΑΣΕΙΣ</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-bookmark"></i>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $available }} / {{ $active }}</p>
                            <span class="info-box-title">ΔΙΑΘΕΣΙΜΟΙ / ΕΝΕΡΓΟΙ ΕΘΕΛΟΝΤΕΣ</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="fa fa-leaf"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
