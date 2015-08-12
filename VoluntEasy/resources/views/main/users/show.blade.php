@extends('default')

@section('title')
Προβολή Χρήστη
@stop

@section('pageTitle')
Προβολή Χρήστη
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Στοιχεία Χρήστη</h4>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-b-lg">
                    <div class="col-md-2">
                        <div class="profile-image-container user-image text-center">
                            <img src="{{ asset('assets/images/default.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <p class="lead" id="userId" data-id="{{ $user->id }}">{{ $user->name }}</p>
                        <p><i class="fa fa-envelope"></i> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a> |
                            <i class="fa fa-home"></i> {{ $user->addr }} |
                            <i class="fa fa-phone"></i> {{ $user->tel }}</p>
                        <hr/>
                        <h3>Οργανωτικές Μονάδες</h3>
                        @if(sizeof($user->units)==0)
                        <p>Ο χρήστης δεν ανήκει σε καμία οργανωτική μονάδα.</p>
                        @else
                            <ul class="list-unstyled">
                            @foreach($user->units as $unit)
                                <li><a href="{{ url('units/one/'.$unit->id) }}">{{$unit->description}}</a></li>
                            @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12 text-right">
                        @if(in_array($user->id, $permittedUsers))
                        <a href="{{ url('users/edit/'.$user->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> Επεξεργασία</a>
                        @if($user->name!='admin')
                        <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger"><i
                                class="fa fa-trash"></i> Διαγραφή</button>
                        @endif
                        @endif
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
                <div class="row m-b-lg">
                    <div class="col-md-12 ">
                        <h3>Δέντρο</h3>
                        @include('main.tree._tree')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop



@section('footerScripts')
<script>

    //initialize the tree
    var treewrapper = new Treewrapper({
        url: $("body").attr('data-url') + '/api/tree/activeUnits/' + $("#userId").attr('data-id'),
        disabled: true,
        withActions: false,
        edit: 'user'
    });
    treewrapper.init();


    //delete user and return to user list
    function deleteUser(id) {
        if (confirm("Είτε σίγουροι ότι θέλετε να διαγράψετε το χρήστη;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/users/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    window.location = $("body").attr('data-url') + '/users';
                }
            });
        }
    }
</script>
@append
