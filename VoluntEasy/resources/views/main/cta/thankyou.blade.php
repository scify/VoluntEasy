<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>{{ trans('entities/cta.cta') }} | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login cta" data-url="{!! URL::to('/') !!}">
<main class="page-content"  style="background-color:#F1F4F9;">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-8 center">
                    <div class="panel panel-white">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/cta_logo.png') }}"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h3>{{ trans('entities/cta.thankYou') }}</h3>
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
</body>
</html>
