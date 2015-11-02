@extends('default')

@section('title')
Δημιουργία Συνεργαζόμενου Φορέα
@stop

@section('pageTitle')
Δημιουργία Συνεργαζόμενου Φορέα
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία συνεργαζόμενου φορέα</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(['method' => 'POST', 'action' => ['CollaborationController@store'], 'files'=>true]) !!}
                        @include('main.collaborations.partials._form', ['submitButtonText' => 'Αποθήκευση'])
                        {!! Form::close() !!}
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
@append
