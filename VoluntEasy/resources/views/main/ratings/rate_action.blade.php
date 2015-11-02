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
                            <h3 class="text-center">Αξιολόγηση δράσης <span id="actionInformation"
                                                                            data-action-id="{{ $action->id }}"
                                                                            data-action-score-id="{{ $actionScore->id }}">{{ $action->description
                                }}</span></h3>
                            <h5 class="text-center">Διάρκεια Δράσης: {{ $action->start_date }} - {{
                                $action->end_date }}</h5>
                            <hr/>


                            <table class="table table-striped" id="rateAction">
                                <thead>
                                <th></th>
                                <th class="text-center">Διαφωνώ απόλυτα</th>
                                <th class="text-center">Διαφωνώ</th>
                                <th class="text-center">Ούτε διαφωνώ/ούτε συμφωνώ</th>
                                <th class="text-center">Συμφωνώ</th>
                                <th class="text-center">Συμφωνώ τελείως</th>
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
                                </tbody>
                            </table>
                            <div class="row m-b-lg text-right">
                                <div class="col-md-12">
                                    <div class="text-center error-msg" style="visibility:hidden">
                                        <div class="col-md-12">
                                            <p class="text-danger"><em class="error-msg-text"></em></p>
                                        </div>
                                    </div>
                                    {!! Form::submit('Καταχώρηση', ['class' => 'btn btn-success', 'id' => 'submit']) !!}
                                </div>
                            </div>
                            <hr/>
                            <div class="row text-center">
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
            console.log(ratings);


            //send data to server to save the ratings
            $.ajax({
                url: $("body").attr('data-url') + '/ratings/action/store',
                method: 'POST',
                data: {
                    actionId: $("#actionInformation").attr('data-action-id'),
                    actionScoreId: $("#actionInformation").attr('data-action-score-id'),
                    ratings: ratings
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    //   window.location.href = $("body").attr('data-url') + "/ratings/action/thankyou/" + data;
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
</body>
</html>
