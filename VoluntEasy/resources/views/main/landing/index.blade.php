<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.platform_name') }}</title>
    <meta charset="utf-8">
    <meta name="description" content="VoluntAction - volunteers platform">
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
    @if(config('app.platform_name')=='VoluntAction')
    <link rel="icon" type="image/png" href="{{ asset('assets/images/voluntaction/favicon.ico')}}">
    @else
    <link rel="icon" type="image/png" href="{{ asset('assets/images/volunteasy/favicon.ico')}}">
    @endif



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
                <a href="#about" class="btn pi-btn-default btn-xlg btn-border" data-scroll="about">{{
                    trans('pages/landing.learnMore') }}</a>
                <a href="{{ url('/') }}" target="_blank" class="btn pi-btn-default btn-xlg">{{
                    trans('pages/landing.tryIt') }}</a>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</header>
<!-- end header -->

<!-- start Navigation -->
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Zetta Menu -->
        <ul id="nav" onClick="" class="zetta-menu zm-response-switch zm-full-width zm-effect-slide-top">
            <!-- LOGO -->
            <li class="zm-logo">
                @if(config('app.platform_name')=='VoluntAction')
                <img src="{{ asset('assets/images/voluntaction/logo.png') }}" style="height:100%;"/>
                @else
                <img src="{{ asset('assets/images/volunteasy/logo.png') }}" style="height:100%;"/>
                @endif
                </a>
            </li>
            <!-- end LOGO -->
            <li class="nav"><a href="#about" data-scroll="about">About</a></li>
            <li class="nav"><a href="#solution" data-scroll="solution">One solution for multiple needs</a></li>
            <li class="nav"><a href="#keyFeatures" data-scroll="keyFeatures">Key Features</a></li>
            <li class="nav"><a href="#video" data-scroll="video">Usage video</a></li>
            <li class="nav"><a href="#pricing" data-scroll="pricing">Pricing</a></li>
            <li class="nav"><a href="#contact" data-scroll="contact">Contact</a></li>

        </ul>
        <!-- /Zetta Menu 1 -->
    </div>
    <!-- /.container-fluid -->
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
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container -->
</section>
<!-- end about -->

