@extends('default')

@section('title')
{{ trans('entities/volunteers.viewOne') }}
@stop

@section('pageTitle')
{{ trans('entities/volunteers.viewOne') }}
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <h3>{{ $volunteer->name }} {{ $volunteer->last_name }}
                            @if($volunteer->gender_id!=null && $volunteer->gender_id==1)
                            | <i class="fa fa-mars"></i>
                            @elseif($volunteer->gender_id!=null && $volunteer->gender_id==2)
                            | <i class="fa fa-venus"></i>
                            @endif
                            @if($volunteer->age>0)
                            | {{ $volunteer->age }} {{ trans('entities/volunteers.yeardOld') }}</h3>
                        @endif
                        <p><i class="fa fa-envelope"></i> <a href="mailto:{{ $volunteer->email }}">{{ $volunteer->email
                                }}</a> @if ($volunteer->comm_method_id==1) <i class="fa fa-star" data-toggle="tooltip"
                                                                              title="{{ trans('entities/volunteers.preferredContactWay') }}"></i>
                            @endif

                            @if($volunteer->cell_tel!=null && $volunteer->cell_tel!='')
                            | <i class="fa fa-phone"></i> {{ $volunteer->cell_tel }} @if ($volunteer->comm_method_id==4)
                            <i
                                class="fa fa-star" data-toggle="tooltip"
                                title="{{ trans('entities/volunteers.preferredContactWay') }}"></i>
                            @endif
                            @endif
                            @if($volunteer->city!=null && $volunteer->country!='')
                            | <i class="fa fa-map-marker"></i>
                            {{ $volunteer->city }}, {{ $volunteer->country }}
                            @endif
                        </p>
                    </div>
                @if($volunteer->blacklisted)
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-danger">{{ trans('entities/volunteers.markedAsBlacklisted') }}<br/>
                            @if($volunteer->permitted)
                            <small><a href="#" data-toggle="modal" data-target="#unblacklisted">{{ trans('entities/volunteers.markAsNotBlacklisted') }}</a></small>
                            @endif
                        </h3>
                    </div>
                </div>
                @endif
                @if($volunteer->not_available)
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-danger">{{ trans('entities/volunteers.markedAsNotAvailable') }} <strong>{{
                                $volunteer->not_availableFrom}} - {{ $volunteer->not_availableTo}}</strong> <br/>
                            @if($volunteer->permitted)
                            <small><a href="#" data-toggle="modal" data-target="#notAvailableInfo">{{ trans('entities/volunteers.information') }}</a>
                            </small>
                            |
                            <small><a href="#" data-toggle="modal" data-target="#available">{{ trans('entities/volunteers.markAsAvailable') }}</a></small>
                            @endif
                        </h4>
                    </div>
                </div>
                @endif


                <div class="row top-margin">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i
                                        class="fa fa-user m-r-xs"></i>{{ trans('entities/volunteers.personalInfo') }}</a></li>
                            @if(!$volunteer->blacklisted && !$volunteer->hideStatus)
                            <li role="presentation"><a href="#tab2" data-toggle="tab"><i
                                        class="fa fa-circle-o-notch m-r-xs"></i>{{ trans('entities/volunteers.currentStatus') }}</a></li>
                            @endif
                            <li role="presentation"><a href="#tab3" data-toggle="tab"><i
                                        class="fa fa-bullseye m-r-xs"></i>{{ trans('entities/volunteers.actionParticipation') }}</a></li>
                            <li role="presentation"><a href="#tab4" data-toggle="tab"><i
                                        class="fa fa-history m-r-xs"></i>{{ trans('entities/volunteers.history') }}</a></li>
                            @if($customRatings)
                            <li role="presentation"><a href="#tab5" data-toggle="tab"><i
                                        class="fa fa-star m-r-xs"></i>{{ trans('entities/volunteers.ratings') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <!-- tab1 Ατομικά στοιχεία.-->
                    <div class="tab-pane active fade in" id="tab1">
                        @include('main.volunteers.partials._profile_details')
                    </div>
                    <div class="tab-pane fade in" id="tab2">
                        @include('main.volunteers.partials._profile_status')

                        @if(!$volunteer->blacklisted && isset($volunteer->hideStatus) && !$volunteer->hideStatus)
                        @include('main.volunteers.partials._profile_pending')
                        @endif

                        {{--@if($available>0)
                        @include('main.volunteers.partials._profile_available')
                        @endif --}}
                    </div>
                    <div class="tab-pane fade in" id="tab3">
                        @include('main.volunteers.partials._profile_actions')
                    </div>

                    <div class="tab-pane fade in" id="tab4">
                        @include('main.volunteers.partials._timeline')
                    </div>

                    @if($customRatings)
                    <div class="tab-pane fade in" id="tab5">
                        @include('main.volunteers.partials._ratings')
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@if($volunteer->not_available)
<div class="modal fade" id="available">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/volunteers.markAsAvailable') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::formInput('notAvailableComments', trans('entities/volunteers.comments'), $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'value' => $volunteer->not_availableComments, 'id'
                =>
                'notAvailableComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                <button type="button" class="btn btn-success available" data-volunteer-id="{{ $volunteer->id }}"
                        data-status-duration-id="{{ $volunteer->not_availableId }}">
                    {{ trans('default.save') }}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="notAvailableInfo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/volunteers.availabilityInfo') }}</h4>
            </div>
            <div class="modal-body">
                <p>{!! trans('entities/volunteers.notAvailableFromTo', ['from' => $volunteer->not_availableFrom, 'to' => $volunteer->not_availableTo]) !!}</p>

                <p>{{ trans('entities/volunteers.comments') }}<br/>
                    @if($volunteer->not_availableComments==null || $volunteer->not_availableComments=='')
                    <em>{{ trans('entities/volunteers.noComment') }}</em>
                    @else
                    {{ $volunteer->not_availableComments }}
                    @endif
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endif


@if($volunteer->blacklisted)
<div class="modal fade" id="unblacklisted">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/volunteers.markAsAvailable') }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ trans('entities/volunteers.markAsAvailableExpl') }}</p>
                {!! Form::formInput('comments', trans('entities/volunteers.comments') , $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => trans('entities/volunteers.commentsAboutVolunteer') , 'value' => $volunteer->comments, 'id'
                =>
                'blacklistedComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                <button type="button" class="btn btn-danger unblacklisted" data-volunteer-id="{{ $volunteer->id }}">
                    {{ trans('default.save') }}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endif


@stop


@section('footerScripts')
<script>

    //change volunteer status to available
    $(".available").click(function () {
        $.ajax({
            url: $("body").attr('data-url') + '/volunteers/available',
            method: 'POST',
            data: {
                'id': $(this).attr('data-status-duration-id'),
                'comments': $("#notAvailableComments").val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    });


    //change volunteer status to unblacklisted
    $(".unblacklisted").click(function () {
        $.ajax({
            url: $("body").attr('data-url') + '/volunteers/unblacklisted',
            method: 'POST',
            data: {
                'id': $(this).attr('data-volunteer-id'),
                'comments': $("#blacklistedComments").val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    });

    //delete user and return to user list
    function deleteVolunteer(id) {
        if (confirm(Lang.get('js-components.deleteVolunteer')) == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    window.location = $("body").attr('data-url') + '/volunteers';
                }
            });
        }
    }
</script>
@append
