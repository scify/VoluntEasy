        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template"/>
        <meta name="keywords" content="admin,dashboard"/>
        <meta name="author" content="Steelcoders"/>
        <meta name="_token" content="{{ csrf_token() }}" />

        @if(env('PLATFORM_NAME')=='VoluntAction')
                <link rel="icon" type="image/png" href="{{ asset('assets/images/voluntaction/favicon.ico')}}">
        @else
                <link rel="icon" type="image/png" href="{{ asset('assets/images/volunteasy/favicon.ico')}}">
        @endif


        <!-- Styles -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="{{ asset('assets/plugins/uniform/css/uniform.default.min.css')}}" rel="stylesheet"/>
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/jonthornton-timepicker/jquery.timepicker.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/line-icons/simple-line-icons.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/waves/waves.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/slidepushmenus/css/component.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/jOrgChart/jOrgChart.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/select2/css/select2.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/vertical-timeline/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/raty/lib/jquery.raty.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/fullcalendar-2.3.2/fullcalendar.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="{{ asset('assets/css/modern.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/themes/white.css')}}" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/data-tables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/data-tables/extras/tabletools/css/dataTables.tableTools.min.css') }}" rel="stylesheet" type="text/css"/>


        <script src="{{ asset('assets/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        {{--[if lt IE 9]>--}}
        {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>--}}
        {{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
        {{--<![endif]--}}