<!-- solution -->
<section id="solution" data-anchor="solution" class="content-2 section-grey">
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
                            <i class="fa fa-line-chart"></i>
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
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="single_box_right">
                            <h3>{{ trans('pages/landing.empower') }}</h3>
                            {!! trans('pages/landing.empowerExpl') !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-sm-6 -->

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
            </div>
            <!-- end col-sm-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
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
                    </div>
                    <!-- end left icon -->
                </div>
                <!-- end col-sm-4 -->

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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->

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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
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
                        </div>
                        <!-- end left icon -->
                    </div>
                </div>
                <!-- end col-sm-4 -->
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end services -->

<!-- usage video -->
<section id="video" data-anchor="video" class="content-2 section-grey">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Usage video - Take a glimpse</h1>

            <div class="line"></div>
            <div class="col-md-12 text-center">
                <div class="padd">
                    <iframe width="1000" height="500" src="https://www.youtube.com/embed/FosO0VOo0Bw" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            </div>
            <!-- end col-sm-5 -->


        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end video -->

<!-- pricing -->
<section id="pricing" data-anchor="pricing" class="content-2 section-grey">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Pricing</h1>

            <div class="line"></div>
            <div class="col-md-12 text-center">
                <div class="padd">
                    <p class="lead text-center margin-bottom-45">
                        For free as open source<br/>
                        or a small fee for setup, customization and training
                    </p>
                </div>
            </div>
            <!-- end col-sm-5 -->


        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end pricing -->

<!-- contact -->
<section id="contact" data-anchor="contact" class="content-2 section-grey">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Get In Touch</h1>

            <div class="line"></div>
            <div class="col-md-12 text-center">
                <div class="padd">
                    <p class="lead"><i class="fa fa-phone margin-right-5"></i>+30 2114004192 | <i
                            class="fa fa-map-marker margin-right-5"></i>17 Amfiktionos str, Thisseio Athens,
                        11851 | <i class="fa fa-envelope margin-right-5"></i><a
                            href="mailto:info@scify.gr">info@scify.gr</a> | <i class="fa fa-globe margin-right-5"></i><a
                            href="http://www.scify.gr/" target="_blank">www.scify.gr</a>
                    </p>
                </div>
            </div>
            <!-- end col-sm-5 -->


        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
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
                <a href="https://plus.google.com/u/0/109032045993620015107/posts" target="_blank"
                   class="social-icon-jump-x4 circle">
                    <div>
                        <i class="fa fa-google-plus google-plus-icon-jump"></i>
                        <i class="fa fa-google-plus social-icon-jump-dark"></i>
                    </div>
                </a>
                <a href="http://www.linkedin.com/company/scify-not-for-profit-company/" target="_blank"
                   class="social-icon-jump-x4 circle">
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
            </div>
            <p>2016 &copy; <a href="http://scify.org" target="_blank">SciFY</a></p>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nav = document.querySelector('nav.navbar');
        var navLinks = Array.prototype.slice.call(document.querySelectorAll('#nav li.nav'));
        var sections = Array.prototype.slice.call(document.querySelectorAll('section[data-anchor]'));
        var header = document.querySelector('.parallaxBg');

        // sticky menu
        nav.style.position = 'sticky';
        nav.style.top = '0';

        // the menu links scroll smoothly to their section
        Array.prototype.forEach.call(document.querySelectorAll('#nav a'), function (link) {
            link.addEventListener('click', function (event) {
                var section = document.querySelector('section[data-anchor="' + link.getAttribute('data-scroll') + '"]');
                if (!section) return;
                event.preventDefault();
                window.scrollTo({top: section.getBoundingClientRect().top + window.pageYOffset - 69, behavior: 'smooth'});
            });
        });

        function onScroll() {
            var scrollTop = window.pageYOffset;

            // the menu item of the section on the screen is active
            navLinks.forEach(function (li) { li.classList.remove('zm-active'); });
            if (scrollTop >= 100) {
                var current = -1;
                sections.forEach(function (section, i) {
                    if (section.getBoundingClientRect().top + scrollTop <= scrollTop + 71) current = i;
                });
                if (navLinks[current]) navLinks[current].classList.add('zm-active');
            }

            // parallax background of the header
            if (header && header.getBoundingClientRect().bottom > 0) {
                header.style.backgroundPosition = '50% ' + Math.round((header.offsetTop - scrollTop) * 0.4) + 'px';
            }
        }
        window.addEventListener('scroll', onScroll, {passive: true});
        onScroll();

        // carousel of the screenshots: one image at a time, with dots
        Array.prototype.forEach.call(document.querySelectorAll('.owl-carousel'), function (carousel) {
            var items = Array.prototype.slice.call(carousel.children);
            if (!items.length) return;
            var current = 0;
            var outer = document.createElement('div');
            outer.className = 'owl-wrapper-outer autoHeight';
            var wrapper = document.createElement('div');
            wrapper.className = 'owl-wrapper';
            wrapper.style.display = 'block';
            wrapper.style.transition = 'left 300ms ease';
            items.forEach(function (item) { wrapper.appendChild(item); });
            outer.appendChild(wrapper);

            var controls = document.createElement('div');
            controls.className = 'owl-controls clickable';
            var pagination = document.createElement('div');
            pagination.className = 'owl-pagination';
            var pages = items.map(function (item, index) {
                var page = document.createElement('div');
                page.className = 'owl-page';
                page.setAttribute('role', 'button');
                page.setAttribute('aria-label', String(index + 1));
                page.appendChild(document.createElement('span'));
                page.addEventListener('click', function () { go(index); });
                pagination.appendChild(page);
                return page;
            });
            controls.appendChild(pagination);
            carousel.appendChild(outer);
            carousel.appendChild(controls);
            carousel.style.display = 'block';

            function layout() {
                var width = carousel.clientWidth;
                wrapper.style.width = (width * items.length * 2) + 'px';
                items.forEach(function (item) { item.style.width = width + 'px'; });
                wrapper.style.left = (-current * width) + 'px';
                outer.style.height = items[current].offsetHeight + 'px';
            }

            function go(index) {
                current = (index + items.length) % items.length;
                pages.forEach(function (page, i) { page.classList.toggle('active', i === current); });
                layout();
            }

            // swipe with the mouse or the finger
            var startX = null;
            outer.addEventListener('pointerdown', function (event) { startX = event.clientX; });
            outer.addEventListener('pointerup', function (event) {
                if (startX === null) return;
                var dx = event.clientX - startX;
                startX = null;
                if (Math.abs(dx) > 50) go(current + (dx < 0 ? 1 : -1));
            });
            outer.addEventListener('dragstart', function (event) { event.preventDefault(); });

            window.addEventListener('resize', layout);
            window.addEventListener('load', layout);
            go(0);
        });
    });
</script>

</body>
</html>
