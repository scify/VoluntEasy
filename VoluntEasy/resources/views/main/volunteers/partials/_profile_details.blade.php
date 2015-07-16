<div class="row">
    <div class="col-md-4">
        <p>Όνομα: {{ $volunteer->name }}</p>

        <p>Επώνυμο: {{ $volunteer->last_name }}</p>

        <p>Όνομα πατέρα: {{ $volunteer->fathers_name }}</p>

        <p>Ημ/νία γέννησης: {{ $volunteer->birth_date }}</p>

        <p>Φύλο: {{ $volunteer->gender->description }}</p>
    </div>
    <div class="col-md-4">
        <p>Email: {{ $volunteer->email=='' ? '-' : $volunteer->email }}</p>

        <p>Κινητό: {{ $volunteer->cell_tel=='' ? '-' : $volunteer->cell_tel }}</p>

        <p>Τηλέφωνο εργασίας: {{ $volunteer->work_tel=='' ? '-' : $volunteer->work_tel
            }}</p>

        <p>Τηλέφωνο οικίας: {{ $volunteer->home_tel=='' ? '-' : $volunteer->home_tel }}</p>

        <p>Φαξ: {{ $volunteer->fax=='' ? '-' : $volunteer->fax }}</p>
    </div>
    <div class="col-md-4">
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
                                <p>Επίπεδο εκπαίδευσης: {{
                                    $volunteer->educationLevel->description }}</p>

                                <p>Ειδικότητα: {{ $volunteer->specialty=='' ? '-' :
                                    $volunteer->specialty }}</p>

                                <p>Σχολή: {{ $volunteer->department=='' ? '-' :
                                    $volunteer->department }}</p>

                                <p>Δίπλωμα οδήγησης: {{
                                    $volunteer->driverLicenceType->description }}</p>

                                <p>Χρήση υπολογιστή: {{ $volunteer->computer_usage=='' ? 'Ναι' :
                                    'Όχι' }}</p>
                            </div>
                            <div class="col-md-4">
                                <h4>Ξένες Γλώσσες</h4>
                                @if($volunteer->languages==null ||
                                sizeof($volunteer->languages)==0)
                                <p><em>Δεν έχει δηλωθεί καμία ξένη γλώσσα.</em></p>
                                @else
                                @foreach($volunteer->languages as $language)
                                <p>{{ $language->language->description }}: Επίπεδο {{
                                    $language->level->description }}</p>
                                @endforeach
                                @endif
                                @if($volunteer->extra_lang!=null || $volunteer->extra_lang!='')
                                <p>Άλλες γλώσσες: {{ $volunteer->extra_lang }}</p>
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
                                <p>Εργασιακή κατάσταση: {{
                                    $volunteer->workStatus->description }}</p>

                                <p>Εργασία: {{ $volunteer->work_description=='' ? '-' :
                                    $volunteer->work_description }}</p>

                                <p>Εθελοντική οργάνωση: {{ $volunteer->participation_actions=='' ?
                                    '-' :
                                    $volunteer->participation_actions }}</p>

                                <p>Εθελοντικές δράσεις: {{ $volunteer->participation_previous=='' ?
                                    '-' :
                                    $volunteer->participation_previous }}</p>

                                <p>Λόγος συμμετοχής: {{ $volunteer->participation_reason=='' ? '-' :
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

                                <p>Συχνότητα συνεισφοράς: {{
                                    $volunteer->availabilityFrequencies->description }}</p>

                                <p>Χρόνοι συνεισφοράς:
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
        <div class="panel panel-white">
            <div class="panel-body">
                <h3>Volunteer units</h3>
                @foreach($volunteer->units as $unit)

                <p>{{ $unit->description }}</p>

                @endforeach

            </div>
        </div>
    </div>
</div>
