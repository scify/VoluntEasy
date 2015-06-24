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


@stop


@section('footerScripts')
<script>

</script>
@stop