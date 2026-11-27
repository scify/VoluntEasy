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
                                   class="logo-name text-lg">
                                    @if(config('app.platform_name')=='VoluntAction')
                                        <img src="{{ asset('assets/images/voluntaction/logo.png') }}" style="height:100%;"/>
                                    @else
                                        <img src="{{ asset('assets/images/volunteasy/logo.png') }}" style="height:100%;"/>
                                    @endif
                                </a>
                            </div>
                            <h3 class="text-center">{{ trans('entities/ratings.actionRating') }} <span id="actionInformation"
                                                                            data-action-id="{{ $action->id }}"
                                                                            data-action-score-id="{{ $actionScore->id }}">{{ $action->description
                                }}</span></h3>
                            <h5 class="text-center">{{ trans('entities/ratings.actionDuration') }}: {{ $action->start_date }} - {{
                                $action->end_date }}</h5>
                            <hr/>


                            <table class="table table-striped" id="rateAction">
                                <thead>
                                <th></th>
                                <th class="text-center">{{ trans('entities/ratings.fullyDisagree') }}</th>
                                <th class="text-center">{{ trans('entities/ratings.disagree') }}</th>
                                <th class="text-center">{{ trans('entities/ratings.neutral') }}</th>
                                <th class="text-center">{{ trans('entities/ratings.agree') }}</th>
                                <th class="text-center">{{ trans('entities/ratings.fullyAgree') }}</th>
                                </thead>
                                <tbody>
                                @foreach($attributes as $attribute)
                                <tr class="question" data-radio-group="attr{{$attribute->id}}">
                                    <td>{{ $attribute->description }}</td>
                                    <td class="text-center"><label>{!! Form::formInput('attr'.$attribute->id, '', null,
                                            ['class' => 'form-control rateAttr', 'type' => 'radio', 'value'
                                            => -2, 'checked' => 'false', 'data-attrId' => $attribute->id]) !!}</label>
                                    </td>
                                    <td class="text-center"><label>{!! Form::formInput('attr'.$attribute->id, '', null,
                                            ['class' => 'form-control rateAttr', 'type' => 'radio', 'value'
                                            => -1, 'checked' => 'false', 'data-attrId' => $attribute->id]) !!}</label>
                                    </td>
                                    <td class="text-center"><label>{!! Form::formInput('attr'.$attribute->id, '', null,
                                            ['class' => 'form-control rateAttr', 'type' => 'radio', 'value'
                                            => 0, 'checked' => 'false', 'data-attrId' => $attribute->id]) !!}</label>
                                    </td>
                                    <td class="text-center"><label>{!! Form::formInput('attr'.$attribute->id, '', null,
                                            ['class' => 'form-control rateAttr', 'type' => 'radio', 'value'
                                            => 1, 'checked' => 'false', 'data-attrId' => $attribute->id]) !!}</label>
                                    </td>
                                    <td class="text-center"><label>{!! Form::formInput('attr'.$attribute->id, '', null,
                                            ['class' => 'form-control rateAttr', 'type' => 'radio', 'value'
                                            => 2, 'checked' => 'false', 'data-attrId' => $attribute->id]) !!}</label>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        {{ trans('entities/ratings.otherComments') }}
                                    </td>
                                    <td colspan="5">
                                        {!! Form::formInput('comments', '', null, ['class' => 'form-control', 'type' =>
                                        'textarea', 'size' => '5x5', 'id' => 'comments']) !!}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row m-b-lg text-right">
                                <div class="col-md-12">
                                    <div class="text-center error-msg" style="visibility:hidden">
                                        <div class="col-md-12">
                                            <p class="text-danger"><em class="error-msg-text"></em></p>
                                        </div>
                                    </div>
                                    {!! Form::submit(trans('default.submit'), ['class' => 'btn btn-success', 'id' => 'submit']) !!}
                                </div>
                            </div>
                            <hr/>
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <p><em>{{ trans('entities/ratings.youReceivedThisEmailVolunteer') }} <strong>{{trans($lang.'title')}}</strong>.</em></p>
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
        var errorMsg = document.querySelector('.error-msg');
        var questions = Array.prototype.slice.call(document.querySelectorAll('.question'));

        // the checked radio button of a question
        function checked(question) {
            return question.querySelector('input[type="radio"]:checked');
        }

        // check that all the questions have an answer
        function validate() {
            if (questions.every(checked)) {
                errorMsg.style.visibility = 'hidden';
                return true;
            }
            errorMsg.querySelector('.error-msg-text').textContent = Lang.get('js-components.answerAllQuestions');
            errorMsg.style.visibility = 'visible';
            return false;
        }

        document.getElementById('submit').addEventListener('click', function (event) {
            event.preventDefault();
            if (!validate()) return;

            var info = document.getElementById('actionInformation');
            var data = new URLSearchParams();
            data.append('actionId', info.getAttribute('data-action-id'));
            data.append('actionScoreId', info.getAttribute('data-action-score-id'));
            // the token of the link proves which rating this is
            data.append('token', location.pathname.split('/').filter(Boolean).pop());
            data.append('comments', document.getElementById('comments').value);
            questions.forEach(function (question, index) {
                var radio = checked(question);
                data.append('ratings[' + index + '][attrId]', radio.getAttribute('data-attrId'));
                data.append('ratings[' + index + '][score]', radio.value);
            });

            // save the ratings, then show the "thank you" page
            VE.http.post('/ratings/action/store', data).then(function (actionId) {
                window.location.href = VE.url('/ratings/action/thankyou/' + actionId);
            }).catch(VE.fail);
        });
    });
</script>
</body>
</html>
