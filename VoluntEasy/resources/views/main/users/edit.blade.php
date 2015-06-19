@extends('default')

@section('title')
Επεξεργασία Χρήστη
@stop

@section('pageTitle')
Επεξεργασία Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i
                            class="fa fa-user m-r-xs"></i>Ατομικά Στοιχεία</a></li>
                    <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-home m-r-xs"></i>Οργανωτικές
                        Μονάδες</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active fade in" id="tab1">
                        <div class="row m-b-lg">
                            <div class="col-md-6">
                                {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
                                => $user->id]]) !!}
                                @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση', 'user' =>
                                $user])
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2">
                        <div class="row m-b-lg">
                            <div class="col-md-4">
                                @if(isset($user))
                                @if (sizeof($user->units)==0)
                                <h3>Ο χρήστης δεν ανήκει σε καμία οργανωτική μονάδα.</h3>

                                <div class="text-right">
                                </div>
                            </div>
                            @else
                            <ul class="list-unstyled">
                                @foreach($user->units as $unit)
                                <li><a href="#" class="unit" data-id="{{$unit->id}}">{{$unit->description}}</a></li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div id="unitsTree"></div>
                            @foreach($user->units as $unit)
                            <ul id="unit-{{$unit->id}}" style="display:none;">
                                <li>{{$unit->description}}
                                    <ul>
                                        @include('main.units.partials._branch', ['$unit->allChildren' => $unit, 'user'
                                        => $user])
                                    </ul>
                                </li>
                            </ul>
                            @endforeach
                        </div>
                        @endif
                        @endif
                    </div>
                    <div class="row m-b-lg">
                        <div class="col-md-4">
                            <button type="button" id="addUnits" data-userid="{{$user->id}}" class="btn btn-success"
                                    data-toggle="modal" data-target=".bs-example-modal-lg">Επεξεργασία Οργανωτικών
                            </button>
                            @include('main.users.partials._unit_modal')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@stop


@section('footerScripts')

<script>
    /*
     $(".unit").click(function(event){
     event.preventDefault();


     $("#unit-"+$(this).attr('data-id')).jOrgChart({
     chartElement: '#unitsTree'
     });

     })

     */
</script>
@stop
