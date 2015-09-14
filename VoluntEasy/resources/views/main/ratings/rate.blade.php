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
                            <div class="login-box">
                                <a href="{{ url('/') }}"
                                   class="logo-name text-lg text-center"> <img
                                        src="{{ asset('assets/images/logo.png') }}" style="height:100%;"/>
                                </a>

                                <h3 class="text-center">Αξιολόγηση εθελοντών για τη δράση {{ $action->description
                                    }} </h3>
                                <h5 class="text-center">Διάρκεια Δράσης: {{ $action->start_date }} - {{
                                    $action->end_date }}</h5>
                                <hr/>
                                @foreach($action->volunteers as $volunteer)
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4>Όνομα Εθελοντή: {{ $volunteer->name}} {{ $volunteer->last_name }}</h4>

                                        <p><i class="fa fa-envelope"></i> <a href="mailto:{{ $volunteer->email }}">{{
                                                $volunteer->email }}</a> <br/>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h4>Συνέπεια</h4>

                                            <div id="volunteer{{ $volunteer->id }}-attr1"
                                                 class="attribute rating" data-volunteer-id="{{$volunteer->id}}"></div>

                                            <h4>Στυλ</h4>

                                            <div id="volunteer{{ $volunteer->id }}-attr2"
                                                 class="attribute rating" data-volunteer-id="{{$volunteer->id}}"></div>

                                            <h4>Αγάπη για γάτες</h4>

                                            <div id="volunteer{{ $volunteer->id }}-attr3"
                                                 class="attribute rating last"
                                                 data-volunteer-id="{{$volunteer->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center error-msg" style="visibility:hidden">
                                            <div class="col-md-12">
                                                <p class="text-danger"><em>Παρακαλώ αξιολογήστε όλους τους
                                                        εθελοντές</em></p>
                                            </div>
                                        </div>
                                        <div class="form-group text-right">
                                            <button class="btn btn-sm" id="saveRating"
                                                    data-action-id="{{ $action->id }}"
                                                    data-email="{{ $action->email }}">Καταχώρηση
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            <small><em>Λάβατε αυτό το ερωτηματολόγιο επειδή το email σας δηλώθηκε ως
                                                    email
                                                    υπευθύνου στη δράση {{ $action->description }} μέσω της πλατφόρμας
                                                    διαχείρισης
                                                    εθελοντών
                                                    <strong>{{trans($lang.'title')}}</strong>.</em></small>
                                        </p>

                                    </div>
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
    $('.attribute.rating').raty({
        starOff: '{{ asset("assets/plugins/raty/lib/images/star-off.png")}}',
        starOn: '{{ asset("assets/plugins/raty/lib/images/star-on.png")}}'
    });

    $("#saveRating").click(function () {
        var sendRatings = false,
            volunteers = [],
            ratings = [],
            id, attr1, attr2, attr3;


        $(".attribute.rating").each(function (index) {

            id = $(this).attr('data-volunteer-id');

            if ($(this).raty('score') == undefined) {
                $(".error-msg").css('visibility', 'visible');
                sendRatings = false;
                return false;
            }
            else {
                $(".error-msg").css('visibility', 'hidden');
                sendRatings = true;
                if ($(this).attr('id') == 'volunteer' + id + '-attr1')
                    attr1 = $(this).raty('score');
                else if ($(this).attr('id') == 'volunteer' + id + '-attr2')
                    attr2 = $(this).raty('score');
                else if ($(this).attr('id') == 'volunteer' + id + '-attr3')
                    attr3 = $(this).raty('score');
            }

            if ($(this).hasClass('last')) {
                volunteers.push({
                    id: id,
                    attr1: attr1,
                    attr2: attr2,
                    attr3: attr3
                });
            }
        });


        console.log(sendRatings);
        console.log(volunteers);

        if (sendRatings) {
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
                    window.location.href = $("body").attr('data-url') + "/ratings/thankyou/" + data;
                }
            });
        }

    });
</script>


</body>
</html>
