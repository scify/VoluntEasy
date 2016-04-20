<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title>VoluntEasy | {{ trans('auth/login.resetPassword') }} </title>

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
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="m-t-md" role="form" method="POST" action="{{ url('/password/email') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="Email"/>
                            </div>
                            <button type="submit"
                                    class="btn btn-success btn-block">{{ trans('auth/login.resetPasswordLink') }}</button>
                        </form>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
</main><!-- Page Content -->
@include('...template.default.footerIncludes')
</body>
</html>
