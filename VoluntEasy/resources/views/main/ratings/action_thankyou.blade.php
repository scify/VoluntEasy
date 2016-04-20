<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>{{trans($lang.'volRating')}} | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-5 center">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class="login-box">
                                <a href="{{ url('/') }}"
                                   class="logo-name text-lg text-center">
                                    @if(env('PLATFORM_NAME')=='VoluntAction')
                                        <img src="{{ asset('assets/images/voluntaction/logo.png') }}" style="height:100%;"/>
                                    @else
                                        <img src="{{ asset('assets/images/volunteasy/logo.png') }}" style="height:100%;"/>
                                    @endif
                                </a>

                                <h3 class="text-center">{{ trans('entities/ratings.actionRating') }}</h3>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>{{ trans('entities/ratings.ratingAdded') }}</h3>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><em>{{ trans('entities/ratings.youReceivedThisEmailVolunteer') }}
                                                <strong>{{trans($lang.'title')}}</strong>.</em></p>
                                    </div>
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
