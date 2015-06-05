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
                                <li>{!! link_to('main/organizationalUnits/unitEntry', 'Καταχώρηση Μονάδας') !!}</li>
                                <li>{!! link_to('main/organizationalUnits/listview', 'Προβολή λίστας-Αναζήτηση') !!}</li>
                                <li>{!! link_to('main/organizationalUnits/modifications', 'Τροποποίηση') !!}</li>
                                <li>{!! link_to('main/organizationalUnits/overview', 'Επισκόπηση') !!}</li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-user"></span>
                                <p>Δράσεις &<br>Προγράμματα</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="{{url('/main/actionsPrograms/actionListing')}}">Καταχώρηση Δράσης</a></li>
                                <li><a href="/main/actionsPrograms/listview">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="/main/actionsPrograms/modifications">Τροποποίηση</a></li>
                                <li><a href="/main/actionsPrograms/overview">Επισκόπηση</a></li>
                            </ul>
                        </li>
                        <li class="droplink">
                            <a href="#" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-envelope"></span>
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
                                <span class="menu-icon glyphicon glyphicon-briefcase"></span>
                                <p>Χρήστες<br><br></p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="/main/users/userListing">Καταχώρηση χρήστη</a></li>
                                <li><a href="/main/users/listview">Προβολή λίστας-Αναζήτηση</a></li>
                                <li><a href="/main/users/modifications">Τροποποίηση</a></li>
                                <li><a href="/main/users/overview">Επισκόπηση</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/main/sitemap/sitemap" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-list"></span>
                                <p>Σχεδιάγραμμα<br>Ιστοσελίδας</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Page Sidebar Inner -->
            </div>