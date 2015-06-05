<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title> @yield('title') </title>

        <!-- Include css, js files-->
        @include('template.includes')
    </head>


    <body class="page-header-fixed">
        <!--search popup-->
        @include('template.search')

        <main class="page-content content-wrap">

            <!-- Navbar/TopBar -->
            @include('template.topBar')

            <!--Side Menu--->
            @include('template.menu')

            <div class="page-inner">
                <!--Page Title & Breadcrumbs -->
                @include('template.pageTitle')
                <!--Body -->
                @yield('bodyContent')

                <!-- Footer -->
                @include('template.footer')
            </div>
        </main>
        <div class="cd-overlay"></div>
    </body>
</html>