<div class="page-sidebar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    <ul class="menu accordion-menu">
                        <li class="droplink">
                            <a class="waves-effect waves-button"><span
                                    class="menu-icon glyphicon glyphicon-home"></span>
                                <p>Οργανωτικές<br>Μονάδες</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('main/units') }}">Προβολή Μονάδων</a></li>
                                <li><a href="{{ url('main/units/create') }}">Δημιουργία Μονάδας</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-bookmark"></span>
                                <p>Δράσεις &<br>Προγράμματα</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="{{ url('main/actions') }}">Προβολή Δράσεων</a></li>
                                <li><a href="{{ url('main/actions/create') }}">Δημιουργία Δράσης</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-leaf"></span>
                                <p>Εθελοντές <br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="/main/volunteers/listview">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="/main/volunteers/statistics">Στατιστικές Αναλύσεις</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-user"></span>
                                <p>Χρήστες<br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="{{url('/main/users')}}">Προβολή Χρηστών</a></li>
                                <li><a href="{{url('/main/users/create')}}">Δημιουργία Χρήστη</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/main/sitemap/sitemap" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-list"></span>
                                <p>Σχεδιάγραμμα<br>Ιστοσελίδας</p>
                            </a>
                        </li>
                        <li>
                            <a href="/main/units/wholeTree" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-tree-deciduous"></span>
                                <p>Δέντρο</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Page Sidebar Inner -->
            </div>
