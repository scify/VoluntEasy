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
                <div class="col-md-6 center">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class=" text-center">
                                <a href="{{ url('/') }}"
                                   class="logo-name text-lg"> <img
                                        src="{{ asset('assets/images/logo.png') }}" style="height:100%;"/>
                                </a>
                            </div>
                            <h3 class="text-center">Αξιολόγηση εθελοντών για τη δράση {{ $action->description
                                }} </h3>
                            <h5 class="text-center">Διάρκεια Δράσης: {{ $action->start_date }} - {{
                                $action->end_date }}</h5>
                            <hr/>
                            @if(sizeof($action->volunteers)>0)
                            @foreach($action->volunteers as $i => $volunteer)
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Όνομα Εθελοντή: {{ $volunteer->name}} {{ $volunteer->last_name }}</h3>
                                    </div>
                            </div>
                            <div class="row">
                                @foreach($ratingAttributes as $key => $attribute)
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <span><strong>{{ $attribute->description }}</strong></span>

                                        <div id="volunteer{{ $volunteer->id }}-attr{{ $attribute->id }}"
                                             class="attribute rating {{ $key == 0 ? 'first' : '' }}"
                                             data-volunteer-id="{{$volunteer->id}}"
                                             data-attr-id="{{$attribute->id}}"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control',
                                        'type' =>
                                        'textarea', 'size' => '2x5']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control',
                                        'required' => 'true']) !!}
                                        {!! Form::formInput('name', 'Όνομα:', $errors, ['class' => 'form-control',
                                        'required' => 'true']) !!}
                                    </div>
                                </div>
                            </div>
                            @if($i!=sizeof($action->volunteers)-1)
                            <hr/>
                            @endif
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
                            @else
                            <p>Δεν υπάρχουν εθελοντές προς αξιολόγηση.</p>
                            @endif
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


        //first check that all stars are filled
        if (validate()) {

            //for each star, do the following
            $(".attribute.rating").each(function (index) {

                //set the volunteer id
                id = $(this).attr('data-volunteer-id');

                //if this is the first star, add a new entry to the volunteers' array
                if ($(this).hasClass('first'))
                    volunteers.push({
                        id: id,
                        ratings: []
                    });

                //get the appropriate volunteer
                var tmp = $.grep(volunteers, function (e) {
                    return e.id == id;
                });

                //set the score
                tmp[0].ratings.push({
                    attrId: $(this).attr("data-attr-id"),
                    rating: $(this).raty("score")
                });
            });


            //  console.log(volunteers);


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
    });


    //check that all volunteers has been rated before sending the form
    function validate() {
        var count = 0;

        $(".attribute.rating").each(function (index) {
            if ($(this).raty('score') == undefined) {
                $(".error-msg").css('visibility', 'visible');
                return false;
            }
            else {
                count++;
            }
        });

        if (count == $(".attribute.rating").length) {
            $(".error-msg").css('visibility', 'hidden');
            return true;
        }
    }
</script>


</body>
</html>
