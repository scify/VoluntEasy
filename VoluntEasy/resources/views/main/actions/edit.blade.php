@extends('default')

@section('title')
Επεξεργασία Δράσης
@stop

@section('pageTitle')
Επεξεργασία Δράσης
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία δράσης</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($action, ['method' => 'POST', 'action' => ['ActionController@update', 'id' => $action->id]]) !!}
                        @include('main.actions.partials._form', ['submitButtonText' => 'Αποθήκευση', 'action' =>$action])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Επιλογή πατέρα δράσης <span class="star">*</span></h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.tree._tree', ['editing' => 'action', 'actives' => $actives])
            </div>
        </div>
    </div>
</div>

@stop


@section('footerScripts')
<script>

    $("#tree li.action[data-id='"+$('#tree').attr("data-id")+"'").addClass('active-node');

    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        disabled: true
    });

</script>
@stop
