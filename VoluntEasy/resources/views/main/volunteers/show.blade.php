@extends('default')

@section('title')
Προβολή Εθελοντή
@stop

@section('pageTitle')
Προβολή Εθελοντή
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"
                                                              class="{{ $errors->has('name') || $errors->has('last_name') || $errors->has('fathers_name') ||$errors->has('birth_date') ? 'tab has-error' : ''}}"><i
                            class="fa fa-user m-r-xs"></i>Ατομικά
                        Στοιχεία</a></li>
                    <li role="presentation"><a href="#tab2" data-toggle="tab"
                                               class="{{ $errors->has('email') ? 'tab has-error' : ''}}"><i
                            class="fa fa-circle-o-notch m-r-xs"></i>Τρέχουσα κατάσταση</a></li>
                    <li role="presentation"><a href="#tab3" data-toggle="tab"
                                               class="{{ $errors->has('participation_reason') ? 'tab has-error' : ''}}"><i
                            class="fa fa-file-o m-r-xs"></i>Ιστορικό δράσεων</a></li>
                </ul>

                <div class="tab-content">
                    <!-- tab1 Ατομικά στοιχεία.-->
                    <div class="tab-pane active fade in" id="tab1">
                        @include('main.volunteers.partials._profile_details')
                    </div>
                    <div class="tab-pane fade in" id="tab2">
                        @include('main.volunteers.partials._profile_status')
                    </div>
                    <div class="tab-pane fade in" id="tab3" style="background-color: rgb(233, 237, 242);">
                        @include('main.volunteers.partials._timeline')
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



@stop


@section('footerScripts')
<script>
    $("#tree").jOrgChart({
        chartElement: '#unitsTree',
        disabled: true
    });


    //initialize user select
    $('#volunteerList').select2();


    // get the array of volunteers selected and save them
    $("#saveVolunteers").click(function () {
        //array of volunteers
        var volunteers = [];
        $('#volunteerList :selected').each(function (i, selected) {
            volunteers[i] = $(selected).val();
        });

        var volunteersUnits = {
            id: $("#saveVolunteers").attr('data-id'),
            volunteers: volunteers
        };

        console.log(volunteersUnits);

        $.ajax({
            url: $("body").attr('data-url') + '/units/volunteers',
            method: 'POST',
            data: volunteersUnits,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/units/one/" + data;
            }
        });
    });

</script>
@stop
