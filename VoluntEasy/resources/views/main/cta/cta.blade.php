<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>{{ trans('entities/cta.cta') }} | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login cta" data-url="{!! URL::to('/') !!}">
<main class="page-content">
<div class="page-inner">
<div id="main-wrapper">
<div class="row">
<div class="col-md-8 center">
<h4 class="text-right">{{ trans('entities/cta.sample') }} </h4>

<div class="panel panel-white">
<div class="panel-body">

<div class="row">
    <div class="col-md-4">
        <img src="{{ asset('assets/images/cta_logo.png') }}"/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2>{{ trans('entities/cta.callVolunteersToAction') }}  <strong>Bazaar</strong></h2>

        <p>{{ trans('entities/cta.from') }} <strong>22/02/2016</strong> {{ trans('entities/cta.to') }}
            <strong>24/02/2016</strong> στην <a href="#">Τεχνόπολη</a></p>

        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
            veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
            voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque
            porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci
            velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore
            magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
            consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit
            esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo
            voluptas nulla pariatur?</p>

        <p>{{ trans('entities/cta.exec') }}: Test Test, 210-123456789, <a href="mailto:info@test.gr">info@test
                .gr</a>
        </p>
    </div>
</div>

<table class="table tasks">
    <tr>
        <td colspan="2">
            <div class="task-info">
                <h3>Υποδοχή</h3>

                <p> USC ALUMNI CENTER, 1st Floor Ballroom</p>
            </div>
        </td>
    </tr>
    <tr>
        <td class="task col-md-3">
            <div class="subtask-info">Άνοιγμα πόρτας</div>
        </td>
        <td class="taskDate">
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">09:00-11:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">11:00-13:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">13:00-15:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">15:00-17:00
                                                </span>
                    <br/><span class="text-success">3/3 {{ trans('entities/cta.volunteers') }}</span></label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="task col-md-3">
            <div class="subtask-info">Μοίρασμα φυλλαδίων</div>
        </td>
        <td class="taskDate">
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">09:00-13:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">13:00-17:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
        </td>
    </tr>
</table>


<table class="table tasks">
    <tr>
        <td colspan="2">
            <div class="task-info">
                <h3>Ταμείο</h3>

                <p> USC ALUMNI CENTER, 1st Floor Ballroom</p>
            </div>
        </td>
    </tr>
    <tr>
        <td class="task col-md-3">
            <div class="subtask-info">Ταμείο</div>
        </td>
        <td class="taskDate">
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">09:00-11:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">11:00-13:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">13:00-15:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 <br/>  <span class="hours">15:00-17:00
                                                </span>
                    <br/><span class="text-success">3/3 {{ trans('entities/cta.volunteers') }}</span></label>
            </div>
        </td>
    </tr>
</table>


<table class="table tasks">
    <tr>
        <td colspan="2">
            <div class="task-info">
                <h3>Επικοινωνία</h3>

                <p> USC ALUMNI CENTER, 1st Floor Ballroom</p>
            </div>
        </td>
    </tr>
    <tr>
        <td class="task col-md-3">
            <div class="subtask-info">Social Media</div>
        </td>
        <td class="taskDate">
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>22/02/2016 - 26/02/2016<br/>  <span class="hours">09:00-11:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>

        </td>
    </tr>
    <tr>
        <td class="task col-md-3">
            <div class="subtask-info">Σχεδίαση γραφικών</div>
        </td>
        <td class="taskDate">
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>20/02/2016<br/>  <span class="hours">09:00-11:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="task col-md-3">
            <div class="subtask-info">Σχεδίαση γραφικών</div>
        </td>
        <td class="taskDate">
            <div class="dateTime">
                <input type="checkbox" class="form-control">
                <label>20/02/2016<br/>  <span class="hours">09:00-11:00
                                                </span>
                    <br/>1/3 {{ trans('entities/cta.volunteers') }}</label>
            </div>
        </td>
    </tr>
</table>


</div>
</div>
</div>
</div>
<!-- Row -->
</div>
<!-- Main Wrapper -->
</div>
<!-- Page Inner -->
</main>
<!-- Page Content -->
@include('template.default.footerIncludes')
@yield('footerScripts')
</body>
</html>
