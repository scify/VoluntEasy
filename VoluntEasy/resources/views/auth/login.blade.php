<!DOCTYPE html>
<?php  $lang = "auth/login."; ?> {{--  resource label path --}}     
<html>
    <head>
        <!-- Title -->
        <title>{{trans($lang.'title')}}| {{trans($lang.'logIn')}} </title>

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
                                <a href="{{ url('/') }}"><img src="{{ asset('assets/images/compact_logo.png') }}" class="logo"/></a>
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
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Password" />
                                        </div>
                                        <div class="form-group">
                                        			<label><input type="checkbox" name="remember"> {{trans($lang.'remember')}}</label>
                                        </div>
                                       <button type="submit" class="btn btn-success btn-block">{{trans($lang.'entrance')}}</button>
                                        <div class="form-group">
                                            <a href="{{ url('/password/email') }}" class="display-block text-center m-t-md text-sm">{{trans($lang.'forgotPass')}}</a>
                                        </div>
                                   </form>

                                {{-- eeagrants logo only for ekpizo --}}
                                @include('auth._ekpizo_eeagrants')
                            </div>
                            @if($footerLogoPath!=null && $footerLogoPath!='')
                                @include($footerLogoPath)
                            @endif
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
         @include('template.default.footerIncludes')
    </body>
</html>
