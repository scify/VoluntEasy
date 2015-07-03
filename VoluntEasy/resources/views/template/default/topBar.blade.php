 <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
                        <a href="{{url('/')}}" class="logo-text"><span>VoluntEasy</span></a>
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
                                        <!-- Display the username -->
                                        <span class="user-name">{{{ isset(Auth::user()->name) ? Auth::user()->name : 'not logged in' }}}<i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar" src="/assets/images/avatar1.png" width="40" height="40"
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
                                    <a href="{!! url('auth/logout') !!}" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                    </a>
                                </li>
                                <!---/Logout--->
                            </ul>
                        </div>
                    </div><!-- /Top Menu -->
                </div>
            </div>
