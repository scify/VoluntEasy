<div class="page-sidebar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    <ul class="menu accordion-menu">
                        <li class="droplink {{ Request::is('main/units*') ? 'active open' : '' }}">
                            <a class="waves-effect waves-button"><span
                                    class="menu-icon glyphicon glyphicon-home"></span>
                                <p>Οργανωτικές<br>Μονάδες</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('main/units') ? 'active' : '' }}"><a href="{{ url('main/units') }}">Προβολή Μονάδων</a></li>
                                <li class="{{ Request::is('main/units/create') ? 'active' : '' }}"><a href="{{ url('main/units/create') }}">Δημιουργία Μονάδας</a></li>
                            </ul>
                        </li>
                        <li class="droplink {{ Request::is('main/actions*') ? 'active open' : '' }}">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-bookmark"></span>
                                <p>Δράσεις &<br>Προγράμματα</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('main/actions') ? 'active' : '' }}"><a href="{{ url('main/actions') }}">Προβολή Δράσεων</a></li>
                                <li class="{{ Request::is('main/actions/create') ? 'active' : '' }}"><a href="{{ url('main/actions/create') }}">Δημιουργία Δράσης</a></li>
                            </ul>
                        </li>
                        <li class="droplink {{ Request::is('main/volunteers*') ? 'active open' : '' }}">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-leaf"></span>
                                <p>Εθελοντές <br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('main/volunteers') ? 'active' : '' }}"><a href="/main/volunteers/listview">Προβολή λίστας-Αναζήτηση</a></li>
                                <li class="{{ Request::is('main/volunteers/create') ? 'active' : '' }}"><a href="/main/volunteers/statistics">Στατιστικές Αναλύσεις</a></li>
                            </ul>
                        </li>
                        <li class="droplink {{ Request::is('main/users*') ? 'active open' : '' }}">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-user"></span>
                                <p>Χρήστες<br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="{{ Request::is('main/users') ? 'active' : '' }}"><a href="{{url('/main/users')}}">Προβολή Χρηστών</a></li>
                                <li class="{{ Request::is('main/users/create') ? 'active' : '' }}"><a href="{{url('/main/users/create')}}">Δημιουργία Χρήστη</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/main/sitemap/sitemap" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-list"></span>
                                <p>Σχεδιάγραμμα<br>Ιστοσελίδας</p>
                            </a>
                        </li>
                        <li class=" {{ Request::is('main/wholeTree*') ? 'active open' : '' }}">
                            <a href="/main/wholeTree" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-tree-deciduous"></span>
                                <p>Δέντρο</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Page Sidebar Inner -->
            </div>
