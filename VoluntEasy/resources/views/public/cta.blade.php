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
                    <div class="panel panel-white">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/ekpizo.png') }}" style="width:100%;"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Κάλεσμα εθελοντών στη δράση <strong>{{ $action->description }}</strong></h2>

                                    <p>Από <strong>{{ $action->start_date }}</strong> έως
                                        <strong>{{ $action->end_date }}</strong> στην <a href="#">Τεχνόπολη</a></p>

                                    <p>{{ $action->comments }}</p>

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

                                    <p>Υπεύθυνος επικοινωνίας: Test Test, 210-123456789, <a href="mailto:indo@test.gr">info@test
                                            .gr</a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    {{-- <img src="{{ asset('assets/images/volunteer_hands.png') }}"
                                              style="width:100%;"/> --}}
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Υποδοχή</h3>

                                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit
                                        esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo
                                        voluptas nulla pariatur.</p>
                                </div>

                                <div class="col-md-2">
                                    Άνοιγμα πόρτας
                                </div>
                                <div class="col-md-2">
                                    13:00-15:00
                                </div>
                            </div>


                            {{--
                            <table class="table tasks">

                                <tr>
                                    <td class="task">
                                        <div class="task-info">
                                            <h3>Υποδοχή</h3>

                                            <p> USC ALUMNI CENTER, 1st Floor Ballroom</p>
                                    </td>
                                    <td class="taskDate">
                                        <div class="subtask-info">Άνοιγμα πόρτας</div>

                                        <div class="">
                                            <div class="hours">13:00-15:00
                                            </div>
                                            <div class=" description">
                                                Keeping it Human
                                                Ben Callahan

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="taskDate">
                                            <div class="hours">13:00-15:00
                                            </div>
                                            <div class=" description">
                                                Keeping it Human
                                                Ben Callahan

                                            </div>
                                        </div>
                                    </td>
                                </tr>


                            </table>
                            --}}

                            {{--
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="cta tasks">
                                        <h3>Ανάγκες δράσης</h3>

                                        <div class="row task odd">
                                            <div class="col-md-9">
                                                <h4 class="title">Υποδοχή</h4>

                                                <p class="description">Duis aute irure dolor in reprehenderit in
                                                    voluptate velit esse
                                                    cillu.</p>
                                                <small class="dates">12 Φεβρουαρίου έως 16 Φεβρουαρίου, ώρες
                                                    12:00-16:00
                                                </small>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#i_am_interested">Ενδιαφέρομαι
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row task even">
                                            <div class="col-md-9">
                                                <h4 class="title">Υποδοχή</h4>

                                                <p class="description">Duis aute irure dolor in reprehenderit in
                                                    voluptate velit esse
                                                    cillu.</p>
                                                <small class="dates">12 Φεβρουαρίου έως 16 Φεβρουαρίου, ώρες
                                                    12:00-16:00
                                                </small>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#i_am_interested">Ενδιαφέρομαι
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row task odd">
                                            <div class="col-md-9">
                                                <h4 class="title">Υποδοχή</h4>

                                                <p class="description">Duis aute irure dolor in reprehenderit in
                                                    voluptate velit esse
                                                    cillu.</p>
                                                <small class="dates">12 Φεβρουαρίου έως 16 Φεβρουαρίου, ώρες
                                                    12:00-16:00
                                                </small>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#i_am_interested">Ενδιαφέρομαι
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            --}}

                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->
    @include('public._i_am_interested')
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
