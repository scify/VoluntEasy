@extends('default')

@section('title')
{{ trans('entities/units.viewOne') }}
@stop

@section('pageTitle')
{{ trans('entities/units.viewOne') }}
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h2 class="panel-title">{{ trans('entities/units.info') }}</h2>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <h3>{{ trans('entities/units.unit') }} {{$active->description}}</h3>

                        <p id="unitId" data-unit-id="{{ $active->id }}"><strong>{{ trans('entities/units.description') }}:</strong>
                            {{$active->comments}}</p>
                    </div>
                    <div class="col-md-4">
                        @if(sizeof($active->users)==0)
                        <h3>{{ trans('entities/units.execs') }}:</h3>

                        <p>-</p>
                        @elseif(sizeof($active->users)==1)
                        <h3>{{ trans('entities/units.exec') }}</h3>
                        <ul class="list-unstyled">
                            <li class="user-list">
                                <div class="msg-img">
                                    <img src="{{ ($active->users[0]->image_name==null || $active->users[0]->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$active->users[0]->image_name) }}"
                                         alt="" class="user-image-small userImage">
                                </div>
                                <p class="msg-name"><a href="{{ url('users/one/'.$active->users[0]->id) }}">{{$active->users[0]->name}} {{$active->users[0]->last_name}}</a>

                                <p>

                                <p class="msg-text"><i class="fa fa-envelope"></i> <a
                                        href="mail:to{{ $active->users[0]->email }}">{{ $active->users[0]->email }}</a>
                                    |
                                    <i class="fa fa-home"></i> {{ $active->users[0]->addr }} |
                                    <i class="fa fa-phone"></i> {{ $active->users[0]->tel }}</p>
                            </li>
                        </ul>
                        @else
                        <h3>{{ trans('entities/units.execs') }}:</h3>
                        <ul class="list-unstyled">
                            @foreach($active->users as $user)
                            <li class="user-list">
                                <div class="msg-img">
                                    <img src="{{ ($user->image_name==null || $user->image_name=='') ?
                                    asset('assets/images/default.png') : asset('assets/uploads/users/'.$user->image_name) }}"
                                         alt="" class="user-image-small userImage">

                                    <p class="msg-name"><a href="{{ url('users/one/'.$user->id) }}">
                                            {{ $user->name }} {{ $user->last_name }}</a>

                                    <p>

                                    <p class="msg-text"><i class="fa fa-envelope"></i> <a
                                            href="mail:to{{ $user->email }}">{{
                                        $user->email }}</a> |
                                        <i class="fa fa-home"></i> {{ $user->addr }} |
                                        <i class="fa fa-phone"></i> {{ $user->tel }}</p>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($type=='leaf')
                        <h3>{{ trans('entities/units.activeActions') }}:</h3>
                        @if(sizeof($active->actions)==0)
                        <h3>-</h3>
                        @else
                        <ul class="list-unstyled">
                            @foreach($active->actions as $action)
                            <li>
                                <p class="user-list"><a href="{{ url('actions/one/'.$action->id) }}">{{$action->description}}</a>
                                    <small>{{ $action->start_date }} - {{ $action->end_date }}</small>
                                </p>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        @endif

                    </div>
                </div>
                <hr/>
                @if(in_array($active->id, $userUnits))
                <div class="text-right">
                    <a href="{{ url('units/edit/'.$active->id) }}" class="btn btn-success"><i
                            class="fa fa-edit"></i> {{ trans('default.edit') }}</a>
                    @if($active->parent_unit_id!=null)
                    <button type="button" data-delete-unit="{{ $active->id }}" class="btn btn-danger"><i
                            class="fa fa-trash"></i> {{ trans('default.delete') }}
                    </button>
                    @endif
                </div>
                @endif
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
        @include('main.tree._showTree')

    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/volunteers.volunteers') }}</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('main.units.partials._volunteers', ['unit' => $active])
                    </div>
                </div>
                {{--@if(in_array($active->id, $userUnits))
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#volunteersModal"><i
                                    class="fa fa-leaf"></i> {{ trans('entities/units.addVolunteers') }}
                            </button>
                        </div>
                    </div>
                </div>
                @endif --}}
            </div>
        </div>
    </div>
</div>

@if(sizeof($active->allActions)>0)
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/units.allActions') }}</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.units.partials._allactions', ['unit' => $active])
            </div>
        </div>
    </div>
</div>
@endif

<!-- Include the modal that has the select2 with all the available volunteers -->
@include('main._modals._volunteers')


@stop


@section('footerScripts')
<script>
    VE.ready(function () {
        // initialize the tree
        new Treewrapper({
            active: {
                type: 'unit',
                id: document.getElementById('unitId').getAttribute('data-unit-id')
            },
            disabled: true
        }).init();

        // initialize the volunteer select
        var volunteerList = document.getElementById('volunteerList');
        if (volunteerList) VE.select(volunteerList);

        // get the array of volunteers selected and save them
        VE.on('#saveVolunteers', 'click', function (event, button) {
            var volunteers = volunteerList ? Array.prototype.map.call(volunteerList.selectedOptions, function (option) {
                return option.value;
            }) : [];

            VE.http.post('/units/volunteers', {id: button.getAttribute('data-id'), volunteers: volunteers})
                .then(function (data) { location.href = VE.url('/units/one/' + data); })
                .catch(VE.fail);
        });

        // delete a unit and redirect to unit list
        VE.on(document, 'click', '[data-delete-unit]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteUnit'))) return;
            VE.http.post('/units/delete/' + el.getAttribute('data-delete-unit'))
                .then(function () { location.href = VE.url('/units'); })
                .catch(VE.fail);
        });
    });
</script>
@append
