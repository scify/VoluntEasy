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
                                   class="logo-name text-lg">
                                    @if(env('PLATFORM_NAME')=='VoluntAction')
                                        <img src="{{ asset('assets/images/voluntaction/logo.png') }}" style="height:100%;"/>
                                    @else
                                        <img src="{{ asset('assets/images/volunteasy/logo.png') }}" style="height:100%;"/>
                                    @endif
                                </a>
                            </div>
                            <h3 class="text-center">{{ trans('entities/ratings.volunteerRating') }} <span id="actionInformation"
                                                                                            data-action-id="{{ $action->id }}"
                                                                                            data-email="{{ $action->email }}"
                                                                                            data-action-rating-id="{{ $actionRatingId }}">{{ $action->description
                                }}</span></h3>
                            <h5 class="text-center">{{ trans('entities/ratings.actionDuration') }}: {{ $action->start_date }} - {{
                                $action->end_date }}</h5>
                            <hr/>
                            @if(sizeof($action->volunteers)>0)

                            <div id="rootwizard">
                                <ul>
                                    @foreach($action->volunteers as $i => $volunteer)
                                    <li data-volunteer-id="{{ $volunteer->id }}"
                                        class="{{ $i == sizeof($action->volunteers)-1 ? 'last' : '' }}"><a
                                            href="#tab{{ $volunteer->id }}"
                                            data-toggle="tab">{{
                                            $volunteer->name}} {{
                                            $volunteer->last_name }}</a></li>
                                    @endforeach
                                </ul>

                                <form id="wizardForm">
                                    <div class="tab-content" style="border:none;">

                                        @foreach($action->volunteers as $i => $volunteer)
                                        <div class="tab-pane {{ $i==0 ? 'active' : ''}}"
                                             id="tab{{ $volunteer->id }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::formInput('comments', trans('entities/ratings.comments').':', $errors, ['class' =>
                                                        'form-control volunteerRating comments',
                                                        'type' =>
                                                        'textarea', 'size' => '2x5', 'data-volunteer-id' =>
                                                        $volunteer->id ]) !!}
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12"><p>{{ trans('entities/ratings.addVolunteerHours') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {!! Form::formInput('hours', trans('entities/ratings.hours').':', $errors, ['class'
                                                                =>
                                                                'form-control volunteerRating hours',
                                                                'data-volunteer-id' => $volunteer->id]) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {!! Form::formInput('minutes', trans('entities/ratings.minutes').':', $errors,
                                                                ['class'
                                                                => 'form-control volunteerRating minutes',
                                                                'data-volunteer-id' => $volunteer->id]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    @foreach($ratingAttributes as $key => $attribute)
                                                    <div class="form-group">

                                                        <span><strong>{{ $attribute->description }}</strong></span>

                                                        <div id="volunteer{{ $volunteer->id }}-attr{{ $attribute->id }}"
                                                             class="attribute rating volunteerRating"
                                                             data-volunteer-id="{{$volunteer->id}}"
                                                             data-attr-id="{{$attribute->id}}"></div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                        <div class="tab-pane fade" id="tab4">
                                            <h2 class="no-s">{{ trans('entities/ratings.thankYou') }}</h2>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-center error-msg" style="visibility:hidden">
                                                    <div class="col-md-12">
                                                        <p class="text-danger"><em class="error-msg-text"></em></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="pager wizard">
                                                <li class="previous"><a href="#" class="btn btn-default"{{ trans('entities/ratings.prevVolunteer') }}</a>
                                                </li>
                                                <li class="next"><a href="#" class="btn btn-default">{{ trans('entities/ratings.nextVolunteer') }}</a></li>
                                                <li class="next finish" style="display:none;"><a href="javascript:;">{{ trans('default.submit') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                </form>
                            </div>


                            @else
                            <p>{{ trans('entities/ratings.noVolunteers') }}</p>
                            @endif
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <small><em>{{ trans('entities/ratings.youReceivedThisEmailActionManager') }}
                                                <strong>{{trans($lang.'title')}}</strong>.</em></small>
                                    </p>
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

            //if we are at the last tab, and there are no errors, then send the ratings to the server
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

        //send data to server to save the ratings
        $.ajax({
            url: $("body").attr('data-url') + '/ratings/action/volunteers/store',
            method: 'POST',
            data: {
                volunteers: volunteers,
                actionId: $("#actionInformation").attr('data-action-id'),
                email: $("#actionInformation").attr('data-email'),
                actionRatingId: $("#actionInformation").attr('data-action-rating-id')
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/ratings/action/volunteers/thankyou/" + data;
            }
        });
    }

    //check that all volunteers have been rated before sending the form
    function validate(volunteerId) {
        var count = 0;
        var volunteerAttributes = $(".attribute.rating[data-volunteer-id='" + volunteerId + "']");
        var hours = $("input.hours[data-volunteer-id='" + volunteerId + "']").val();
        var minutes = $("input.minutes[data-volunteer-id='" + volunteerId + "']").val();

        volunteerAttributes.each(function (index) {
            if ($(this).raty('score') == undefined) {
                $(".error-msg .error-msg-text").text(Lang.get('js-components.answerAllQuestions'));
                $(".error-msg").css('visibility', 'visible');
            }
            else
                count++;
        });

        if (hours != '' && !$.isNumeric(hours)) {
            $(".error-msg .error-msg-text").text(Lang.get('js-components.pleaseRateVolunteer'));
            $(".error-msg").css('visibility', 'visible');
            return false;
        }

        if (minutes != '' && !$.isNumeric(minutes)) {
            $(".error-msg .error-msg-text").text(Lang.get('js-components.pleaseAddOnlyNumbers'));
            $(".error-msg").css('visibility', 'visible');
            return false;
        }

        if (count == volunteerAttributes.length) {
            $(".error-msg").css('visibility', 'hidden');
            return true;
        }
        else
            return false;
    }

</script>
</body>
</html>
