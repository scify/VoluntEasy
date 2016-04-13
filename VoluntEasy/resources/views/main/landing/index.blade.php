<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ trans('pages/landing.title') }}</title>
    <meta charset="utf-8">
    <meta name="description" content="VoluntEasy - volunteers platform">
    <meta name="author" content="SciFY"/>
    <meta name="keywords" content="scify, volunteers"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons/FontAwesome -->
    <link href="{{ asset('assets/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
    <!-- owl carusel -->
    <link href="{{ asset('assets/css/landing/owl.carousel.css')}}" rel="stylesheet" type="text/css"/>
    <!-- zetta menu -->
    <link href="{{ asset('assets/css/landing/zetta-menu.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- layerSlider -->
    <link href="{{ asset('assets/css/landing/layerslider.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Animation -->
    <link href="{{ asset('assets/css/landing/animate.css')}}" rel="stylesheet" type="text/css"/>
    <!-- cubeportfolio -->
    <link href="{{ asset('assets/css/landing/cubeportfolio.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/landing/main.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Customizable CSS -->
    <link href="{{ asset('assets/css/landing/style.css')}}" rel="stylesheet" type="text/css"/>

    <!-- FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico')}}">

    <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/js/landing/html5shiv.js')}}"></script>
    <script src="{{ asset('assets/js/landing/respond.min.js')}}"></script>

    <![endif]-->

</head>

<body id="onepage">

<!-- heaqder -->
<header class="home section-parallax parallaxBg"
        style="background-image: url({{ asset('assets/images/landing/pexels-photo-69133.jpeg') }});">
    <div class="layer"></div>
    <div class="container parallax-content">
        <div class="row">
            <div class="col-sm-12">
                <h2>{{ trans('pages/landing.header') }}</h2>
                <p></p>
                <a href="#" class="btn pi-btn-default btn-xlg btn-border">{{ trans('pages/landing.learnMore') }}</a>
                <a href="{{ url('/') }}" class="btn pi-btn-default btn-xlg">{{ trans('pages/landing.tryIt') }}</a>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
</header>
<!-- end header -->

<!-- start Navigation -->
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Zetta Menu -->
        <ul id="nav" onClick="" class="zetta-menu zm-response-switch zm-full-width zm-effect-slide-top">
            <!-- LOGO -->
            <li class="zm-logo">
                <a href="#onepage"><img src="{{ asset('assets/images/logo_150w.png') }}" style="height:100%;"/>
                </a>
            </li>
            <!-- end LOGO -->
            <li class="nav"><a href="#" data-scroll="about-us">About Us</a></li>
            <li class="nav"><a href="#" data-scroll="services">Services</a></li>
            <li class="nav"><a href="#" data-scroll="contact">Contact</a></li>

        </ul>
        <!-- /Zetta Menu 1 -->
    </div><!-- /.container-fluid -->
</nav>
<!-- end nav -->

