<!DOCTYPE html>
<?php $lang = "auth/login."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>{{trans($lang.'logIn')}} | {{env('PLATFORM_NAME')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-6 col-md-6 col-lg-3 center">
                    <div class="login-box">
                        <div class="text-center">
                            <a href="{{ url('/') }}">
                                @if(env('PLATFORM_NAME')=='VoluntAction')
                                    <img src="{{ asset('assets/images/voluntaction/compact_logo.png') }}"
                                         class="logo"/>
                                @else
                                <img src="{{ asset('assets/images/volunteasy/compact_logo.png') }}"
                                     class="logo"/>
                                @endif
                            </a>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="m-t-md" role="form" method="POST" action="{{ url('/auth/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="remember"> {{trans($lang.'remember')}}</label>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">{{trans($lang.'entrance')}}</button>
                            <div class="form-group">
                                <a href="{{ url('/password/email') }}"
                                   class="display-block text-center m-t-md text-sm">{{trans($lang.'forgotPass')}}</a>
                            </div>
                        </form>
                    </div>
                    <p class="text-center">
                        @if (\Cookie::get('locale') === 'el')
                            <a href="{{ url('/en') }}">{{trans('/default.english')}}</a>
                        @else
                            <a href="{{ url('/el') }}">{{trans('/default.greek')}}</a>
                        @endif
                    </p>
                    @if(env('APP_ENV')=='demo')
                        <p class="text-center">{{trans('auth/login.demoUser')}}<br/>
                            <strong>Username:</strong> demo@scify.org<br/>
                            <strong>Password:</strong> demo1234</p>
                    @endif
                    @if(env('APP_ENV')!='demo' && $footerLogoPath!=null && $footerLogoPath!='')
                        @include($footerLogoPath)
                    @endif
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
