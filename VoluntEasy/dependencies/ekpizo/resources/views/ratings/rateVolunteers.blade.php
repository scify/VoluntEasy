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
<div class="col-md-8 center">
<div class="panel panel-white">
<div class="panel-body">
<div class=" text-center">
    <a href="{{ url('/') }}"
       class="logo-name text-lg"> <img
            src="{{ asset('assets/images/logo.png') }}" style="height:100%;"/>
    </a>
</div>
<h3 class="text-center">{{ trans('entities/ratings.volunteerRating') }} <span
        id="actionInformation"
        data-action-id="{{ $action->id }}"
        data-email="{{ $action->email }}"
        data-action-rating-id="{{ $actionRatingId }}">{{ $action->description
                                }}</span></h3>
<h5 class="text-center">{{ trans('entities/ratings.actionDuration') }}: {{
    $action->start_date }} - {{
    $action->end_date }}</h5>
<h5 class="text-center"><strong>Υπεύθυνος δράσης:</strong> {{ $user->name }} {{
$user->last_name }}
<h5 class="text-center">
    @if($user->tel)
    <i class="fa fa-phone"></i> {{ $user->tel }}
    @endif
    @if($user->email)
    <i class="fa fa-envelope"></i> {{ $user->email }}
    @endif
    @if($user->addr)
    <i class="fa fa-map-marker"></i> {{ $user->addr }}
    @endif
