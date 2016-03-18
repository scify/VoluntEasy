@extends('default')

@section('title')
{{ trans('entities/users.view') }}
@stop
@section('pageTitle')
{{ trans('entities/users.view') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UserController@search'], 'id' => 'searchForm']) !!}
                @include('main.users.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/users.users') }}</h4>
            </div>
            <div class="panel-body">
                @include('main.users.partials._table')
            </div>
        </div>
    </div>
</div>

@stop


@section('footerScripts')
<script>
    $(".delete").click(function () {
        if (confirm("Delete user?") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/users/delete/' + $(this).attr('data-id'),
                method: 'POST',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/users";
                }
            });
        }
    });
</script>
@append
