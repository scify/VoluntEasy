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
                    <li role="presentation"><a href="#tab4" data-toggle="tab"
                                               class="{{ $errors->has('participation_reason') ? 'tab has-error' : ''}}"><i
                            class="fa fa-file-o m-r-xs"></i>Ιστορικό δράσεων</a></li>
                </ul>

                <div class="tab-content">
                    <!-- tab1 Ατομικά στοιχεία.-->
                    <div class="tab-pane active fade in" id="tab1">
                        <div class="row m-b-lg">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p>Όνομα: {{ $volunteer->name }}</p>

                                    <p>Επώνυμο: {{ $volunteer->last_name }}</p>

                                    <p>Όνομα πατέρα: {{ $volunteer->fathers_name }}</p>

                                    <p>Ημ/νία γέννησης: {{ $volunteer->birth_date }}</p>

                                    <p>Φύλο: {{ $volunteer->gender->description }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p>Email: {{ $volunteer->email=='' ? '-' : $volunteer->email }}</p>

                                    <p>Κινητό: {{ $volunteer->cell_tel=='' ? '-' : $volunteer->cell_tel }}</p>

                                    <p>Τηλέφωνο εργασίας: {{ $volunteer->work_tel=='' ? '-' : $volunteer->work_tel
                                        }}</p>

                                    <p>Τηλέφωνο οικίας: {{ $volunteer->home_tel=='' ? '-' : $volunteer->home_tel }}</p>

                                    <p>Φαξ: {{ $volunteer->fax=='' ? '-' : $volunteer->fax }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p>Διεύθυνση: {{ $volunteer->address=='' ? '-' : $volunteer->address }}{{
                                        $volunteer->city=='' ? '' : ', '.$volunteer->city }}{{ $volunteer->post_box==''
                                        ? '' : ', '.$volunteer->post_box }}{{ $volunteer->country=='' ? '' : ',
                                        '.$volunteer->country }}
                                    </p>

                                    <p>Κάτοικος Ελλάδας: {{ $volunteer->live_in_curr_country=='' ? 'Ναι' : 'Όχι' }}</p>

                                    <p>Τύπος ταυτότητας: {{ $volunteer->identificationType->description }}</p>

                                    <p>Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής: {{
                                        $volunteer->identification_num=='' ? '-' : $volunteer->identification_num }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row m-b-lg">
                            <div class="col-md-12">
                                <div class="panel-group small" id="accordion" role="tablist"
                                     aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapseOne"
                                                   aria-expanded="false" aria-controls="collapseOne"> <i
                                                        class="fa fa-university m-r-xs"></i>
                                                    Εκπαίδευση και Ικανότητες
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                             aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <p>Επίπεδο εκπαίδευσης: {{ $volunteer->educationLevel->description }}</p>

                                                    <p>Ειδικότητα: {{ $volunteer->specialty=='' ? '-' : $volunteer->specialty }}</p>

                                                    <p>Σχολή: {{ $volunteer->department=='' ? '-' : $volunteer->department }}</p>

                                                    <p>Δίπλωμα οδήγησης: {{ $volunteer->driverLicenceType->description }}</p>

                                                    <p>Χρήση υπολογιστή: {{ $volunteer->computer_usage=='' ? 'Ναι' : 'Όχι' }}</p>

                                                    <h4>Ξένες Γλώσσες</h4>

                                                    @foreach($volunteer->languages as $language)
                                                        <p>{{ $language->language->description }}: Επίπεδο {{ $language->level->description }}</p>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapseTwo"
                                                   aria-expanded="false" aria-controls="collapseTwo"><i
                                                        class="fa fa-cog m-r-xs"></i>Εργασιακή Εμπειρία &
                                                    Εθελοντική Προσφορά
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                             aria-labelledby="headingTwo">
                                            <div class="panel-body">
                                                dsdsds
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapseThree" aria-expanded="false"
                                                   aria-controls="collapseThree">
                                                    <i class="fa fa-clock-o m-r-xs"></i>Διαθεσιμότητα & περιοχές
                                                    ενδιαφερόντων
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                             aria-labelledby="headingThree">
                                            <div class="panel-body">
                                                dsdsdds
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
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