<!-- what-we-do -->
<section id="about-us" data-anchor="about-us" class="content">
    <div class="container what-we-do">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/structure.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h4>{{ trans('pages/landing.customStructure') }}</h4>
                            <p>{{ trans('pages/landing.customStructureExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/new_volunteers.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h4>{{ trans('pages/landing.createVolunteers') }}</h4>
                            <p>{{ trans('pages/landing.createVolunteersExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/tasks.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h4>{{ trans('pages/landing.createTasks') }}</h4>
                            <p>{{ trans('pages/landing.createTasksExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of row -->
    </div><!-- end of container -->
</section>
<!-- end of what-we-do -->

<!-- our vision -->
<section class="content-2 section-grey">
    <div class="container">
        <div class="row">
            <h3 class="text-center">Why you need VoluntEasy</h3>
            <div class="line"></div>

            <p class="lead text-center margin-bottom-45">Contrary to <b>popular</b> belief, Lorem Ipsum is not simply
                random text. <br/>
                It has roots in piece of <b>classical</b>.</p>

            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="left_icons">
                        <div class="single_box_left default">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>Share with people in your org</h3>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt ut labore et dolore.
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="left_icons">
                        <div class="single_box_left default">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>8 Skin Color</h3>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt ut labore et dolore.
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="left_icons">
                        <div class="single_box_left default">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>Easy to use</h3>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt ut labore et dolore.
                        </div>
                    </div>
                </div>
            </div><!-- end col-sm-6 -->

            <div class="col-sm-6">

                <div class="owl-carousel owl-item-1 owl-theme">
                    <div class="owl-item">
                        <img src="{{ asset('assets/images/landing/screen_01.png') }}" alt=""/>
                    </div>
                    <div class="owl-item">
                        <img src="{{ asset('assets/images/landing/screen_02.png') }}" alt=""/>
                    </div>
                    <div class="owl-item">
                        <img src="{{ asset('assets/images/landing/screen_03.png') }}" alt=""/>
                    </div>


                </div>

            </div><!-- end col-sm-6 -->

        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- end our vision -->


<!-- services -->
<section id="services" data-anchor="services" class="content-2">
    <div class="container">
        <div class="row">
            <h2 class="text-center">Features</h2>
            <div class="line"></div>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons">
                            <div class="single_box_left default">
                                <i class="fa fa-leaf"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>Volunteer Managment</h3>
                                <p>Create volunteer profiles based on their information</p>
                                <p>Keep track of the interview notes</p>
                                <p>Be up-to-date of their status by viewing their history</p>
                            </div>
                        </div>
                    </div><!-- end left icon -->
                </div><!-- end col-sm-4 -->

                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-bullseye"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>Actions management</h3>
                                <p>Create actions and tasks</p>
                                <p>Assign volunteers to shifts, keep track of the total hours they worked</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-sitemap"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>Units</h3>
                                <p>Create the structure for your organization and assign users to units.</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->

                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-bell"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>Notifications</h3>
                                <p>You will never miss an important event again. Helpful notifications keep you updated
                                    about all you need to know.</p>
                            </div>
                        </div>
                    </div><!-- end left icon -->
                </div><!-- end col-sm-4 -->
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-pie-chart"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>Reports</h3>
                                <p>Reports inform you about volunteers statistics</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->

                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>Customizable</h3>
                                <p>Easy to customize and extend</p>
                                <p>Customize the volunteer form to your needs</p>
                                <p>Easy to translate to other languages</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- end services -->


<!-- contact -->
<section id="contact" data-anchor="contact" class="content-2 section-grey">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Get In Touch</h1>
            <div class="line"></div>

            <p class="lead text-center margin-bottom-45">Contrary to popular belief, Lorem Ipsum is not simply random
                text.<br/>It has roots in piece of classical.</p>

            <div class="col-sm-5">
                <div class="padd">
                    <p class="lead"><i class="fa fa-phone margin-right-5"></i>0030 2114004192</p>
                    <p class="lead"><i class="fa fa-map-marker margin-right-5"></i>17 Amfiktionos str, Thisseio<br/>Athens,
                        11851</p>
                    <p class="lead"><i class="fa fa-envelope margin-right-5"></i><a
                                href="mailto:info@scify.gr">info@scify.gr</a></p>
                    <p class="lead"><i class="fa fa-globe margin-right-5"></i><a href="http://www.scify.gr/">www.scify.gr</a>
                    </p>
                </div>
            </div><!-- end col-sm-5 -->

            <div class="col-sm-7">
                <div class="padd">
                    <form role="form">

                        <div class="col-sm-6 col-xs-12 col-md-6">
                            <div class="form-group">
                                <input type="text" id="first-name-example-1" class="form-control"
                                       placeholder="e.g John Doe">
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12 col-md-6">
                            <div class="form-group">
                                <input type="text" id="email-example-1" class="form-control"
                                       placeholder="e.g mail@example.com">
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <textarea class="form-control" id="exampleMessage-3" placeholder="How can help you!"
                                          rows="6"></textarea>
                                <a href="#" class="btn btn-lg pi-btn-default no-rounded">Send Message<i
                                            class="fa fa-paper-plane"></i></a>
                            </div>
                        </div>

                    </form>

                </div>
            </div><!-- end col-sm-7 -->

        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- end contact -->

<!-- footer -->
<footer class="dark content">
    <div class="container text-center">
        <div class="row">
            <div class="margin-top-20 margin-bottom-20">
                <a href="#" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-facebook facebook-icon-jump"></i>
                        <i class="fa fa-facebook social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="#" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-twitter twitter-icon-jump"></i>
                        <i class="fa fa-twitter social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="#" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-dribbble dribbble-icon-jump"></i>
                        <i class="fa fa-dribbble social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="#" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-linkedin linkedin-icon-jump"></i>
                        <i class="fa fa-linkedin social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="#" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-youtube youtube-icon-jump"></i>
                        <i class="fa fa-youtube social-icon-jump-dark"></i>
                    </div>
                </a>
            </div>
            <p>2016 &copy; <a href="http://scify.org" target="_blank">SciFY</a></p>
        </div><!-- end row -->
    </div><!-- end container -->
</footer>

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery-2.1.3.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/landing/jquery.easing.min.js')}}"></script>
<script src="{{ asset('assets/js/landing/jquery.fitvids.js')}}"></script>
<script src="{{ asset('assets/js/landing/owl.carousel.js')}}"></script>
<!--<script src="js/jquery.ui.totop.min.js"></script>-->
<script src="{{ asset('assets/js/landing/jquery.countTo.js')}}"></script>
<script src="{{ asset('assets/js/landing/jquery.placeholder.js')}}"></script>
<script src="{{ asset('assets/js/landing/jquery.parallax-1.1.3.js')}}"></script>
<script src="{{ asset('assets/js/landing/wow.min.js')}}"></script>
<script src="{{ asset('assets/js/landing/jquery.sticky.js')}}"></script>
<script src="{{ asset('assets/js/landing/jquery.cubeportfolio.min.js')}}"></script>
<script src="{{ asset('assets/js/landing/lightbox-gallery.js')}}"></script>
<script src="{{ asset('assets/js/landing/main.js')}}"></script>


<script>
    //Animation Wow.js
    new WOW().init();

    //sticky menu
    $(".navbar").sticky({topSpacing: 0});

</script>

<script>
    $(document).ready(function () {
        $('#nav a').on('click', function () {
            var scrollAnchor = $(this).attr('data-scroll'),
                    scrollPoint = $('section[data-anchor="' + scrollAnchor + '"]').offset().top - 69;
            $('body,html').animate({
                scrollTop: scrollPoint
            }, 500);
            return false;
        })
        $(window).scroll(function () {
            var windscroll = $(window).scrollTop();
            if (windscroll >= 100) {
                $('section[data-anchor]').each(function (i) {
                    if ($(this).position().top <= windscroll + 71) {
                        $('#nav li.zm-active').removeClass('zm-active');
                        $('#nav li.nav').eq(i).addClass('zm-active');
                    }
                });
            } else {
                $('#nav li.zm-active').removeClass('zm-active');
            }
        }).scroll();
    });
</script>

</body>
</html>
