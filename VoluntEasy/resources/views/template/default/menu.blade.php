<div class="page-sidebar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    <ul class="menu accordion-menu">
                        <li class="droplink {{ Request::is('units*') ? 'active open' : '' }}">
                            <a class="waves-effect waves-button"><span
                                    class="menu-icon glyphicon glyphicon-home"></span>
                                <p>Οργανωτικές<br>Μονάδες</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('units') ? 'active' : '' }}"><a href="{{ url('units') }}">Προβολή Μονάδων</a></li>
                                <li class="{{ Request::is('units/create') ? 'active' : '' }}"><a href="{{ url('units/create') }}">Δημιουργία Μονάδας</a></li>
                            </ul>
                        </li>
                        <li class="droplink {{ Request::is('actions*') ? 'active open' : '' }}">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-bookmark"></span>
                                <p>Δράσεις &<br>Προγράμματα</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('actions') ? 'active' : '' }}"><a href="{{ url('actions') }}">Προβολή Δράσεων</a></li>
                                <li class="{{ Request::is('actions/create') ? 'active' : '' }}"><a href="{{ url('actions/create') }}">Δημιουργία Δράσης</a></li>
                            </ul>
                        </li>
                        <li class="droplink {{ Request::is('volunteers*') ? 'active open' : '' }}">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-leaf"></span>
                                <p>Εθελοντές <br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('volunteers') ? 'active' : '' }}"><a href="{{url('volunteers')}}">Προβολή Εθελοντών</a></li>
                                <li class="{{ Request::is('volunteers/create') ? 'active' : '' }}"><a href="{{url('volunteers/create')}}">Δημιουργία εθελοντή</a></li>
                                <li class="{{ Request::is('volunteers/create') ? 'active' : '' }}"><a href="#">Στατιστικές Αναλύσεις</a></li>
                            </ul>
                        </li>
                        <li class="droplink {{ Request::is('users*') ? 'active open' : '' }}">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-user"></span>
                                <p>Χρήστες<br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('users') ? 'active' : '' }}"><a href="{{url('users')}}">Προβολή Χρηστών</a></li>
                                <li class="{{ Request::is('users/create') ? 'active' : '' }}"><a href="{{url('users/create')}}">Δημιουργία Χρήστη</a></li>
                            </ul>
                        </li>
                        <li class=" {{ Request::is('wholeTree*') ? 'active open' : '' }}">
                            <a href="{{url('wholeTree')}}" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-tree-deciduous"></span>
                                <p>Δέντρο</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Page Sidebar Inner -->
            </div>
