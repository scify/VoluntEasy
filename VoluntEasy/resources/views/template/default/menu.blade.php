<?php  $lang = "templates/menu."; ?> {{--  resource label path --}}

<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <ul class="menu accordion-menu">
            <li class="droplink {{ Request::is('units*') ? 'active open' : '' }}">
                <a class="waves-effect waves-button"><span
                        class="menu-icon glyphicon glyphicon-home"></span>
                    <p>{{trans($lang.'units')}}</p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('units') ? 'active' : '' }}"><a href="{{ url('units') }}">{{trans($lang.'showUnits')}}</a></li>
                    <li class="{{ Request::is('units/create') ? 'active' : '' }}"><a href="{{ url('units/create') }}">{{trans($lang.'createUnit')}}</a></li>
                </ul>
            </li>
            <li class="droplink {{ Request::is('actions*') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-bookmark"></span>
                    <p>{{trans($lang.'actions')}}</p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('actions') ? 'active' : '' }}"><a href="{{ url('actions') }}">{{trans($lang.'showActions')}}</a></li>
                    <li class="{{ Request::is('actions/create') ? 'active' : '' }}"><a href="{{ url('actions/create') }}">{{trans($lang.'createAction')}}</a></li>
                </ul>
            </li>
            <li class="droplink {{ Request::is('volunteers*') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-leaf"></span>
                    <p>{{trans($lang.'volunteers')}} <br><br></p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('volunteers') ? 'active' : '' }}"><a href="{{url('volunteers')}}">{{trans($lang.'showVolunteers')}}</a></li>
                    <li class="{{ Request::is('volunteers/create') ? 'active' : '' }}"><a href="{{url('volunteers/create')}}">{{trans($lang.'createVolunteer')}}</a></li>
                    <li class="{{ Request::is('volunteers/create') ? 'active' : '' }}"><a href="#">{{trans($lang.'volunteerStatistcs')}}</a></li>
                </ul>
            </li>
            <li class="droplink {{ Request::is('users*') ? 'active open' : '' }}">
                <a href="#" class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-user"></span>
                    <p>{{trans($lang.'users')}}<br><br></p>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('users') ? 'active' : '' }}"><a href="{{url('users')}}">{{trans($lang.'showUsers')}}</a></li>
                    <li class="{{ Request::is('users/create') ? 'active' : '' }}"><a href="{{url('users/create')}}">{{trans($lang.'createUser')}}</a></li>
                </ul>
            </li>
            <li class=" {{ Request::is('wholeTree*') ? 'active open' : '' }}">
                <a href="{{url('wholeTree')}}" class="waves-effect waves-button">
                    <span class="menu-icon glyphicon glyphicon-tree-deciduous"></span>
                    <p>{{trans($lang.'tree')}}</p>
                </a>
            </li>
        </ul>
    </div>
    <!-- Page Sidebar Inner -->
</div>