</h5>

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
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <p>{{ trans('entities/ratings.volunteerParticipatedTo') }}</p>
                    <ul>
                        @foreach($volunteer->workDateHistory as $workDate)
                        <li>{{ trans('entities/tasks.task') }} {{ $workDate->workDate->subtask->task->name }} / {{
                            trans('entities/subtasks.subtask') }} {{ $workDate->workDate->subtask->name }}: {{
                            $workDate->workDate->from_date }}, {{ $workDate->workDate->from_hour}}-{{
                            $workDate->workDate->to_hour }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <p><strong>1. {{trans('entities/ratings.actionDescription')}}:</strong></p>
                    {!! Form::formInput('actionDescription',
                    '', $errors,
                    ['class' => 'form-control actionDescription', 'type' => 'textarea', 'size' =>
                    '2x5', 'data-volunteer-id' => $volunteer->id]) !!}
                </div>
                <div class="col-md-6">
                    <p><strong>2. {{trans('entities/ratings.problemsOccured')}}:</strong></p>
                    {!! Form::formInput('problemsOccured','', $errors,
                    ['class' => 'form-control problemsOccured', 'type' => 'textarea', 'size' =>
                    '2x5', 'data-volunteer-id' => $volunteer->id]) !!}
                </div>
            </div>
            <div class="row bottom-margin">

                <div class="col-md-12">
                    <p><strong>3. {{ trans('entities/ratings.laborAndInterpersonalSkills')
                            }}</strong></p>

                    <table class="table table-condensed table-bordered">
                        <thead>
                        <th>{{ trans('entities/ratings.laborSkills') }}</th>
                        <th>{{ trans('entities/ratings.strongOrWeak') }}</th>
                        <th>{{ trans('entities/ratings.commentsEtc') }}</th>
                        </thead>
                        <tbody>
                        @foreach($laborSkills as $skill)
                        <tr class="laborSkillsRow" data-volunteer-id="{{$volunteer->id}}"
                            data-skill-id="{{$skill->id}}">
                            <td>{{ $skill->description }}</td>
                            <td><label>
                                    {!! Form::formInput('strongOrWeak['.$skill->id.']', '', $errors,
                                    ['class' => 'form-control strongOrWeak laborSkills', 'type' =>
                                    'radio', 'value' => 1, 'checked' => 'false', 'data-volunteer-id' =>
                                    $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                                    {{ trans('entities/ratings.strong') }}</label>
                                <label>
                                    {!! Form::formInput('strongOrWeak['.$skill->id.']', '', $errors,
                                    ['class' => 'form-control strongOrWeak laborSkills', 'type' =>
                                    'radio', 'value' => 0, 'checked' => 'false', 'data-volunteer-id' =>
                                    $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                                    {{ trans('entities/ratings.weak') }}</label>
                            </td>
                            <td>{!! Form::formInput('commentsEtc['.$skill->id.']','', $errors,
                                ['class' => 'form-control commentsEtc laborSkills', 'type' => 'textarea', 'size' =>
                                '2x1', 'data-volunteer-id' => $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <table class="table table-condensed table-bordered">
                        <thead>
                        <th>{{ trans('entities/ratings.interpersonalSkills') }}</th>
                        <th>{{ trans('entities/ratings.strongOrWeak') }}</th>
                        <th>{{ trans('entities/ratings.commentsEtc') }}</th>
                        </thead>
                        <tbody>
                        @foreach($interpersonalSkills as $skill)
                        <tr class="interpersonalSkills" data-volunteer-id="{{$volunteer->id}}"
                            data-skill-id="{{$skill->id}}">
                            <td>{{ $skill->description }}</td>
                            <td><label>
                                    {!! Form::formInput('strongOrWeak['.$skill->id.']', '', $errors,
                                    ['class' => 'form-control strongOrWeak interpersonalSkills', 'type' =>
                                    'radio', 'value' => 1, 'checked' => 'false', 'data-volunteer-id' =>
                                    $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                                    {{ trans('entities/ratings.strong') }}</label>
                                <label>
                                    {!! Form::formInput('strongOrWeak['.$skill->id.']', '', $errors,
                                    ['class' => 'form-control strongOrWeak interpersonalSkills', 'type' =>
                                    'radio', 'value' => 0, 'checked' => 'false', 'data-volunteer-id' =>
                                    $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                                    {{ trans('entities/ratings.weak') }}</label>
                            </td>
                            <td>{!! Form::formInput('commentsEtc['.$skill->id.']','', $errors,
                                ['class' => 'form-control commentsEtc interpersonalSkills', 'type' => 'textarea',
                                'size' =>
                                '2x1', 'data-volunteer-id' => $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row bottom-margin">
                <div class="col-md-12">
                    <p><strong>4. {{ trans('entities/ratings.nextSteps') }}</strong></p>
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <p> {{ trans('entities/ratings.fieldsToImprove') }}</p>
                    {!! Form::formInput('fieldsToImprove','', $errors, ['class'
                    => 'form-control fieldsToImprove', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
                    $volunteer->id])
                    !!}
                </div>
                <div class="col-md-6">
                    <p>{{ trans('entities/ratings.training') }}</p>
                    {!! Form::formInput('training','', $errors, ['class'
                    => 'form-control training', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
                    $volunteer->id])
                    !!}
                </div>
            </div>
            <div class="row bottom-margin">
                <div class="col-md-6">
                    <p>{{ trans('entities/ratings.objectives') }}</p>
                    {!! Form::formInput('objectives','', $errors, ['class'
                    => 'form-control objectives', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
                    $volunteer->id])
                    !!}
                </div>
                <div class="col-md-6">
                    <p>{{ trans('entities/ratings.support') }}</p>
                    {!! Form::formInput('support','', $errors, ['class'
                    => 'form-control support', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
                    $volunteer->id])
                    !!}
                </div>
            </div>

            <div class="row bottom-margin">
                <div class="col-md-12">
                    <p><strong>5. {{ trans('entities/ratings.generalComments') }}</strong></p>

                    {!! Form::formInput('generalComments','', $errors, ['class'
                    => 'form-control generalComments', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
                    $volunteer->id])
                    !!}
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
                <li class="previous"><a href="#" class="btn btn-default">{{
                        trans('entities/ratings.prevVolunteer') }}</a>
                </li>
                <li class="next"><a href="#" class="btn btn-default">{{
                        trans('entities/ratings.nextVolunteer') }}</a></li>
                <li class="next finish" style="display:none;"><a
                        href="javascript:;">{{
                        trans('default.submit') }}</a>
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
            if (ratingFlag && tab.hasClass('last')) {
                sendRatings();
            }
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
        var laborSkills = [];
        var interpersonalSkills = [];

        $.each(volunteerIds, function (key, value) {

            laborSkills = getLaborSkills(value);
            interpersonalSkills = getInterpersonalSkills(value);

            volunteers.push({
                id: value,
                actionDescription: $('.actionDescription[data-volunteer-id="' + value + '"]').val(),
                problemsOccured: $('.problemsOccured[data-volunteer-id="' + value + '"]').val(),
                training: $('.training[data-volunteer-id="' + value + '"]').val(),
                fieldsToImprove: $('.fieldsToImprove[data-volunteer-id="' + value + '"]').val(),
                objectives: $('.objectives[data-volunteer-id="' + value + '"]').val(),
                support: $('.support[data-volunteer-id="' + value + '"]').val(),
                generalComments: $('.generalComments[data-volunteer-id="' + value + '"]').val(),
                laborSkills: laborSkills,
                interpersonalSkills: interpersonalSkills
            });
        });

        console.log(volunteers);
        /*
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
         success: function (data) {
         console.log(data);
         // window.location.href = $("body").attr('data-url') + "/ratings/action/volunteers/thankyou/" + data;
         }
         });*/
    }

    //check that all volunteers have been rated before sending the form
    function validate(volunteerId) {
        return true;
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


    /* get an array with the labor skills and their comments */
    function getLaborSkills(volunteerId) {
        var laborSkills = [];
        var skillId, strongOrWeak, commentsEtc;

        $.each($('.laborSkillsRow[data-volunteer-id="' + volunteerId + '"]'), function (k, v) {

            skillId = $(v).attr('data-skill-id');
            strongOrWeak = $('.strongOrWeak.laborSkills[data-volunteer-id="' + volunteerId + '"][data-skill-id="' + skillId + '"]:checked').val();
            commentsEtc = $('.commentsEtc.laborSkills[data-volunteer-id="' + volunteerId + '"][data-skill-id="' + skillId + '"]').val();

            if (strongOrWeak || commentsEtc)
                laborSkills.push({
                    id: skillId,
                    strongOrWeak: strongOrWeak,
                    commentsEtc: commentsEtc
                });
        });

        return laborSkills;
    }


    /* get an array with the interpersonal skills and their comments */
    function getInterpersonalSkills(volunteerId) {
        var interpersonalSkills = [];
        var skillId, strongOrWeak, commentsEtc;

        $.each($('.interpersonalSkillsRow[data-volunteer-id="' + volunteerId + '"]'), function (k, v) {

            skillId = $(v).attr('data-skill-id');
            strongOrWeak = $('.strongOrWeak.interpersonalSkills[data-volunteer-id="' + volunteerId + '"][data-skill-id="' + skillId + '"]:checked').val();
            commentsEtc = $('.commentsEtc.interpersonalSkills[data-volunteer-id="' + volunteerId + '"][data-skill-id="' + skillId + '"]').val();

            if (strongOrWeak || commentsEtc)
                interpersonalSkills.push({
                    id: skillId,
                    strongOrWeak: strongOrWeak,
                    commentsEtc: commentsEtc
                });
        });

        return interpersonalSkills;
    }


</script>
</body>
</html>
