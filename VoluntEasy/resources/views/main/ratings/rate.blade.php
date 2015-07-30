<!DOCTYPE html>
<?php  $lang = "/default."; ?> {{--  resource label path --}}
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
                                   class="logo-name text-lg text-center">{{trans($lang.'title')}}</a>

                                <h3 class="text-center">Αξιολόγηση εθελοντή για τη δράση {{ $action->description
                                    }} </h3>
                                <h5 class="text-center">Διάρκεια Δράσης: {{ $action->start_date }} - {{
                                    $action->end_date }}</h5>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4>Όνομα Εθελοντή: {{ $volunteer->name}} {{ $volunteer->last_name }}</h4>

                                        <p><i class="fa fa-envelope"></i> <a href="mailto:{{ $volunteer->email }}">{{
                                            $volunteer->email }}</a> <br/>
                                            <i class="fa fa-home"></i> {{ $volunteer->address=='' ? '-' :
                                            $volunteer->address
                                            }}{{
                                            $volunteer->city=='' ? '' : ', '.$volunteer->city }}{{
                                            $volunteer->post_box==''
                                            ? '' : ', '.$volunteer->post_box }}{{ $volunteer->country=='' ? '' : ',
                                            '.$volunteer->country }} <br/>
                                            @if($volunteer->cell_tel!=null && $volunteer->cell_tel!='') <i
                                                    class="fa fa-phone"></i> {{ $volunteer->cell_tel }} <br/>@endif
                                            @if($volunteer->home_tel!=null && $volunteer->home_tel!='') <i
                                                    class="fa fa-phone"></i> {{ $volunteer->home_tel }} <br/>@endif
                                            @if($volunteer->work_tel!=null && $volunteer->work_tel!='') <i
                                                    class="fa fa-phone"></i> {{ $volunteer->work_tel }} <br/>@endif
                                        </p>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h4>Συνέπεια</h4>
                                            <div id="attr1" class="attribute rating"></div>

                                            <h4>Στυλ</h4>
                                            <div id="attr2" class="attribute rating"></div>

                                            <h4>Αγάπη για γάτες</h4>
                                            <div id="attr3" class="attribute rating"></div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-xs" id="saveRating"
                                                    data-action-id="{{ $action->id }}"
                                                    data-volunteer-id="{{ $volunteer->id }}">Καταχώρηση
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center error-msg" style="visibility:hidden">
                                    <div class="col-md-12">
                                        <p class="text-danger"><em>Πρέπει να καταχωρήσετε αξιολόγηση για όλα τα
                                            πεδία</em></p>
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
                                                εθελονντών
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
        //get the rating in integer form
        attr1 = $('#attr1').raty('score');
        attr2 = $('#attr2').raty('score');
        attr3 = $('#attr3').raty('score');


        //toggle error message
        if (attr1 == undefined || attr2 == undefined || attr2 == undefined)
            $(".error-msg").css('visibility', 'visible');
        else if (attr1 != undefined && attr2 != undefined && attr2 != undefined) {

            $(".error-msg").css('visibility', 'hidden');

            //send data to server to save the ratings
            $.ajax({
                url: $("body").attr('data-url') + '/ratings/store',
                method: 'POST',
                data: {
                    'volunteerId': $(this).attr('data-volunteer-id'),
                    'actionId': $(this).attr('data-action-id'),
                    'attr1': attr1,
                    'attr2': attr2,
                    'attr3': attr3
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/ratings/thankyou";
                }
            });
        }
    });


</script>


</body>
</html>
