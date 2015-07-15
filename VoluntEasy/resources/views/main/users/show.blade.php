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
            <div class="panel-body">
                <div class="row m-b-lg">
                    <div class="col-md-2">
                        <div class="profile-image-container user-image text-center">
                            <img src="{{ asset('assets/images/avatar4.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="lead">{{ $user->name }}</p>
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
                    <div class="col-md-4 text-right">
                        @if(in_array($user->id, $permittedUsers))
                        <a href="{{ url('users/edit/'.$user->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> Επεξεργασία</a>
                        <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Διαγραφή</button>
                        @endif
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
