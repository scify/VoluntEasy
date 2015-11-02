<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>{{trans($lang.'volRating')}} | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login" data-url="{!! URL::to('/') !!}">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-5 center">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class=" text-center">
                                <a href="{{ url('/') }}"
                                   class="logo-name text-lg"> <img
                                        src="{{ asset('assets/images/logo.png') }}" style="height:100%;"/>
                                </a>
                            </div>
                            <h3 class="text-center">Αξιολόγηση δράσης {{ $action->description
                                }} </h3>
                            <h5 class="text-center">Διάρκεια Δράσης: {{ $action->start_date }} - {{
                                $action->end_date }}</h5>
                            <hr/>

                            <p>Έχετε ήδη αξιολογήσει τη δράση.</p>

                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <p><em>Λάβατε αυτό το ερωτηματολόγιο επειδή είστε εγγεγραμμένος ως εθελοντής στην πλατφόρμα διαχείρισης εθελοντών <strong>{{trans($lang.'title')}}</strong>.</em></p>

                                </div>
                            </div>
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

<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script>
    $('.attribute.rating').raty({
        starOff: '{{ asset("assets/plugins/raty/lib/images/star-off.png")}}',
        starOn: '{{ asset("assets/plugins/raty/lib/images/star-on.png")}}'
    });


    //keep an array with all the volunteers ids
    var volunteerIds = [];
    var ratingFlag = false;

    //wizard properties
    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function (tab, navigation, index) {
            var volunteerId = tab.attr('data-volunteer-id');

            if (!validate(volunteerId)) {
                ratingFlag = false;
                return false;
            }
            else
                ratingFlag = true;

            //if we are at the last tab, and there are no errors, then send the ratigns to the server
            if (ratingFlag && tab.hasClass('last'))
                sendRatings();
        },
        'onTabClick': function (tab, navigation, index) {
            var volunteerId = tab.attr('data-volunteer-id');

            if (!validate(volunteerId))
                return false;
        },
        onTabShow: function (tab, navigation, index) {
            var volunteerId = tab.attr('data-volunteer-id');

            //check if the id already exists in the array
            if ($.inArray(volunteerId, volunteerIds) == -1)
                volunteerIds.push(volunteerId);

            var $total = navigation.find('li').length;
            var $current = index + 1;

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
                $('#rootwizard').find('.pager .next').hide();
                $('#rootwizard').find('.pager .finish').show();
                $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
                $('#rootwizard').find('.pager .next').show();
                $('#rootwizard').find('.pager .finish').hide();
            }
        }
    });


    //when the finish button is pressed,
    //submit the data to the server
    function sendRatings() {
        var volunteers = [];
        var ratings = [];

        $.each(volunteerIds, function (key, value) {
            ratings = [];

            //get the ratings for each volunteer in an array
            $.each($(".attribute.rating.volunteerRating[data-volunteer-id='" + value + "']"), function (key, value) {
                ratings.push({
                    attrId: $(this).attr('data-attr-id'),
                    rating: $(this).raty("score")
                });
            });

            volunteers.push({
                id: value,
                ratings: ratings,
                comments: $('.comments[data-volunteer-id="' + value + '"]').val(),
                hours: $('.hours[data-volunteer-id="' + value + '"]').val(),
                minutes: $('.minutes[data-volunteer-id="' + value + '"]').val()
            });
        });

        console.log(volunteers);


        //send data to server to save the ratings
        $.ajax({
            url: $("body").attr('data-url') + '/ratings/store',
            method: 'POST',
            data: {
                volunteers: volunteers,
                actionId: $(this).attr('data-action-id'),
                email: $(this).attr('email')
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                console.log(data);

                // window.location.href = $("body").attr('data-url') + "/ratings/thankyou/" + data;
            }
        });
    }

    //check that all volunteers has been rated before sending the form
    function validate(volunteerId) {
        var count = 0;
        var volunteerAttributes = $(".attribute.rating[data-volunteer-id='" + volunteerId + "']");

        volunteerAttributes.each(function (index) {
            if ($(this).raty('score') == undefined) {
                $(".error-msg").css('visibility', 'visible');
                return false;
            }
            else {
                count++;
            }
        });

        if (count == volunteerAttributes.length) {
            $(".error-msg").css('visibility', 'hidden');
            return true;
        }
    }

</script>


</body>
</html>
