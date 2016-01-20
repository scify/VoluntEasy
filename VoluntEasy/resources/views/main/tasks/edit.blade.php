@extends('default')

@section('title')
Επεξεργασία Task
@stop

@section('pageTitle')
Επεξεργασία Task
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία task</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($task, ['method' => 'POST', 'action' => ['TaskController@update', 'id' => $task->id]]) !!}
                        @include('main.tasks.partials._form', ['submitButtonText' => 'Αποθήκευση', 'task' => $task, 'actionId' => $task->action_id])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

