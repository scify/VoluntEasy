<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
       class="logo-name text-lg">
        @if(config('app.platform_name')=='VoluntAction')
        <img src="{{ asset('assets/images/voluntaction/logo.png') }}" style="height:100%;"/>
        @else
        <img src="{{ asset('assets/images/volunteasy/logo.png') }}" style="height:100%;"/>
        @endif
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
<h5 class="text-center"><strong>Υπεύθυνος δράσης:</strong> <span id="user_id" data-user-id="{{ $user->id }}">{{ $user->name }} {{
$user->last_name }}</span>
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
    <div class="row bottom-margin">
        <div class="col-md-12">
            <p>{{ trans('entities/ratings.volunteerParticipatedTo') }}</p>
            <ul>
                @foreach($volunteer->subtaskShiftHistory as $shift)
                @if($shift->shift->trashedSubtask->trashedTask->action_id==$action->id)
                <li>{{ trans('entities/tasks.task') }} {{ $shift->shift->trashedSubtask->trashedTask->name }} / {{
                    trans('entities/subtasks.subtask') }} {{ $shift->shift->trashedSubtask->name }}: {{
                    $shift->shift->from_date }}, {{ $shift->shift->from_hour}}-{{
                    $shift->shift->to_hour }}
                </li>
                @endif
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
            '2x5', 'data-volunteer-id' => $volunteer->id, 'data-question'=> '1', 'maxlength'=>'900']) !!}
            <p class="text-right">
                <small><span class="chars" data-question="1" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
        </div>
        <div class="col-md-6">
            <p><strong>2. {{trans('entities/ratings.problemsOccured')}}:</strong></p>
            {!! Form::formInput('problemsOccured','', $errors,
            ['class' => 'form-control problemsOccured', 'type' => 'textarea', 'size' =>
            '2x5', 'data-volunteer-id' => $volunteer->id, 'data-question'=> '2', 'maxlength'=>'900']) !!}
            <p class="text-right">
                <small><span class="chars" data-question="2" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
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
                            {!! Form::formInput('volunteer-'.$volunteer->id.'labor-strongOrWeak['.$skill->id.']', '',
                            $errors,
                            ['class' => 'form-control strongOrWeak laborSkills', 'type' =>
                            'radio', 'value' => 1, 'checked' => 'false', 'data-volunteer-id' =>
                            $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                            {{ trans('entities/ratings.strong') }}</label>
                        <label>
                            {!! Form::formInput('volunteer-'.$volunteer->id.'labor-strongOrWeak['.$skill->id.']', '',
                            $errors,
                            ['class' => 'form-control strongOrWeak laborSkills', 'type' =>
                            'radio', 'value' => 0, 'checked' => 'false', 'data-volunteer-id' =>
                            $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                            {{ trans('entities/ratings.weak') }}</label>
                    </td>
                    <td>{!! Form::formInput('commentsEtc['.$skill->id.']','', $errors,
                        ['class' => 'form-control commentsEtc laborSkills', 'type' => 'textarea', 'size' =>
                        '2x1', 'data-volunteer-id' => $volunteer->id, 'data-skill-id' => $skill->id,
                        'maxlength'=>'500']) !!}
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
                <tr class="interpersonalSkillsRow" data-volunteer-id="{{$volunteer->id}}"
                    data-skill-id="{{$skill->id}}">
                    <td>{{ $skill->description }}</td>
                    <td><label>
                            {!! Form::formInput('volunteer-'.$volunteer->id.'intp-strongOrWeak['.$skill->id.']', '',
                            $errors,
                            ['class' => 'form-control strongOrWeak interpersonalSkills', 'type' =>
                            'radio', 'value' => 1, 'checked' => 'false', 'data-volunteer-id' =>
                            $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                            {{ trans('entities/ratings.strong') }}</label>
                        <label>
                            {!! Form::formInput('volunteer-'.$volunteer->id.'intp-strongOrWeak['.$skill->id.']', '',
                            $errors,
                            ['class' => 'form-control strongOrWeak interpersonalSkills', 'type' =>
                            'radio', 'value' => 0, 'checked' => 'false', 'data-volunteer-id' =>
                            $volunteer->id, 'data-skill-id' => $skill->id]) !!}
                            {{ trans('entities/ratings.weak') }}</label>
                    </td>
                    <td>{!! Form::formInput('commentsEtc['.$skill->id.']','', $errors,
                        ['class' => 'form-control commentsEtc interpersonalSkills', 'type' => 'textarea',
                        'size' =>
                        '2x1', 'data-volunteer-id' => $volunteer->id, 'data-skill-id' => $skill->id,
                        'maxlength'=>'500']) !!}
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
            $volunteer->id, 'data-question'=> '3', 'maxlength'=>'900'])
            !!}
            <p class="text-right">
                <small><span class="chars" data-question="3" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
        </div>
        <div class="col-md-6">
            <p>{{ trans('entities/ratings.training') }}</p>
            {!! Form::formInput('training','', $errors, ['class'
            => 'form-control training', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
            $volunteer->id, 'data-question'=> '4', 'maxlength'=>'900'])
            !!}
            <p class="text-right">
                <small><span class="chars" data-question="4" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
        </div>
    </div>
    <div class="row bottom-margin">
        <div class="col-md-6">
            <p>{{ trans('entities/ratings.objectives') }}</p>
            {!! Form::formInput('objectives','', $errors, ['class'
            => 'form-control objectives', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
            $volunteer->id, 'data-question'=> '5', 'maxlength'=>'900'])
            !!}
            <p class="text-right">
                <small><span class="chars" data-question="5" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
        </div>
        <div class="col-md-6">
            <p>{{ trans('entities/ratings.support') }}</p>
            {!! Form::formInput('support','', $errors, ['class'
            => 'form-control support', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
            $volunteer->id, 'data-question'=> '6', 'maxlength'=>'900'])
            !!}
            <p class="text-right">
                <small><span class="chars" data-question="6" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
        </div>
    </div>

    <div class="row bottom-margin">
        <div class="col-md-12">
            <p><strong>5. {{ trans('entities/ratings.generalComments') }}</strong></p>

            {!! Form::formInput('generalComments','', $errors, ['class'
            => 'form-control generalComments', 'type' => 'textarea', 'size' => '2x5', 'data-volunteer-id' =>
            $volunteer->id, 'data-question'=> '7', 'maxlength'=>'900'])
            !!}
            <p class="text-right">
                <small><span class="chars" data-question="7" data-volunteer-id="{{ $volunteer->id }}">900</span>
                    {{trans('entities/ratings.charsRemaining')}}
                </small>
            </p>
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
<script>
    VE.ready(function () {
        var root = document.getElementById('rootwizard');
        if (!root) return;
        var info = document.getElementById('actionInformation');
        var userId = document.getElementById('user_id').getAttribute('data-user-id');
        var tabs = Array.prototype.slice.call(root.querySelectorAll('ul.nav > li'));
        var volunteerIds = []; // the volunteers that the user has seen
        var maxLength = 900;
        var sending = false;

        // the remaining characters of each answer
        VE.on(root, 'input', 'textarea', function (event, textarea) {
            var counter = root.querySelector('.chars[data-question="' + textarea.getAttribute('data-question') + '"][data-volunteer-id="' +
                textarea.getAttribute('data-volunteer-id') + '"]');
            if (counter) counter.textContent = maxLength - textarea.value.length;
        });

        function fieldValue(selector) {
            var el = root.querySelector(selector);
            return el ? el.value : '';
        }

        function value(selector, volunteerId) {
            return fieldValue(selector + '[data-volunteer-id="' + volunteerId + '"]');
        }

        // the skills (labor or interpersonal) that have an answer or a comment
        function skills(type, volunteerId) {
            var result = [];
            Array.prototype.forEach.call(root.querySelectorAll('.' + type + 'Row[data-volunteer-id="' + volunteerId + '"]'), function (row) {
                var skillId = row.getAttribute('data-skill-id');
                var skill = '[data-volunteer-id="' + volunteerId + '"][data-skill-id="' + skillId + '"]';
                var strongOrWeak = fieldValue('.strongOrWeak.' + type + skill + ':checked');
                var comments = fieldValue('.commentsEtc.' + type + skill);
                if (strongOrWeak || comments) result.push({id: skillId, strongOrWeak: strongOrWeak, comments: comments});
            });
            return result;
        }

        // send the ratings of all the volunteers to the server
        function sendRatings() {
            if (sending) return;
            var data = new URLSearchParams();
            volunteerIds.forEach(function (volunteerId, i) {
                var prefix = 'volunteers[' + i + ']';
                data.append(prefix + '[volunteer_id]', volunteerId);
                data.append(prefix + '[user_id]', userId);
                ['actionDescription', 'problemsOccured', 'training', 'fieldsToImprove', 'objectives', 'support', 'generalComments'].forEach(function (name) {
                    data.append(prefix + '[' + name + ']', value('.' + name, volunteerId));
                });
                ['laborSkills', 'interpersonalSkills'].forEach(function (type) {
                    skills(type, volunteerId).forEach(function (skill, j) {
                        var key = prefix + '[' + type + '][' + j + ']';
                        data.append(key + '[id]', skill.id);
                        data.append(key + '[strongOrWeak]', skill.strongOrWeak);
                        data.append(key + '[comments]', skill.comments);
                    });
                });
            });
            data.append('user_id', userId);
            data.append('action_id', info.getAttribute('data-action-id'));
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
                // at the last tab: send the ratings to the server
                if (tabs[index].classList.contains('last')) {
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
