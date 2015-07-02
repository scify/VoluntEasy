<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title>VoluntEasy | Οργανωτική Μονάδα </title>

    @include('template.default.headerIncludes')
</head>

<body class="page-login">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="{{ url('/') }}" class="logo-name text-lg text-center">VoluntEasy</a>
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <h3>Δημιουργία Οργανωτικής Μονάδας</h3>
                        {!! Form::open(['method' => 'POST', 'action' => ['UnitController@store', 'type' => 'root']]) !!}
                        @include('main.units.partials._form', ['submitButtonText' => 'Αποθήκευση', 'type' => 'root'])
                        {!! Form::close() !!}
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
