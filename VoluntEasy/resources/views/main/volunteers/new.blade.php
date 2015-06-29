@extends('default')

@section('title')
    Δημιουργία Εθελοντή/Εθελόντριας
@stop
@section('pageTitle')
    Δημιουργία Εθελοντή/Εθελόντριας
@stop

@section('bodyContent')
<div class="panel panel-white">
   <div class="panel-body">
      <div id="rootwizard">
         <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Ατομικά Στοιχεία</a></li>
            <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-phone m-r-xs"></i>Στοιχεία Επικοινωνίας</a></li>
            <li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-university m-r-xs"></i>Εκπαίδευση & Ικανότητες</a></li>
            <li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-cog m-r-xs"></i>Εργασιακή Εμπειρία & Εθελοντική Προσφορά</a></li>
            <li role="presentation"><a href="#tab5" data-toggle="tab"><i class="fa fa-clock-o m-r-xs"></i>Διαθεσιμότητα</a></li>
         </ul>
         <div class="progress progress-sm m-t-sm">
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
            </div>
         </div>
         {!! Form::open(['id' => 'wizardForm', 'method' => 'POST', 'action' => ['VolunteerController@store']]) !!}
            <div class="tab-content">
<!--
tab1
Ατομικά στοιχεία.
-->
               <div class="tab-pane active fade in" id="tab1">
                  <div class="row m-b-lg">
                        <div class="row">
                           <div class="form-group col-md-4">
                              {!! Form::label('name', 'Όνομα:') !!}
                              {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Όνομα']) !!}
				<br>
				<br>

                              <!-- {!! Form::label('dateOfBirth', 'Ημερομηνία Γέννησης:') !!}<br> -->
                              <!-- {!! Form::input('date', 'dateOfBirth', null, ['required', 'class' => 'form&#45;control'])!!} -->
                              {!! Form::label('birth_date', 'Ημερομηνία Γέννησης:') !!}<br>
				{!! Form::input('birth_date', 'birth_date', null, ['required', 'class' => 'form-control', 'id' => 'birth_date']) !!}
                                   <!--
				     <div class="form-group  col-md-4">
				        {!! Form::selectMonth('month', null, ['class' => 'form-control']) !!}
				     </div>
				     <div class="form-group  col-md-4">
				        {!! Form::selectRange('day', 1, 31, null, ['class' => 'form-control']) !!}
				     </div>
				     <div class="form-group  col-md-4">
				        {!! Form::selectYear('year', Carbon\Carbon::now()->year, (new Carbon\Carbon('100 years ago'))->year, null, ['class' => 'form-control']) !!}
				     </div>
                                   -->

				<br>
				<br>
				<br>
				<br>

			   	 {!! Form::label('Αριθμός τέκνων:') !!}<br>
                                 {!! Form::text('', null, ['class' => 'form-control', 'id' => 'children', 'placeholder' => 'Αριθμός τέκνων']) !!}

				<br>
				<br>

                              {!! Form::label('city', 'Πόλη:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Πόλη']) !!}

                           </div>

                           <div class="form-group  col-md-4">
                              {!! Form::label('last_name', 'Επώνυμο:') !!}
                              {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => 'Επώνυμο']) !!}

				<br>
				<br>

				 {!! Form::label('identification_type_id', 'Τύπος ταυτότητας') !!}<br>
				 {!! Form::select('identification_type_id', ($id_type), null, ['class' => 'form-control']) !!}

				<br>
				<br>

				   {!! Form::label('gender_id', 'Φύλο:') !!} <br/>
				   {!! Form::select('gender_id', ($genders), null, ['class' => 'form-control']) !!}

				<br>
				<br>

                              {!! Form::label('address', 'Διεύθυνση:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Διεύθυνση']) !!}

				<br>
				<br>

                              {!! Form::label('country', 'Χώρα:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'country', 'placeholder' => 'Χώρα']) !!}
                           </div>

                           <div class="form-group  col-md-4">
                              {!! Form::label('fathers_name', 'Όνομα Πατέρα:') !!}
                              {!! Form::text('fathers_name', null, ['class' => 'form-control', 'id' => 'fathers_name', 'placeholder' => 'Όνομα Πατέρα']) !!}

				<br>
				<br>

                               {!! Form::label('identification_num', 'Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής:') !!}
                               {!! Form::text('identification_num', null, ['class' => 'form-control', 'id' => 'identityTypeNumber', 'placeholder' => 'Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής']) !!}

				<br>
				<br>

			   	 {!! Form::label('marital_status_id', 'Οικογενειακή κατάσταση:') !!}<br>
			   	 {!! Form::select('marital_status_id', ($marital_status), null, ['class' => 'form-control']) !!}

				<br>
				<br>

                              {!! Form::label('zipCode', 'Τ.Κ.:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'post_box', 'placeholder' => 'Τ.Κ.']) !!}

				<br>
				<br>

                              {!! Form::label('live_in_curr_country', 'Κάτοικος Ελλάδας:') !!}
                              {!! Form::checkbox('greeceCitizen', null, true, ['class' => 'checker']) !!}
				<em>Αποεπιλέξτε εφόσον δε διαμένετε μόνιμα στην Ελλάδα.</em>
                           </div>
                     </div>
                  </div>
               </div>
<!--
tab2
Στοιχεία επικοινωνίας.
-->
               <div class="tab-pane fade" id="tab2">
                  <div class="row m-b-lg">
                  <div class="row">
                           <div class="form-group col-md-4">
                              {!! Form::label('home_tel', 'Τηλέφωνο Οικίας:') !!}
                              {!! Form::text('home_tel', null, ['class' => 'form-control', 'id' => 'home_tel', 'placeholder' => 'Τηλέφωνο Οικίας']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('work_tel', 'Τηλέφωνο Εργασίας:') !!}
                              {!! Form::text('work_tel', null, ['class' => 'form-control', 'id' => 'work_tel', 'placeholder' => 'Τηλέφωνο Εργασίας']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('cell_tel', 'Κινητό:') !!}
                              {!! Form::text('cell_tel', null, ['class' => 'form-control', 'id' => 'cell_tel', 'placeholder' => 'Κινητό']) !!}
                           </div>
                   </div>
                        <div class="row">
                           <div class="form-group  col-md-4">
                               {!! Form::label('fax', 'Fax:') !!}
                               {!! Form::text('fax', null, ['class' => 'form-control', 'id' => 'fax', 'placeholder' => 'Fax']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                               {!! Form::label('email', 'Email:') !!}
                               {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                               {!! Form::label('communicationMethod', 'Να επικοινωνήσουμε μαζί σας στο:') !!}
			       {!! Form::select('communicationMethod', ($comm_method), null, ['class' => 'form-control']) !!}
                           </div>
                      </div>
                  </div>
               </div>
<!--
tab3
Εκπαίδευση και ικανότητες.
-->
               <div class="tab-pane fade" id="tab3">
                  <div class="row m-b-lg">
                  <div class="row">
                           <div class="form-group col-md-6">
                               {!! Form::label('education_level_id', 'Επίπεδο εκπαίδευσης:') !!}
			       {!! Form::select('education_level_id', ($ed_level), null, ['class' => 'form-control']) !!}
				<br>
				<br>

                              {!! Form::label('specialty', 'Ειδικότητα:') !!}
                              {!! Form::text('specialty', null, ['class' => 'form-control', 'id' => 'specialty', 'placeholder' => 'Ειδικότητα']) !!}
				<br>
				<br>
                              {!! Form::label('department', 'Σχολή:') !!}
                              {!! Form::text('department', null, ['class' => 'form-control', 'id' => 'department', 'placeholder' => 'Σχολή']) !!}
				<br>
				<br>
				 {!! Form::label('driver_license_type_id', 'Δίπλωμα οδήγησης') !!}<br>
				 {!! Form::select('driver_license_type_id', ($driver_license_type), null, ['class' => 'form-control']) !!}

				<br>
				<br>

                               <div class="checkbox">
                                {!! Form::label('computerUse', 'Χρήση υπολογιστή:') !!}
                                {!! Form::checkbox('computerUse', null, true, ['class' => 'checker']) !!}
				<br>
				<br>
				{!! Form::label('additional_skills', 'Πρόσθετες ικανότητες, προσόντα και εμπειρία:') !!}
				{!! Form::textarea('additional_skills', null, ['class' => 'form-control', 'id' => 'additional_skills']) !!}
                               </div>

                            </div>

                              <div class="form-group col-md-6">
				<p>Ξένες γλώσσες:</p>
				@foreach ($languages as $language)
					<br><br>
					<p>{{ $language . ':' }}</p>
			   	 <!-- {!! Form::label($language . ':' . PHP_EOL) !!} -->
			   	 {!! Form::label('') !!}
					@foreach ($lang_levels as $level)
						<em>{{ $level }}</em>
						{!! Form::radio('level['.$language.']', 0, false, ['class' => 'form-control']) !!}
						{!! Form::label('') !!}
					@endforeach
				@endforeach
				<br>
				<br>
				{!! Form::label('extra_langs', 'Άλλες γλώσσες:') !!}
				{!! Form::textarea('extra_lang', null, ['placeholder' => 'Συμπληρώστε τις επιπλέον γλώσσες που γνωρίζετε και το επιπεδό σας', 'class' => 'form-control', 'id' => 'extra_lang']) !!}
				<br>
				<br>

                              </div>
                     </div>
                  </div>
               </div>
<!--
tab4
Εργασιακή εμπειρία και εθελοντική προσφορά.
-->
               <div class="tab-pane fade" id="tab4">
                  <div class="row m-b-lg">
                  <div class="row">
                           <div class="form-group  col-md-6">
				 <h2>Εργασιακή εμπειρία</h2>
			   	 {!! Form::label('work_status_id', 'Εργασιακή κατάσταση:') !!}<br>
			   	 {!! Form::select('work_status_id', ($work_statuses), null, ['class' => 'form-control']) !!}
				<br>
				<br>
				{!! Form::label('work_description', 'Εργασία:') !!}
				{!! Form::textarea('extra_lang', null, ['placeholder' => 'Περιγράψτε τη θέση σας στην παρούσα ή πιο πρόσφατη εργασία.', 'class' => 'form-control', 'id' => 'extra_lang']) !!}
                           </div>

                           <div class="form-group  col-md-6">
				 <h2>Εθελοντική προσφορά</h2>
				{!! Form::label('participation_reason', 'Λόγος συμμετοχής:') !!}
				{!! Form::textarea('participation_reason', null, ['placeholder' => 'Περιγράψτε τους λόγους που θέλετε να γίνετε εθελοντής. ', 'class' => 'form-control', 'id' => 'participation_reason']) !!}
				<br>
				<br>
				{!! Form::label('participation_actions', 'Εθελοντική οργάνωση:') !!}
				{!! Form::textarea('', null, ['placeholder' => 'Εαν ανήκετε ή ανήκατε σε κάποιες εθελοντικές οργανώσεις ποιο ήταν το αντικείμενο τους και για πόσο χρονικό διάστημα είχατε συμετοχή.', 'class' => 'form-control', 'id' => 'participation_actions']) !!}
				<br>
				<br>
				{!! Form::label('participation_previous', 'Εθελοντικές δράσεις:') !!}
				{!! Form::textarea('', null, ['placeholder' => 'Εαν έχετε πάρει μέρος σε εθελοντικές δράσεις στο παρελθόν περιγράψτε ποιο ήταν/είναι το αντικείμενο.', 'class' => 'form-control', 'id' => 'participation_previous']) !!}
                           </div>
               </div>
               </div>
               </div>
<!--
tab5
Διαθεσιμότητα.
-->
               <div class="tab-pane fade" id="tab5">
                  <div class="row m-b-lg">
                  <div class="row">
                           <div class="form-group col-md-6">
				<h2>Διαθεσιμότητα:</h2>
				{!! Form::label('availability_freqs_id', 'Συχνότητα συνεισφοράς:') !!}<br>
				{!! Form::select('availability_freqs_id', ($availability_freqs), null, ['class' => 'form-control']) !!}
				<br>
				<br>
				<p>Χρόνοι συνεισφοράς</p>
				{!! Form::label('Χρόνοι συνεισφοράς:') !!}<br>
				{!! Form::select('availability_time', ($availability_times), null, ['class' => 'form-control']) !!}
			   </div>
		  </div>
		  </div>
               <ul class="pager wizard">
                  <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                  <li class="next"><a href="#" class="btn btn-default">Next</a></li>
               </ul>
            </div>
	 {!! Form::submit('Καταχώρηση εθελοντή', ['class' => 'btn']) !!}
         {!! Form::close() !!}
      </div>
   </div>
</div>
@stop
@section('footerScripts')
    <script>
    //datepickers for the edit form
    $('#birth_date').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    </script>
@stop
