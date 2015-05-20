<!DOCTYPE html>
<html>
    <body>

        @if ($var != 'hello')
            <h1> "not the same word" </h1>
            <p> {{$var}} is NOT the correct word </p>
        @else
            <h1> {{$var}} </h1>
            <p> {{$var}} is the correct word </p>
        @endif
                {{--<div class="menu-wrap">--}}
                    {{--<nav class="profile-menu">--}}
                        {{--<div class="profile"><img src="" width="52" alt="David Green"/><span>David Green</span></div>--}}
                        {{--<div class="profile-menu-list">--}}
                            {{--<a href="#"><i class="fa fa-star"></i><span>Favorites</span></a>--}}
                            {{--<a href="#"><i class="fa fa-bell"></i><span>Alerts</span></a>--}}
                            {{--<a href="#"><i class="fa fa-envelope"></i><span>Messages</span></a>--}}
                            {{--<a href="#"><i class="fa fa-comment"></i><span>Comments</span></a>--}}
                        {{--</div>--}}
                    {{--</nav>--}}
                    {{--<button class="close-button" id="close-button">Close Menu</button>--}}
                {{--</div>--}}
    </body>
</html>