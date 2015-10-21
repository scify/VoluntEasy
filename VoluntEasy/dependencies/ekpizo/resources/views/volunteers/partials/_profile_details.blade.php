<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-4">
        <p><strong>Όνομα πατέρα:</strong> {{ $volunteer->fathers_name=='' ? '-' : $volunteer->fathers_name }}</p>

        <p><strong>Ημ/νία γέννησης:</strong> {{ $volunteer->birth_date }}</p>
        <p><strong>Τηλέφωνο εργασίας:</strong> {{ $volunteer->work_tel=='' ? '-' : $volunteer->work_tel
            }} @if ($volunteer->comm_method_id==3) <i class="fa fa-star" data-toggle="tooltip" title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif</p>

        <p><strong>Τηλέφωνο οικίας:</strong> {{ $volunteer->home_tel=='' ? '-' : $volunteer->home_tel }} @if ($volunteer->comm_method_id==2) <i class="fa fa-star" data-toggle="tooltip" title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif</p>

        <p><strong>Φαξ:</strong> {{ $volunteer->fax=='' ? '-' : $volunteer->fax }}</p>

    </div>
    <div class="col-md-4">
        <p><strong>Διεύθυνση:</strong> {{ $volunteer->address=='' ? '-' : $volunteer->address }}{{
            $volunteer->city=='' ? '' : ', '.$volunteer->city }}{{ $volunteer->post_box==''
            ? '' : ', '.$volunteer->post_box }}{{ $volunteer->country=='' ? '' : ',
            '.$volunteer->country }}
        </p>

        <p><strong>Κάτοικος Ελλάδας:</strong> {{ $volunteer->live_in_curr_country=='' ? 'Όχι' : 'Ναι' }}</p>

        <p><strong>Τύπος ταυτότητας:</strong> {{
            $volunteer->identification_type_id=='' || $volunteer->identification_type_id==null ? '-' : $volunteer->identificationType->description }}</p>

        <p><strong>Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής:</strong> {{
            $volunteer->identification_num=='' || $volunteer->identification_num==null ? '-' : $volunteer->identification_num }}</p>
    </div>
</div>

<div class="row">
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
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Επίπεδο εκπαίδευσης:</strong> {{
                                    $volunteer->education_level_id=='' || $volunteer->education_level_id==null ? '-' : $volunteer->educationLevel->description }}</p>

                                <p><strong>Ειδικότητα:</strong> {{ $volunteer->specialty=='' ? '-' :
                                    $volunteer->specialty }}</p>

                                <p><strong>Σχολή:</strong> {{ $volunteer->department=='' ? '-' :
                                    $volunteer->department }}</p>

                                <p><strong>Δίπλωμα οδήγησης:</strong> {{ $volunteer->driver_license_type_id==null || $volunteer->driver_license_type_id=='' ? '' :
                                    $volunteer->driverLicenceType->description }}</p>

                                <p><strong>Χρήση υπολογιστή:</strong> {{ $volunteer->computer_usage=='' ? 'Όχι' :
                                    'Ναι' }}</p>
                            </div>
                            <div class="col-md-4">
                                <h4>Ξένες Γλώσσες</h4>
                                @if($volunteer->languages==null ||
                                sizeof($volunteer->languages)==0)
                                <p><em>Δεν έχει δηλωθεί καμία ξένη γλώσσα.</em></p>
                                @else
                                @foreach($volunteer->languages as $language)
                                    <p>
                                        {{ $language->language->description }}:
                                        <em>Επίπεδο {{ $language->level->description }}</em>
                                    </p>
                                @endforeach
                                @endif
                                @if($volunteer->extra_lang!=null || $volunteer->extra_lang!='')
                                <p><strong>Άλλες γλώσσες:</strong> {{ $volunteer->extra_lang }}</p>
                                @endif
                            </div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Εργασιακή κατάσταση:</strong> {{ $volunteer->work_status_id==null || $volunteer->work_status_id=='' ? '' :
                                    $volunteer->workStatus->description }}</p>

                                <p><strong>Εργασία:</strong> {{ $volunteer->work_description=='' ? '-' :
                                    $volunteer->work_description }}</p>

                                <p><strong>Εθελοντική οργάνωση:</strong> {{ $volunteer->participation_actions=='' ?
                                    '-' :
                                    $volunteer->participation_actions }}</p>

                                <p><strong>Εθελοντικές δράσεις:</strong> {{ $volunteer->participation_previous=='' ?
                                    '-' :
                                    $volunteer->participation_previous }}</p>

                                <p><strong>Λόγος συμμετοχής:</strong> {{ $volunteer->participation_reason=='' ? '-' :
                                    $volunteer->participation_reason }}</p>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Διαθεσιμότητα</h4>

                                <p><strong>Συχνότητα συνεισφοράς:</strong> {{ $volunteer->availability_freqs_id==null || $volunteer->availability_freqs_id=='' ? '' :
                                    $volunteer->availabilityFrequencies->description }}</p>

                                @if($volunteer->availability_freqs_id==1)
                                    <p><strong>Χρόνοι συνεισφοράς:</strong>
                                        @if($volunteer->availabilityTimes!=null || sizeof($volunteer->availabilityTimes)!=0)
                                            @foreach($volunteer->availabilityTimes as $availabilityTime)
                                            {{ $availabilityTime->description }}
                                            @endforeach
                                        @endif

                                @elseif($volunteer->availability_freqs_id==2 || $volunteer->availability_freqs_id==3 || $volunteer->availability_freqs_id==4)
                                    @if(isset($volunteer->availabilityDays) && sizeof($volunteer->availabilityDays)>0)
                                        <p><strong>Μέρες και ώρες συνεισφοράς:</strong>
                                        @foreach($volunteer->availabilityDays as $i => $day)
                                        @if($i==0)
                                        {{ $day->day }} {{ mb_convert_case($day->time, MB_CASE_LOWER, "UTF-8") }}
                                    @else
                                        , {{ $day->day }} {{ mb_convert_case($day->time, MB_CASE_LOWER, "UTF-8") }}
                                        @endif
                                    @endforeach
                                    </p>
                                    @endif
                                 @endif

                                    @if(sizeof($volunteer->unitsExcludes)>0)
                                    <p><strong>Ο εθελοντής δεν μπορεί να ενταχθεί στις μονάδες:</strong>
                                        @foreach($volunteer->unitsExcludes as $i => $unit)
                                        @if($i>0)
                                        , {{ $unit->description }}
                                        @else
                                        {{ $unit->description }}
                                        @endif
                                        @endforeach
                                    </p>
                                 @endif

                                @if($volunteer->howYouLearned!=null)
                                <p><strong>Πώς μάθατε για εμάς;</strong> {{ $volunteer->howYouLearned->description }}
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h4>Ενδιαφέροντα</h4>
                                @if($volunteer->interests==null ||
                                sizeof($volunteer->interests)==0)
                                <p><em>Δεν έχει δηλωθεί κανένα ενδιαφέρον.</em></p>
                                @else
                                <p>
                                @foreach($volunteer->interests as $i => $interest)
                                    @if($i==0)
                                    {{ $interest->description }}
                                    @else
                                    , {{ $interest->description }}
                                    @endif
                                @endforeach
                                </p>
                                @endif
                                @if($volunteer->additional_skills!=null ||
                                $volunteer->additional_skills!='')
                                <p>Πρόσθετες ικανότητες, προσόντα και εμπειρία: {{
                                    $volunteer->additional_skills }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($volunteer->permitted)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFour" aria-expanded="false"
                           aria-controls="collapseFour">
                            <i class="fa fa-file-o m-r-xs"></i>Αρχεία
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingFour">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                               @if(sizeof($volunteer->files)>0)

                                <table class="table table-condensed table-bordered">

                                    @foreach($volunteer->files as $file)
                                    <tr>
                                        <td><p><i class="fa fa-file-o"></i> <a
                                                href="{{ asset('assets/uploads/volunteers/'.$file->filename) }}" target="_blank">{{
                                                $file->filename }}</a></p>
                                        </td>
                                        <td class="text-center"><button class="btn btn-danger btn-xs deleteFile" data-id="{{ $file->id }}"
                                                    data-toggle="tooltip" data-placement="bottom" title="Διαγραφή"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
       <h3>Σχόλια για τον εθελοντή</h3>
       @if($volunteer->comments=='')
          <p>Κανένα σχόλιο</p>
       @else
       <p>{{ $volunteer->comments }}</p>
       @endif
        <h3>Συνολική αξιολόγηση εθελοντή</h3>
            @foreach($totalRatings as $rating)
                @if($rating['count']!=0)
                <span id="attr1" class="attribute rating" data-score="{{ $rating['totalRating'] / $rating['count'] }}"></span>
                <small><span> {{ $rating['description'] }}</span></small>
                <br/>
                @else
                <span id="attr1" class="attribute rating" data-score="0"></span>
                <small><span> {{ $rating['description'] }}</span></small>
                <br/>
                @endif
            @endforeach
       @if($volunteer->permitted)
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ url('volunteers/edit/'.$volunteer->id) }}" class="btn btn-success"><i
                        class="fa fa-edit"></i> Επεξεργασία</a>
                <button class="btn btn-danger" onclick="deleteVolunteer({{$volunteer->id}})"><i
                        class="fa fa-trash"></i> Διαγραφή</button>
            </div>
        </div>
        @endif
        @if(!$volunteer->blacklisted && !$volunteer->not_available && $volunteer->permitted)
        <div class="row">
            <div class="col-md-12 text-right">
                <small><a href="#" class="text-danger" data-toggle="modal" data-target="#notAvailable">Σήμανση εθελοντή ως μη διαθέσιμος</a></small>
            </div>
        </div>
        @endif
        @if(!$volunteer->blacklisted && $volunteer->permitted)
        <div class="row">
            <div class="col-md-12 text-right">
                <small><a href="#" class="text-danger" data-toggle="modal" data-target="#blacklisted">Σήμανση εθελοντή ως blacklisted</a></small>
            </div>
        </div>
        @endif
    </div>
</div>

@if(!$volunteer->blacklisted && !$volunteer->not_available && $volunteer->permitted)
<!-- Select unit modal -->
<div class="modal fade" id="notAvailable">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Σήμανση εθελοντή ως μη διαθέσιμος</h4>
            </div>
            <div class="modal-body">
               <p>Σε περίπτωση που ο εθελοντής δεν μπορεί να πάρει μέρος σε δράσεις για κάποιο χρονικό διάστημα, μπορείτε να τον επισημάνετε ως "Μη διαθέσιμο".</p>

                <div class="row">
                    <div class="col-md-6">
                        {!! Form::formInput('not_available_from', 'Από:', $errors, ['class' => 'form-control
                        startDate', 'id' => 'not_available_from', 'required' => 'true']) !!}
                        <small class="help-block text-danger" id="fillDateFrom" style="display:none;">Συμπληρώστε το πεδίο</small>
                    </div>
                    <div class="col-md-6">
                        {!! Form::formInput('not_available_to', 'Εώς:', $errors, ['class' => 'form-control
                        endDate', 'id' => 'not_available_to', 'required' => 'true']) !!}
                        <small class="help-block text-danger" id="fillDateTo" style="display:none;">Συμπληρώστε το πεδίο</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    {!! Form::formInput('not_available_comments', 'Σχόλια:', $errors, ['class' => 'form-control', 'type' =>
                    'textarea']) !!}
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-danger notAvailable" data-volunteer-id="{{ $volunteer->id }}">Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif

@if(!$volunteer->blacklisted && $volunteer->permitted)
<!-- Select unit modal -->
<div class="modal fade" id="blacklisted">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Σήμανση εθελοντή ως blacklisted</h4>
            </div>
            <div class="modal-body">
                <p>Σε περίπτωση που θέλετε να επισημάνετε τον εθελοντή ως blacklisted, ο εθελοντής θα σταματήσει να ανήκει σε οποιαδήποτε μονάδα και δράση ανήκει μέχρι στιγμής.</p>
                {!! Form::formInput('comments', 'Σχόλια', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Σχόλια σχετικά με τον εθελοντή', 'value' => $volunteer->comments, 'id' => 'blacklistedComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-danger blacklisted" data-volunteer-id="{{ $volunteer->id }}">Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif



@section('footerScripts')
<script>

    $('.attribute.rating').raty({
        starOff: '{{ asset("assets/plugins/raty/lib/images/star-off.png")}}',
        starOn: '{{ asset("assets/plugins/raty/lib/images/star-on.png")}}',
        starHalf: '{{ asset("assets/plugins/raty/lib/images/star-half.png")}}',
        readOnly: true,
        score: function() {
            return $(this).attr('data-score');
        }
    });

    //change volunteer status to blacklisted
    $(".blacklisted").click(function(){
        $.ajax({
            url: $("body").attr('data-url') + '/volunteers/blacklisted',
            method: 'POST',
            data: {
                'id': $(this).attr('data-volunteer-id'),
                'comments': $("#blacklistedComments").val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    });

    //change volunteer status to not available
    $(".notAvailable").click(function(){
        var from = $("#not_available_from").val(),
            to = $("#not_available_to").val(),
            flag = true;

        if(from == null || from == '') {
            $("#fillDateFrom").show();
            flag = false;
        }
        else
            $("#fillDateFrom").hide();

        if(to == null || to == '') {
            $("#fillDateTo").show();
            flag = false;
        }
        else
            $("#fillDateTo").hide();

        if(flag) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/notAvailable',
                method: 'POST',
                data: {
                    'id': $(this).attr('data-volunteer-id'),
                    'from': from,
                    'to': to,
                    'comments': $("#not_available_comments").val()
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                     window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
                }
            });
        }
    });


    //delete a file
    $(".deleteFile").click(function () {
        console.log("clicky");
        if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το αρχείο;")) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/deleteFile',
                method: 'POST',
                data: {
                    'id': $(this).attr('data-id')
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    document.location.reload();
                }
            });
        }
    });

</script>
@append
