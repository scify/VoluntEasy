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
    @if(env('PLATFORM_NAME')=='VoluntAction')
        <link rel="icon" type="image/png" href="{{ asset('assets/images/voluntaction/favicon.ico')}}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('assets/images/volunteasy/favicon.ico')}}">
    @endif

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
                <h3>{{ trans('pages/landing.subheader') }}</h3>
                <a href="#about" class="btn pi-btn-default btn-xlg btn-border" data-scroll="about">{{ trans('pages/landing.learnMore') }}</a>
                <a href="{{ url('/') }}" target="_blank" class="btn pi-btn-default btn-xlg">{{ trans('pages/landing.tryIt') }}</a>
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
            <li class="nav"><a href="#about" data-scroll="about">About</a></li>
            <li class="nav"><a href="#solution" data-scroll="solution">One solution for multiple needs</a></li>
            <li class="nav"><a href="#keyFeatures" data-scroll="keyFeatures">Key Features</a></li>
            <li class="nav"><a href="#contact" data-scroll="contact">Contact</a></li>

        </ul>
        <!-- /Zetta Menu 1 -->
    </div><!-- /.container-fluid -->
</nav>
<!-- end nav -->

<!-- about -->
<section id="about" data-anchor="about" class="content">
    <div class="container what-we-do">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/interests.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h5>{{ trans('pages/landing.recruitAndSelect') }}</h5>
                            <p>{{ trans('pages/landing.recruitAndSelectExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/new_volunteers.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h5>{{ trans('pages/landing.manageVolunteers') }}</h5>
                            <p>{{ trans('pages/landing.manageVolunteersExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/tasks.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h5>{{ trans('pages/landing.focus') }}</h5>
                            <p>{{ trans('pages/landing.focusExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <div class="circular-img"
                             style="background-image: url({{ asset('assets/images/landing/structure.png') }});"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <h5>{{ trans('pages/landing.makeItYours') }}</h5>
                            <p>{{ trans('pages/landing.makeItYoursExpl') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of row -->
    </div><!-- end of container -->
</section>
<!-- end about -->

<!-- solution -->
<section id="solution" data-anchor="solution"  class="content-2 section-grey">
    <div class="container">
        <div class="row">
            <h3 class="text-center">{{ trans('pages/landing.oneSolutionMultipleNeeds') }}</h3>
            <div class="line"></div>
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="left_icons">
                        <div class="single_box_left default">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>{{ trans('pages/landing.collaborate') }}</h3>
                            {!! trans('pages/landing.collaborateExpl') !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="left_icons">
                        <div class="single_box_left default">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>{{ trans('pages/landing.monitor') }}</h3>
                            {!! trans('pages/landing.monitorExpl') !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="left_icons">
                        <div class="single_box_left default">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>{{ trans('pages/landing.empower') }}</h3>
                            {!! trans('pages/landing.empowerExpl') !!}
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
<!-- end solution -->


<!-- key features -->
<section id="keyFeatures" data-anchor="keyFeatures" class="content-2">
    <div class="container">
        <div class="row">
            <h2 class="text-center">{{ trans('pages/landing.keyFeatures') }}</h2>
            <div class="line"></div>
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons">
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.multipleAccounts') }}</h3>
                                <p>{!! trans('pages/landing.multipleAccountsExpl') !!}</p>
                            </div>
                            <div class="single_box_left default">
                                <i class="fa fa-sitemap"></i>
                            </div>
                        </div>
                    </div><!-- end left icon -->
                </div><!-- end col-sm-4 -->

                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-share-square-o"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.recruitment') }}</h3>
                                <p>{!! trans('pages/landing.recruitmentExpl') !!}</p>
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
                                <i class="fa fa-comments-o"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.selection') }}</h3>
                                <p>{!! trans('pages/landing.selectionExpl') !!}</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->

                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-leaf"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.volunteerManagement') }}</h3>
                                <p>{!! trans('pages/landing.volunteerManagementExpl') !!}</p>
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
                                <i class="fa fa-bullseye"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.actionsManagement') }}</h3>
                                <p>{!! trans('pages/landing.actionsManagementExpl') !!}</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.shiftManagement') }}</h3>
                                <p>{!! trans('pages/landing.shiftManagementExpl') !!}</p>
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
                                <i class="fa fa-search"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.jobFit') }}</h3>
                                <p>{!! trans('pages/landing.jobFitExpl') !!}</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.onlineCollaboration') }}</h3>
                                <p>{!! trans('pages/landing.onlineCollaborationExpl') !!}</p>
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
                                <i class="fa fa-bell"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.notifications') }}</h3>
                                <p>{!! trans('pages/landing.notificationsExpl') !!}</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->
                <div class="col-sm-6 col-md-6">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-bar-chart"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.reports') }}</h3>
                                <p>{!! trans('pages/landing.reportsExpl') !!}</p>
                            </div>
                        </div><!-- end left icon -->
                    </div>
                </div><!-- end col-sm-4 -->
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="padd">
                        <div class="left_icons border-color2">
                            <div class="single_box_left default">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <div class="single_box_right">
                                <h3>{{ trans('pages/landing.easilyCustomizable') }}</h3>
                                <p>{!! trans('pages/landing.easilyCustomizableExpl') !!}</p>
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
            <div class="col-md-12 text-center">
                <div class="padd">
                    <p class="lead"><i class="fa fa-phone margin-right-5"></i>0030 2114004192 | <i class="fa fa-map-marker margin-right-5"></i>17 Amfiktionos str, Thisseio Athens,
                        11851 | <i class="fa fa-envelope margin-right-5"></i><a
                                href="mailto:info@scify.gr">info@scify.gr</a> | <i class="fa fa-globe margin-right-5"></i><a href="http://www.scify.gr/" target="_blank">www.scify.gr</a>
                    </p>
                </div>
            </div><!-- end col-sm-5 -->


        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- end contact -->

<!-- footer -->
<footer class="dark content">
    <div class="container text-center">
        <div class="row">
            <div class="margin-top-20 margin-bottom-20">
                <a href="https://www.facebook.com/SciFY.org" target="_blank" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-facebook facebook-icon-jump"></i>
                        <i class="fa fa-facebook social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="https://twitter.com/SciFY_org" target="_blank" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-twitter twitter-icon-jump"></i>
                        <i class="fa fa-twitter social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="https://plus.google.com/u/0/109032045993620015107/posts" target="_blank" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-google-plus google-plus-icon-jump"></i>
                        <i class="fa fa-google-plus social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="http://www.linkedin.com/company/scify-not-for-profit-company/" target="_blank" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-linkedin linkedin-icon-jump"></i>
                        <i class="fa fa-linkedin social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="http://www.youtube.com/SciFYNPO" target="_blank" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-youtube youtube-icon-jump"></i>
                        <i class="fa fa-youtube social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="http://scify-org.tumblr.com/" target="_blank" class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-tumblr tumblr-icon-jump"></i>
                        <i class="fa fa-tumblr social-icon-jump-dark"></i>
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
