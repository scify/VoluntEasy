<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title> @yield('title') </title>

        <!-- Include css, js files-->
        @include('template.default.headerIncludes')
    </head>


    <body class="page-header-fixed">
        <main class="page-content content-wrap">
            <!-- Navbar/TopBar -->
            @include('template.default.topBar')

            <!--Side Menu--->
            @include('template.default.menu')

            <div class="page-inner">
                <!--Page Title & Breadcrumbs -->
                @include('template.default.pageTitle')

                <!--Body -->
                @yield('bodyContent')

                <!-- Footer -->
                @include('template.default.footer')
            </div>
        </main>
        <div class="cd-overlay"></div>
        @include('template.default.footerIncludes')
    </body>
</html>


