<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title>VoluntEasy | {{ trans('auth/login.register') }} </title>

        @include('template.default.headerIncludes')
    </head>

    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-10 center">
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
                                </div>                                   @if (count($errors) > 0)
                                		<div class="alert alert-danger">
                                			<ul>
                                				@foreach ($errors->all() as $error)
                                					<li>{{ $error }}</li>
                                				@endforeach
                                			</ul>
                                		</div>
                                	@endif
                                	<form class="m-t-md" role="form" method="POST" action="{{ url('/auth/register') }}">
                                		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth/login.name') }}" />
                                        </div>
                                        <div class="form-group">
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth/login.email') }}" />
                                        </div>
                                        <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="{{ trans('auth/login.password') }}" />
                                        </div>
                                        <div class="form-group">
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth/login.passwordConfirm') }}" />
                                        </div>
                                        <div class="form-group">
                                                <input type="text" class="form-control" name="addr" placeholder="{{ trans('auth/login.address') }}" />
                                        </div>
                                        <div class="form-group">
                                                <input type="text" class="form-control" name="tel" placeholder="{{ trans('auth/login.phone') }}" />
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block">{{ trans('auth/login.register') }}</button>
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
