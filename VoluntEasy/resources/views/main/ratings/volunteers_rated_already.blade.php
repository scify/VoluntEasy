<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>{{trans($lang.'volRating')}} | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login" data-url="{!! URL::to('/') !!}">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-5 center">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class=" text-center">
                                <a href="{{ url('/') }}"
                                   class="logo-name text-lg"> <img
                                        src="{{ asset('assets/images/logo.png') }}" style="height:100%;"/>
                                </a>
                            </div>
                            <h3 class="text-center">{{ trans('entities/ratings.volunteerRating') }} {{ $action->description
                                }} </h3>
                            <h5 class="text-center">{{ trans('entities/ratings.actionDuration') }}: {{ $action->start_date }} - {{
                                $action->end_date }}</h5>
                            <hr/>

                            <p>{{ trans('entities/ratings.alreadyRatedVolunteer') }}</p>

                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <small><em>{{ trans('entities/ratings.youReceivedThisEmailActionManager') }}
                                                <strong>{{trans($lang.'title')}}</strong>.</em></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->
</main>
<!-- Page Content -->
@include('template.default.footerIncludes')
</body>
</html>
