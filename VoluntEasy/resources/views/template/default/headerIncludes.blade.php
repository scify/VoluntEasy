        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="{{ config('app.platform_name') }}: volunteer management"/>
        <meta name="_token" content="{{ csrf_token() }}" />

        @if(config('app.platform_name')=='VoluntAction')
                <link rel="icon" type="image/png" href="{{ asset('assets/images/voluntaction/favicon.ico')}}">
        @else
                <link rel="icon" type="image/png" href="{{ asset('assets/images/volunteasy/favicon.ico')}}">
        @endif


        <!-- Styles -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/line-icons/simple-line-icons.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/slidepushmenus/css/component.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/jOrgChart/jOrgChart.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/vertical-timeline/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/vendor/tom-select/tom-select.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Theme Styles -->
        <link href="{{ asset('assets/css/modern.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/themes/white.css')}}" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/ve.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/data-tables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/data-tables/extras/tabletools/css/dataTables.tableTools.min.css') }}" rel="stylesheet" type="text/css"/>


        <script src="{{ asset('assets/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>
