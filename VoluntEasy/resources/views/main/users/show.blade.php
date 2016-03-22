<?php $lang = "default."; ?>

@extends('default')

@section('title')
{{ trans('entities/users.viewOne') }}
@stop

@section('pageTitle')
{{ trans('entities/users.viewOne') }}
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/users.info') }}</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row m-b-lg">
                    <div class="col-md-2">
                        <div class="profile-image-container user-image text-center">
                            <img src="{{ ($user->image_name==null || $user->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$user->image_name) }}"
                                 alt="" class="user-image-small userImage">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <p class="lead" id="userId" data-id="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }}</p>

                        <p><i class="fa fa-envelope"></i> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a> |
                            @if($user->addr!=null && $user->addr!='')
                            <i class="fa fa-home"></i> {{ $user->addr }} |
                            @endif
                            <i class="fa fa-phone"></i> {{ $user->tel }}</p>
                        <hr/>
                        <h3>Ρόλοι</h3>
                        @foreach($user->roles as $role)
                        <p>{{trans($lang.$role->name.'-at')}}</p>
                        @if('unit_manager' == $role->name)
                        <ul>
                            @foreach($user->units as $unit)
                            <li><a href="{{ url('units/one/'.$unit->id) }}">{{$unit->description}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                        @if('action_manager' == $role->name)
                        <ul>
                            @foreach($user->actions as $action)
                            <li><a href="{{ url('actions/one/'.$action->id) }}">{{$action->description}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                        @endforeach

                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12 text-right">
                        @if(in_array($user->id, $permittedUsers))
                        <a href="{{ url('users/edit/'.$user->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> {{ trans('default.edit') }}</a>
                        @if(!$isAdmin)
                        <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger"><i
                                class="fa fa-trash"></i> {{ trans('default.delete') }}
                        </button>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="panel panel-white tree">
    <div class="panel-heading clearfix">
        <h2 class="panel-title">{{ trans('entities/tree.tree') }}</h2>

        <div class="panel-control">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"
               data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
        </div>
    </div>
    <div class="panel-body" style="display: block;">
        <h4>{{ trans('entities/users.inGreenTheUserUnits') }}</h4>

        @include('main.tree._tree')

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
        if (confirm(Lang.get('js-components.deleteUser')) == true) {
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
