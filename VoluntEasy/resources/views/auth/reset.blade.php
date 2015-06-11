<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title>VoluntEasy | Login </title>

        @include('template.default.headerIncludes')
    </head>

    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="login-box">
                                <a href="{{ url('main') }}" class="logo-name text-lg text-center">VoluntEasy</a>

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
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
							<label>E-Mail address</label>
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>

						<div class="form-group">
							<label>New password</label>
							<input type="password" class="form-control" name="password">
						</div>

						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control" name="password_confirmation">
						</div>

						<div class="form-group">
							<div class="btn btn-success btn-block">
								<button type="submit" class="btn btn-success btn-block">Reset Password</button>
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
