<!DOCTYPE html>
<html>
    <head>
        <!-- Title -->
        <title> @yield('title') </title>

        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template"/>
        <meta name="keywords" content="admin,dashboard"/>
        <meta name="author" content="Steelcoders"/>

        <!-- Styles -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/pace-master/themes/blue/pace-theme-flash.css')}}" rel="stylesheet"/>
        <link href="{{ asset('assets/plugins/uniform/css/uniform.default.min.css')}}" rel="stylesheet"/>
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/line-icons/simple-line-icons.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/waves/waves.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/3d-bold-navigation/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/slidepushmenus/css/component.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/weather-icons-master/css/weather-icons.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/metrojs/MetroJs.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="{{ asset('assets/css/modern.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/themes/white.css')}}" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('assets/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>
        <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js')}}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        {{--[if lt IE 9]>--}}
        {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>--}}
        {{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
        {{--<![endif]--}}

    </head>


    <body class="page-header-fixed">
        <!--HEADER-->
        <!--search popup-->
        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </span>
            </div>
            <!-- Input Group -->
        </form>
        <!--search popup-->
        <main class="page-content content-wrap">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
                        <a href="index.blade.html" class="logo-text"><span>Modern</span></a>
                    </div>
                    <!-- Logo Box -->
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search">
                            <i class="fa fa-search"></i></a>
                    </div>


                    <div class="topmenu-outer">
                        <!--options(appearence)-->
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                                       data-toggle="dropdown">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-md dropdown-list theme-settings" role="menu">
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Header
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-header-check"
                                                               checked>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Sidebar
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-sidebar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Horizontal bar
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right horizontal-bar-check">
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="no-link">
                                            <button class="btn btn-default reset-options">Reset Options</button>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        <!--/options(appearence)-->

                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </li>

                                <!---Notificasion Icon-->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                                        data-toggle="dropdown"><i class="fa fa-bell"></i>
                                        <span class="badge badge-success pull-right">3</span>
                                    </a>
                                    <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                        <li><p class="drop-title">You have 3 pending tasks !</p></li>
                                        <li class="dropdown-menu-list slimscroll tasks">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="#">
                                                        <div class="task-icon badge badge-success"><i class="icon-user"></i></div>
                                                        <span class="badge badge-roundless badge-default pull-right">1min ago</span>
                                                        <p class="task-details">New user registered.</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="task-icon badge badge-danger"><i class="icon-energy"></i></div>
                                                        <span class="badge badge-roundless badge-default pull-right">24min ago</span>
                                                        <p class="task-details">Database error.</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="task-icon badge badge-info"><i class="icon-heart"></i></div>
                                                        <span class="badge badge-roundless badge-default pull-right">1h ago</span>
                                                        <p class="task-details">Reached 24k likes</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="drop-all"><a href="#" class="text-center">All Tasks</a></li>
                                    </ul>
                                </li>
                                <!---/Notificasion Icon-->

                                <!---Profile--->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic"
                                        data-toggle="dropdown">
                                        <span class="user-name">David<i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar" src="assets/images/avatar1.png" width="40" height="40"
                                         alt="">
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="template%20parts/profile.html"><i class="fa fa-user"></i>Profile</a></li>
                                        <li role="presentation"><a href="template%20parts/calendar.html"><i class="fa fa-calendar"></i>Calendar</a>
                                        </li>
                                        <li role="presentation"><a href="template%20parts/inbox.html"><i class="fa fa-envelope"></i>Inbox<span
                                                class="badge badge-success pull-right">4</span></a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation"><a href="template%20parts/lock-screen.html"><i class="fa fa-lock"></i>Lock screen</a>
                                        </li>
                                        <li role="presentation"><a href="template%20parts/login.html"><i class="fa fa-sign-out m-r-xs"></i>Log
                                            out</a></li>
                                    </ul>
                                </li>
                                <!---/Profile--->

                                <!---Logout--->
                                <li>
                                    <a href="template%20parts/login.html" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                    </a>
                                </li>
                                <!---/Logout--->
                            </ul>
                        </div>
                    </div><!-- /Top Menu -->
                </div>
            </div>
            <!-- Navbar -->

            <!--MENU--->
            <div class="page-sidebar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    <ul class="menu accordion-menu">
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button"><span
                                    class="menu-icon glyphicon glyphicon-home"></span>
                                <p>Οργανωτικές<br>Μονάδες</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="#">Καταχώρηση Μονάδας</a></li>
                                <li><a href="#">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="#">Τροποποίηση</a></li>
                                <li><a href="#">Επισκόπηση</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-user"></span>
                                <p>Δράσεις &<br>Προγράμματα</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="#">Καταχώρηση Δράσης</a></li>
                                <li><a href="#">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="#">Τροποποίηση</a></li>
                                <li><a href="#">Επισκόπηση</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-envelope"></span>
                                <p>Εθελοντές <br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="#">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="#">Στατιστικές Αναλύσεις</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-briefcase"></span>
                                <p>Χρήστες<br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="#">Καταχώρηση χρήστη</a></li>
                                <li><a href="#">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="#">Τροποποίηση</a></li>
                                <li><a href="#">Επισκόπηση</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-list"></span>
                                <p>Σχεδιάγραμμα<br>Ιστοσελίδας</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Page Sidebar Inner -->
            </div>
            <!--/MENU--->

            <!--BODY--->
            <div class="page-inner">
                <!--BODY--->
                @yield('bodyContent')
                <!--/BODY--->

                <!--FOUTER--->
                <div class="page-footer">
                    <p class="no-s">2015 &copy; Modern by Steelcoders.</p>
                </div>
                <!--/FOUTER--->
            </div>
            <!-- Page Inner -->
        </main>
        <!-- Page Content -->
        <div class="cd-overlay"></div>


        <!-- Javascripts -->
        <script src="{{ asset('assets/plugins/jquery/jquery-2.1.3.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/pace-master/pace.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-blockui/jquery.blockui.js')}}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/switchery/switchery.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/uniform/jquery.uniform.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/classie.js')}}"></script>
        <script src="{{ asset('assets/plugins/offcanvasmenueffects/js/main.js')}}"></script>
        <script src="{{ asset('assets/plugins/waves/waves.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/3d-bold-navigation/js/main.js')}}"></script>
        <script src="{{ asset('assets/plugins/waypoints/jquery.waypoints.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-counterup/jquery.counterup.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/flot/jquery.flot.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/flot/jquery.flot.time.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/flot/jquery.flot.symbol.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/flot/jquery.flot.resize.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/curvedlines/curvedLines.js')}}"></script>
        <script src="{{ asset('assets/plugins/metrojs/MetroJs.min.js')}}"></script>
        <script src="{{ asset('assets/js/modern.js')}}"></script>
        <script src="{{ asset('assets/js/pages/dashboard.js')}}"></script>
    </body>
</html>