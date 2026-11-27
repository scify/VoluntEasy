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
                                    @if(config('app.platform_name')=='VoluntAction')
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
                                <ul class="nav nav-pills">
                                    @foreach($action->volunteers as $i => $volunteer)
                                    <li data-volunteer-id="{{ $volunteer->id }}"
                                        class="{{ $i == sizeof($action->volunteers)-1 ? 'last' : '' }}"><a
                                            href="#tab{{ $volunteer->id }}">{{
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
                                                <li class="previous"><a href="#" class="btn btn-default">{{ trans('entities/ratings.prevVolunteer') }}</a>
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
<script>
    VE.ready(function () {
        var root = document.getElementById('rootwizard');
        if (!root) return;
        var info = document.getElementById('actionInformation');
        var errorMsg = root.querySelector('.error-msg');
        var tabs = Array.prototype.slice.call(root.querySelectorAll('ul.nav > li'));
        var volunteerIds = []; // the volunteers that the user has seen
        var sending = false;

        Array.prototype.forEach.call(root.querySelectorAll('.attribute.rating'), function (el) {
            VE.stars(el);
        });

        function field(selector, volunteerId) {
            return root.querySelector(selector + '[data-volunteer-id="' + volunteerId + '"]');
        }

        function showError(key) {
            errorMsg.querySelector('.error-msg-text').textContent = Lang.get(key);
            errorMsg.style.visibility = 'visible';
        }

        function isNumber(value) {
            return value.trim() !== '' && isFinite(Number(value));
        }

        // check that the volunteer has a rating for all the attributes and that hours/minutes are numbers
        function validate(volunteerId) {
            var attributes = Array.prototype.slice.call(root.querySelectorAll('.attribute.rating[data-volunteer-id="' + volunteerId + '"]'));
            var rated = attributes.filter(function (el) { return el.VEStars.score() > 0; }).length;
            var hours = field('input.hours', volunteerId).value;
            var minutes = field('input.minutes', volunteerId).value;

            if (rated < attributes.length) showError('js-components.answerAllQuestions');
            if (hours !== '' && !isNumber(hours)) {
                showError('js-components.pleaseAddOnlyNumbers');
                return false;
            }
            if (minutes !== '' && !isNumber(minutes)) {
                showError('js-components.pleaseAddOnlyNumbers');
                return false;
            }
            if (rated === attributes.length) {
                errorMsg.style.visibility = 'hidden';
                return true;
            }
            return false;
        }

        // send the ratings of all the volunteers to the server
        function sendRatings() {
            if (sending) return;
            var data = new URLSearchParams();
            volunteerIds.forEach(function (volunteerId, i) {
                var prefix = 'volunteers[' + i + ']';
                data.append(prefix + '[id]', volunteerId);
                Array.prototype.forEach.call(root.querySelectorAll('.attribute.rating.volunteerRating[data-volunteer-id="' + volunteerId + '"]'), function (el, j) {
                    data.append(prefix + '[ratings][' + j + '][attrId]', el.getAttribute('data-attr-id'));
                    data.append(prefix + '[ratings][' + j + '][rating]', el.VEStars.score());
                });
                data.append(prefix + '[comments]', field('.comments', volunteerId).value);
                data.append(prefix + '[hours]', field('.hours', volunteerId).value);
                data.append(prefix + '[minutes]', field('.minutes', volunteerId).value);
            });
            data.append('actionId', info.getAttribute('data-action-id'));
            data.append('email', info.getAttribute('data-email'));
            data.append('actionRatingId', info.getAttribute('data-action-rating-id'));
            // the token of the link proves which rating this is
            data.append('token', location.pathname.split('/').filter(Boolean).pop());

            sending = true;
            VE.http.post('/ratings/action/volunteers/store', data).then(function (actionId) {
                window.location.href = VE.url('/ratings/action/volunteers/thankyou/' + actionId);
            }).catch(function (error) {
                sending = false;
                VE.fail(error);
            });
        }

        VE.wizard(root, {
            onNext: function (index) {
                var tab = tabs[index];
                if (!validate(tab.getAttribute('data-volunteer-id'))) return false;
                // at the last tab, without errors: send the ratings to the server
                if (tab.classList.contains('last')) {
                    sendRatings();
                    return false;
                }
            },
            onTabChanged: function (index) {
                var volunteerId = tabs[index].getAttribute('data-volunteer-id');
                if (volunteerIds.indexOf(volunteerId) === -1) volunteerIds.push(volunteerId);

                // at the last tab, show the "submit" button instead of "next"
                var last = index >= tabs.length - 1;
                Array.prototype.forEach.call(root.querySelectorAll('.pager .next'), function (li) {
                    var finish = li.classList.contains('finish');
                    li.style.display = finish === last ? '' : 'none';
                    if (finish) li.classList.remove('disabled');
                });
            }
        });
    });
</script>
</body>
</html>
