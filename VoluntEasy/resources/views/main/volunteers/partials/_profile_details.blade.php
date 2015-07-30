<div class="row">
    <div class="col-md-4">
        <p><strong>Όνομα:</strong> {{ $volunteer->name }}</p>

        <p><strong>Επώνυμο:</strong> {{ $volunteer->last_name }}</p>

        <p><strong>Όνομα πατέρα:</strong> {{ $volunteer->fathers_name }}</p>

        <p><strong>Ημ/νία γέννησης:</strong> {{ $volunteer->birth_date }}</p>

        <p><strong>Φύλο:</strong> {{ $volunteer->gender->description }}</p>
    </div>
    <div class="col-md-4">
        <p><strong>Email:</strong> {{ $volunteer->email=='' ? '-' : $volunteer->email }} @if ($volunteer->comm_method_id==1) <i class="fa fa-star" data-toggle="tooltip" title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif </p>

        <p><strong>Κινητό:</strong> {{ $volunteer->cell_tel=='' ? '-' : $volunteer->cell_tel }} @if ($volunteer->comm_method_id==4) <i class="fa fa-star" data-toggle="tooltip" title="Προτιμώμενος τρόπος επικοινωνίας"></i> @endif</p>

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

        <p><strong>Τύπος ταυτότητας:</strong> {{ $volunteer->identificationType->description }}</p>

        <p><strong>Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής:</strong> {{
            $volunteer->identification_num=='' ? '-' : $volunteer->identification_num }}</p>
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
                                    $volunteer->educationLevel->description }}</p>

                                <p><strong>Ειδικότητα:</strong> {{ $volunteer->specialty=='' ? '-' :
                                    $volunteer->specialty }}</p>

                                <p><strong>Σχολή:</strong> {{ $volunteer->department=='' ? '-' :
                                    $volunteer->department }}</p>

                                <p><strong>Δίπλωμα οδήγησης:</strong> {{
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
                                <p><strong>Εργασιακή κατάσταση:</strong> {{
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

                                <p><strong>Συχνότητα συνεισφοράς:</strong> {{
                                    $volunteer->availabilityFrequencies->description }}</p>

                                <p><strong>Χρόνοι συνεισφοράς:</strong>
                                    @if($volunteer->availabilityTimes!=null ||
                                    sizeof($volunteer->availabilityTimes)!=0)
                                    @foreach($volunteer->availabilityTimes as $availabilityTime)
                                    {{ $availabilityTime->description }}
                                    @endforeach
                                    @endif
                            </div>
                            <div class="col-md-4">
                                <h4>Ενδιαφέροντα</h4>
                                @if($volunteer->interests==null ||
                                sizeof($volunteer->interests)==0)
                                <p><em>Δεν έχει δηλωθεί κανένα ενδιαφέρον.</em></p>
                                @else
                                @foreach($volunteer->interests as $interest)
                                <p>{{ $interest->description }}</p>
                                @endforeach
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
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
     <h3>Αξιολόγηση Εθελοντή</h3>
        @if($volunteer->ratings==null)
       <p>Δεν έχει γίνει καμία αξιολόγηση για τον εθελοντή</p>
        @else
        <div class="row">
            <div class="col-md-3">
        <h4>Συνέπεια</h4>
        <div id="attr1" class="attribute rating" data-score="{{ $volunteer->ratings->rating_attr1 / $volunteer->ratings->rating_attr1_count }}"></div>
            </div>
            <div class="col-md-3">
                <h4>Στυλ</h4>
                <div id="attr2" class="attribute rating" data-score="{{ $volunteer->ratings->rating_attr2 / $volunteer->ratings->rating_attr2_count }}"></div>
               </div>
            <div class="col-md-3">
                <h4>Αγάπη για γάτες</h4>
                <div id="attr3" class="attribute rating" data-score="{{ $volunteer->ratings->rating_attr3 / $volunteer->ratings->rating_attr3_count }}"></div>
            </div>
        </div>
        <hr/>
        @endif
       <h3>Σχόλια για τον εθελοντή</h3>
       @if($volunteer->comments=='')
          <p>Κανένα σχόλιο</p>
       @else
       <p>{{ $volunteer->comments }}</p>
       @endif
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ url('volunteers/edit/'.$volunteer->id) }}" class="btn btn-success"><i
                        class="fa fa-edit"></i> Επεξεργασία</a>
                <a href="{{ url('volunteers/delete/'.$volunteer->id) }}" class="btn btn-danger"><i
                        class="fa fa-trash"></i> Διαγραφή</a>
            </div>
        </div>
        @if(!$volunteer->blacklisted)
        <div class="row">
            <div class="col-md-12 text-right">
                <small><a href="#" class="text-danger" data-toggle="modal" data-target="#blacklisted">Σήμανση εθελοντή ως μη διαθέσιμος</a></small>
            </div>
        </div>
        @endif
    </div>
</div>

@if(!$volunteer->blacklisted)
<!-- Select unit modal -->
<div class="modal fade" id="blacklisted">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Σήμανση εθελοντή ως μη διαθέσιμος</h4>
            </div>
            <div class="modal-body">
               <p>Σε περίπτωση που θέλετε να επισημάνετε τον εθελοντή ως μη διαθέσιμο, ο εθελοντής θα σταματήσει να ανήκει σε οποιαδήποτε μονάδα και δράση ανήκει μέχρι στιγμής.</p>
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

</script>
@append
