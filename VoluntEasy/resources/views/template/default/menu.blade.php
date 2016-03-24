<?php $lang = "templates/menu."; ?> {{--  resource label path --}}

<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <ul class="menu accordion-menu">
            <li class=" {{ Request::is('/') ? 'active open' : '' }}">
                <a href="{{url('/')}}" class="waves-effect waves-button">
                    <i class="fa fa-dashboard fa-2x"></i>

                    <p>{{trans($lang.'dashboard')}}</p>
                </a>
            </li>
            <li class="droplink {{ Request::is('units*') ? 'active open' : '' }}">
                <a class="waves-effect waves-button">
                    <i class="fa fa-home fa-2x"></i>

                    <p>{{trans($lang.'units')}}</p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('units') || Request::is('units/one*') ? 'active' : '' }}"><a
                            href="{{ url('units') }}">{{trans($lang.'showUnits')}}</a></li>
                    <li class="{{ Request::is('units/create') ? 'active' : '' }}"><a href="{{ url('units/create') }}">{{trans($lang.'createUnit')}}</a>
                    </li>
                </ul>
            </li>
            <li class="droplink {{ Request::is('actions*') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <i class="fa fa-bullseye fa-2x"></i>

                    <p>{{trans($lang.'actions')}}</p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('actions') || Request::is('actions/one*') ? 'active' : '' }}"><a
                            href="{{ url('actions') }}">{{trans($lang.'showActions')}}</a></li>
                    <li class="{{ Request::is('actions/create') ? 'active' : '' }}"><a
                            href="{{ url('actions/create') }}">{{trans($lang.'createAction')}}</a></li>
                </ul>
            </li>
            <li class="droplink {{ Request::is('collaborations*') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <i class="fa fa-users fa-2x"></i>

                    <p>{{trans($lang.'collaborations')}}</p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('collaborations') || Request::is('collaborations/one*') ? 'active' : '' }}">
                        <a href="{{ url('collaborations') }}">{{trans($lang.'showCollaborations')}}</a></li>
                    <li class="{{ Request::is('collaborations/create') ? 'active' : '' }}"><a
                            href="{{ url('collaborations/create') }}">{{trans($lang.'createCollaboration')}}</a></li>
                </ul>
            </li>
            <li class="droplink {{ Request::is('volunteers*') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <i class="fa fa-leaf fa-2x"></i>

                    <p>{{trans($lang.'volunteers')}} <br><br></p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('volunteers') || Request::is('volunteers/one*') ? 'active' : '' }}"><a
                            href="{{url('volunteers')}}">{{trans($lang.'showVolunteers')}}</a></li>
                    <li class="{{ Request::is('volunteers/create') ? 'active' : '' }}"><a
                            href="{{url('volunteers/create')}}">{{trans($lang.'createVolunteer')}}</a></li>
                    <!--li class="{{ Request::is('volunteers/create') ? 'active' : '' }}"><a href="#">{{trans($lang.'volunteerStatistcs')}}</a></li-->
                </ul>
            </li>
            <li class="droplink {{ Request::is('users') || Request::is('users/create') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <i class="fa fa-user fa-2x"></i>

                    <p>{{trans($lang.'users')}}<br><br></p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('users')  || Request::is('users/one*') ? 'active' : '' }}"><a
                            href="{{url('users')}}">{{trans($lang.'showUsers')}}</a></li>
                    <li class="{{ Request::is('users/create') ? 'active' : '' }}"><a href="{{url('users/create')}}">{{trans($lang.'createUser')}}</a>
                    </li>
                </ul>
            </li>
            {{--
            <li class=" {{ Request::is('*tasks*') ? 'active open' : '' }}">
                <a href="{{ url('users/one/'.Auth::user()->id.'/tasks') }}" class="waves-effect waves-button">
                    <i class="fa fa-tasks fa-2x"></i>

                    <p>{{trans($lang.'tasks')}}</p>
                </a>
            </li>
            --}}
            <li class=" {{ Request::is('reports*') ? 'active open' : '' }}">
                <a href="{{url('reports')}}" class="waves-effect waves-button">
                    <i class="fa fa-bar-chart fa-2x"></i>

                    <p>{{trans($lang.'reports')}}</p>
                </a>
            </li>
            <li class=" {{ Request::is('wholeTree*') ? 'active open' : '' }}">
                <a href="{{url('wholeTree')}}" class="waves-effect waves-button">
                    <i class="fa fa-tree fa-2x"></i>

                    <p>{{trans($lang.'tree')}}</p>
                </a>
            </li>
        </ul>
    </div>
    <!-- Page Sidebar Inner -->
</div>
