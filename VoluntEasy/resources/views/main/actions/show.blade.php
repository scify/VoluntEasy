@extends('default')

@section('title')
Προβολή Δράσης
@stop

@section('pageTitle')
Προβολή Δράσης
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 id="unitDescription">{{$action->description}}</h2>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        @include('main.actions.partials._details', array('action' => $action))
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Εθελοντές</h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#volunteersModal"><i
                                class="fa fa-leaf"></i> Προσθήκη Εθελοντών
                        </button>
                    </div>
                </div>
                <hr/>
                @include('main.units.partials._volunteers', ['unit' => $action])
            </div>
        </div>
    </div>
</div>

@include('main._modals._volunteers', ['volunteers' => $volunteers, 'active' => $action])


@stop


@section('footerScripts')
<script>
    //initialize user select
    $('#volunteerList').select2();
</script>
@stop
