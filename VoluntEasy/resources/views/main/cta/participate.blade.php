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

                                    <p>{{ $action->description }}</p>

                                    <p>Υπεύθυνος επικοινωνίας: Test Test, 210-123456789, <a href="mailto:indo@test.gr">info@test
                                            .gr</a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    {{-- <img src="{{ asset('assets/images/volunteer_hands.png') }}"
                                              style="width:100%;"/> --}}
                                </div>
                            </div>


                            @foreach($action->tasks as $task)
                            <table class="table tasks">
                                <tr>
                                    <td colspan="2">
                                        <div class="task-info">
                                            <h3>{{ $task->description }}</h3>

                                            <p>{{ $task->comments }}</p>
                                        </div>

                                    </td>
                                </tr>
                                @foreach($task->subtasks as $subtask)
                                    @if(sizeof($subtask->workDates)>0)
                                    <tr>
                                        <td class="task col-md-3">
                                            <div class="subtask-info">{{ $subtask->name }}</div>
                                        </td>
                                        <td class="taskDate">

                                            @foreach($subtask->workDates as $date)
                                            <div class="dateTime">
                                                <input type="checkbox" class="form-control">
                                                <label>{{$date->from_date}} <br/>  <span class="hours">{{ $date->from_hour }}-{{ $date->to_hour }}
                                                    </span>
                                                    @if($date->volunteer_sum!=null || $date->volunteer_sum!=0)
                                                    <br/>{{ sizeof($date->volunteers) }}/{{ $date->volunteer_sum }}
                                                    εθελοντές</label>
                                                @endif
                                            </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </table>
                            @endforeach

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
