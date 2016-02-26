<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>Call to action | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login cta" data-url="{!! URL::to('/') !!}">
<main class="page-content">
<div class="page-inner">
<div id="main-wrapper">
<div class="row">
<div class="col-md-8 center">
<h4 class="text-right">Δείγμα δημόσια σελίδας</h4>

<div class="panel panel-white">
    <div class="panel-body">

        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('assets/images/ekpizo.png') }}" style="width:100%;"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Κάλεσμα εθελοντών στη δράση <strong>Bazaar</strong></h2>

                <p>Από <strong>22/02/2016</strong> έως
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

                <p>Υπεύθυνος επικοινωνίας: Test Test, 210-123456789, <a href="mailto:info@test.gr">info@test
                        .gr</a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="circle">Βήμα 1:<br/> Ενημερωθείτε για τη δράση</div>
            </div>
            <div class="col-md-2">
                <div class="circle">Βήμα 2:<br/> Επιλέξτε τις κατάλληλες για εσάς θέσεις</div>

            </div>
            <div class="col-md-2">
                <div class="circle">Βήμα 3:<br/> Αποστείλλετε τη φόρμα</div>
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
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">11:00-13:00
                                                </span>
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">13:00-15:00
                                                </span>
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">15:00-17:00
                                                </span>
                            <br/><span class="text-success">3/3 εθελοντές</span></label>
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
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">13:00-17:00
                                                </span>
                            <br/>1/3 εθελοντές</label>
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
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">11:00-13:00
                                                </span>
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">13:00-15:00
                                                </span>
                            <br/>1/3 εθελοντές</label>
                    </div>
                    <div class="dateTime">
                        <input type="checkbox" class="form-control">
                        <label>22/02/2016 <br/>  <span class="hours">15:00-17:00
                                                </span>
                            <br/><span class="text-success">3/3 εθελοντές</span></label>
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
                            <br/>1/3 εθελοντές</label>
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
                            <br/>1/3 εθελοντές</label>
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
                            <br/>1/3 εθελοντές</label>
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
@include('main.cta._i_am_interested')
</main>
<!-- Page Content -->
@include('template.default.footerIncludes')
<script>

    $("#submit").click(function () {
        if (validate()) {
            var ratings = [];

            $.each($(".question"), function (key, value) {
                var group = $(this).attr('data-radio-group');

                ratings.push({
                    attrId: $("input:radio[name ='" + group + "']:checked").attr('data-attrId'),
                    score: $("input:radio[name ='" + group + "']:checked").val()
                });
            });

            //send data to server to save the ratings
            $.ajax({
                url: $("body").attr('data-url') + '/ratings/action/store',
                method: 'POST',
                data: {
                    actionId: $("#actionInformation").attr('data-action-id'),
                    actionScoreId: $("#actionInformation").attr('data-action-score-id'),
                    comments: $("#comments").val(),
                    ratings: ratings
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/ratings/action/thankyou/" + data;
                }
            });
        }
    });


    //check that all radio button have been selected
    function validate() {
        var $questions = $(".question");
        if ($questions.find("input:radio:checked").length === $questions.length) {
            $(".error-msg").css('visibility', 'hidden');
            return true;
        }
        else {
            $(".error-msg .error-msg-text").text('Παρακαλώ απαντήστε σε όλες τις ερωτήσεις');
            $(".error-msg").css('visibility', 'visible');
            return false;
        }
    }

</script>
@yield('footerScripts')
</body>
</html>
