@extends('default')

@section('title')
Επεξεργασία Χρήστη
@stop

@section('pageTitle')
Επεξεργασία Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::model($user, ['method' => 'POST', 'action' => ['UserController@update', 'id'
                => $user->id]]) !!}
                @include('main.users.partials._form', ['submitButtonText' => 'Αποθήκευση', 'user' =>
                $user])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row m-b-lg">
                    <div class="col-md-12 ">
                        <h3>Επιλογή Οργανωτικών Μονάδων</h3>

                        <p>Επιλέξτε τις οργανωτικές μονάδες στις οποίες μπορεί να έχει πρόσβαση ο χρήστης.</p>

                        @if($tree!=null)
                        @include('main.tree._tree', ['unit' => $tree, 'actives' => $actives])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-success" id="save" data-user-id="{{$user->id}}">
                            Αποθήκευση
                        </button>
                    </div>
                </div>
                @else
                <h3>Δεν υπάρχουν οργανωτικές μονάδες.</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@stop


@section('footerScripts')
<script src="{{ asset('assets/js/pages/users/edit.js')}}"></script>
<script>
    var handler = new window.scify.editHandler("pink");
    handler.init();
</script>
@stop
