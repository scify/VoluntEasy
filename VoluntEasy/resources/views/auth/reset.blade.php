<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title>{{ trans('auth/login.resetPassword') }} | {{env('PLATFORM_NAME')}}</title>

    @include('template.default.headerIncludes')
</head>

<body class="page-login">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-3 center">
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
                                {{ trans('auth/login.wrongInput') }}<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="m-t-d" role="form" method="POST" action="{{ url('/password/reset') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label>{{ trans('auth/login.email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('auth/login.newPassword') }}</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('auth/login.passwordConfirm') }}</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <div class="form-group">
                                <div class="btn btn-success btn-block">
                                    <button type="submit"
                                            class="btn btn-success btn-block">{{ trans('auth/login.resetPassword') }}</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
</main><!-- Page Content -->
@include('...template.default.footerIncludes')
</body>
</html>
