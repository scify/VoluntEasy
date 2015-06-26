@extends('default')

@section('title')
    Δημιουργία Κλαδιού Μονάδας
@stop

@section('pageTitle')
    Δημιουργία Κλαδιού Μονάδας
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
           <div class="panel-body">
               <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                   <div class="panel panel-default">
                       <div class="panel-heading" role="tab" id="headingOne">
                           <h4 class="panel-title">
                               <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                  aria-expanded="true" aria-controls="collapseOne">
                                   Στοιχεία Μονάδας
                               </a>
                           </h4>
                       </div>
                       <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="headingOne">
                           <div class="panel-body">
                               {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'branch']]) !!}
                               @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'type' => 'branch'])
                               {!! Form::close() !!}
                           </div>
                       </div>
                   </div>
                   <div class="panel panel-default">
                       <div class="panel-heading" role="tab" id="headingTwo">
                           <h4 class="panel-title">
                               <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                  aria-expanded="false" aria-controls="collapseTwo">
                                   Υπεύθυνοι
                               </a>
                           </h4>
                       </div>
                       <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                            aria-labelledby="headingTwo">
                           <div class="panel-body">
                               @include('main.units.partials._users', ['users' => $users])
                           </div>
                       </div>
                   </div>
                   <div class="panel panel-default">
                       <div class="panel-heading" role="tab" id="headingThree">
                           <h4 class="panel-title">
                               <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                  href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                   Δράσεις
                               </a>
                           </h4>
                       </div>
                       <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                            aria-labelledby="headingThree">
                           <div class="panel-body">
                               @include('main.units.partials._actions', ['userIds' => $userIds])
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-body">
                <div id="unitsTree"></div>
                <ul id="tree" style="display:none;">
                    <li data-id="{{$tree->id}}" class="active-node"><span class="description">{{$tree->description}}</span>
                        <ul>
                            @include('main.units.partials._branch_actions', array('unit' => $tree))
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

@stop


@section('footerScripts')
<script>
    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        chartClass: "jOrgChart actions",
        actions: true
    });

    $("#parent_unit").val($("#parent_unit").attr("data-value"));

    $(".node").click(function () {
        $("#parent_unit").val($(this).find(".description").text());
        $("#parent_unit_id").val($(this).attr("data-id"));
    })
</script>
@stop