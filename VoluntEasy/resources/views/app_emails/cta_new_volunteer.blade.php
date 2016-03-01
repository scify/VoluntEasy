<!doctype html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Νέος Εθελοντής για τη Δράση</title>
    <style>
        /* -------------------------------------
            GLOBAL
        ------------------------------------- */
        * {
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            font-size: 100%;
            line-height: 1.6em;
            margin: 0;
            padding: 0;
        }

        body {
            -webkit-font-smoothing: antialiased;
            height: 100%;
            -webkit-text-size-adjust: none;
            width: 100% !important;
        }

        /* -------------------------------------
            ELEMENTS
        ------------------------------------- */
        a {
            color: #348eda;
        }

        .btn-primary {
            Margin-bottom: 10px;
            width: auto !important;
        }

        .btn-primary td {
            background-color: #348eda;
            border-radius: 25px;
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-size: 14px;
            text-align: center;
            vertical-align: top;
        }

        .btn-primary td a {
            background-color: #348eda;
            border: solid 1px #348eda;
            border-radius: 25px;
            border-width: 10px 20px;
            display: inline-block;
            color: #ffffff;
            cursor: pointer;
            font-weight: bold;
            line-height: 2;
            text-decoration: none;
        }

        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .padding {
            padding: 10px 0;
        }

        /* -------------------------------------
            BODY
        ------------------------------------- */
        table.body-wrap {
            padding: 20px;
            width: 100%;
        }

        table.body-wrap .container {
            border: 1px solid #f0f0f0;
        }

        /* -------------------------------------
            FOOTER
        ------------------------------------- */
        table.footer-wrap {
            clear: both !important;
            width: 100%;
        }

        .footer-wrap .container p {
            color: #666666;
            font-size: 12px;

        }

        table.footer-wrap a {
            color: #999999;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3 {
            color: #111111;
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-weight: 200;
            line-height: 1.2em;
            margin: 40px 0 10px;
        }

        h1 {
            font-size: 36px;
        }

        h2 {
            font-size: 28px;
        }

        h3 {
            font-size: 22px;
        }

        p,
        ul,
        ol {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 10px;
        }

        ul li,
        ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        .text-success {
            color: #22BAA0;
        }

        .text-danger {
            color: #f25656;
        }

        /* ---------------------------------------------------
            RESPONSIVENESS
        ------------------------------------------------------ */

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            clear: both !important;
            display: block !important;
            Margin: 0 auto !important;
            max-width: 600px !important;
        }

        /* Set the padding on the td rather than the div for Outlook compatibility */
        .body-wrap .container {
            padding: 20px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            display: block;
            margin: 0 auto;
            max-width: 600px;
        }

        /* Let's make sure tables in the content area are 100% wide */
        .content table {
            width: 100%;
        }

    </style>
</head>

<body bgcolor="#F1F4F9">

<!-- body -->
<table class="body-wrap" bgcolor="#F1F4F9">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td>
                            <center>
                                <a href="{{ URL::to('/') }}"
                                   class="logo-name text-lg text-center"> <img
                                        src="{{ asset('assets/images/logo.png') }}" style="height:100%;"/>
                                </a>
                                <h4>Πλατφόρμα Διαχείρισης Εθελοντών</h4>
                            </center>

                            @if($user->name!=null && $user->name!='')
                            <p>Αγαπητέ {{ $user->name }},</p>
                            @endif

                            <p>Ένας νέος εθελοντής δήλωσε ενδιαφέρον στη δράση <strong><a href="{{ URL::to('/') }}/actions/one/{{ $publicAction->action->id }}" target="_blank">{{$publicAction->action->description}}</a></strong>.</p>

                            <p>Όνομα: {{ $ctaVolunteer->first_name }} {{ $ctaVolunteer->last_name }}</p>
                            <p>Email: {{ $ctaVolunteer->email }}</p>
                            <p>Σχόλια: {{ $ctaVolunteer->comments }}</p>

                            @if($ctaVolunteer->isVolunteer)
                            <p class="text-success">Ο εθελοντής υπάρχει ήδη στην πλατφόρμα! Μπορείτε να τον αναθέσετε
                                στη δράση, εφόσον βρίσκεται στην κατάλληλη μονάδα. Δείτε το προφίλ του <a href="{{ URL::to('/') }}/volunteers/one/{{ $volunteer->id }}" target="_blank">εδώ</a>.</p>
                            @else
                            <p class="text-danger">Δεν βρέθηκε εθελοντής με αυτό το email στην πλατφόρμα. Αν δεν
                                υπάρχει σε αυτή, θα πρέπει να γίνει δημιουργία του προφίλ του και να περάσει από
                                συνέντευξη.</p>
                            @endif

                            @foreach($ctaVolunteer->dates as $date)

                             <h4>Task {{ $date->date->subtask->task->name }} / Subtask {{ $date->date->subtask->name }}</h4>
                             <p>{{ $date->date->from_date }}, {{ $date->date->from_hour }}-{{$date->date->to_hour }}</p>

                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->
        </td>
    </tr>
</table>
</body>
</html>

