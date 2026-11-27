@extends('default')

@section('title')
{{ trans('pages/faq.helpAndFaq') }}
@stop
@section('pageTitle')
{{ trans('pages/faq.helpAndFaq') }}
@stop

@section('bodyContent')
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-white">
            <div class="panel-body">

                <h2 class="m-t-xxl m-b-lg">{{ trans('pages/faq.faq') }}</h2>

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne1">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#faq1"
                                   aria-expanded="false" aria-controls="faq1">
                                    {{ trans('pages/faq.question1') }}
                                </a>
                            </h4>
                        </div>
                        <div id="faq1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                            <div class="panel-body">
                            <p>{!! trans('pages/faq.answer1') !!}</p>

                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo2">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#faq2"
                                   aria-expanded="false" aria-controls="faq2">
                                     {{ trans('pages/faq.question2') }}
                                </a>
                            </h4>
                        </div>
                        <div id="faq2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo2">
                            <div class="panel-body">
                                {!! trans('pages/faq.answer2') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <a href="{{ asset('assets/pdf/volunteasy-manual.pdf') }}" target="_blank" class="faq-link">
            <div class="panel panel-green">
                <div class="panel-body">
                    <h2 class="no-m m-b-md"> {{ trans('pages/faq.helpFile') }}</h2>

                    <p> {{ trans('pages/faq.downloadFile') }}</p>
                </div>
            </div>
        </a>
    </div>
</div>
@stop



