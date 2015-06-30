<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title> 550 | VoluntEasy</title>

    <!-- Include css, js files-->
    @include('template.default.headerIncludes')
</head>


<body class="page-error">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-4 center">
                    <h1 class="text-xxl text-primary text-center">550</h1>
                    <div class="details">
                        <h3>ΣΦΑΛΜΑ</h3>
                        <p>Δεν έχετε δικαίωμα να κάνετε τη συγκεκριμένη ενέργεια.</p>
                        <p><a href="{{ url('main') }}">Αρχική</a></p>
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
</main><!-- Page Content -->
<div class="cd-overlay"></div>
@include('template.default.footerIncludes')
</body>
</html>


