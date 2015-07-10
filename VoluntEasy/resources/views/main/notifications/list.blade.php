@extends('default')

@section('title')
Ειδοποιήσεις
@stop
@section('pageTitle')
Ειδοποιήσεις
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Ειδοποιήσεις</h4>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled" id="notificationList">
                    @foreach ($user->notifications as $notification)
                    <li>
                            <div class="task-icon badge badge-success"><i class="icon-user"></i></div>
                            <span class="badge badge-roundless badge-default pull-right">1min ago</span>

                            <p class="task-details">NotId {{ $notification->id }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@stop

@section('footerScripts')
<input id="token" type="hidden" value="{{ csrf_token() }}">

<script>

</script>
@stop
