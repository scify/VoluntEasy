<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title>VoluntEasy | Δημιουργία Λογαριασμού </title>

        @include('template.default.headerIncludes')
    </head>

    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-10 center">
                            <div class="login-box">
                                <a href="{{ url('main') }}" class="logo-name text-lg text-center">VoluntEasy</a>
                                   @if (count($errors) > 0)
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
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Όνομα" />
                                        </div>
                                        <div class="form-group">
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" />
                                        </div>
                                        <div class="form-group">
                                                <input type="password" class="form-control" name="password" placeholder="Κωδικός" />
                                        </div>
                                        <div class="form-group">
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="Επαλήθευση Κωδικού" />
                                        </div>
                                        <div class="form-group">
                                                <input type="text" class="form-control" name="addr" placeholder="Διεύθυνση" />
                                        </div>
                                        <div class="form-group">
                                                <input type="text" class="form-control" name="tel" placeholder="Τηλέφωνο" />
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block">Δημιουργία Λογαριασμού</button>
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