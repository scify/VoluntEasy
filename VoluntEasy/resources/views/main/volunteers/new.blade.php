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
            <li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-cog m-r-xs"></i>Εργασιακή Εμπειρία & Εθελοντκή Προσφορά</a></li>
            <li role="presentation"><a href="#tab5" data-toggle="tab"><i class="fa fa-clock-o m-r-xs"></i>Διαθεσιμότητα</a></li>
         </ul>
         <div class="progress progress-sm m-t-sm">
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
            </div>
         </div>
         {!! Form::open(['id' => 'wizardForm']) !!}
            <div class="tab-content">
               <div class="tab-pane active fade in" id="tab1">
                  <div class="row m-b-lg">
                     <div class="col-md-6">
                        <div class="row">
                           <div class="form-group col-md-4">
                              {!! Form::label('firstName', 'Όνομα:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'firstName', 'placeholder' => 'Όνομα']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('lastName', 'Επώνυμο:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'lastName', 'placeholder' => 'Επώνυμο']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('fatherName', 'Όνομα Πατέρα:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'fatherName', 'placeholder' => 'Όνομα Πατέρα']) !!}
                           </div>
                           <div class="form-group  col-md-6">
                              {!! Form::label('dateOfBirth', 'Ημερομηνία Γέννησης:') !!}
                              {!! Form::input('date', 'dateOfBirth', null, ['class' => 'form-control'])!!}
                           </div>
                           <div class="form-group  col-md-6">
                               {!! Form::label('dateOfBirth', '') !!}
                               {!! Form::input('date', 'dateOfBirth', null, ['class' => 'form-control'])!!}
                           </div>
                           <!--div class="form-group  col-md-6">
                               <div class="radio">
                                   {!! Form::label('name', 'Φύλο:') !!} <br/>
                                   {!! Form::radio('sex', 'Άνδρας',  ['class' => 'radio']) !!} Άνδρας
                                   {!! Form::radio('sex', 'Γυναίκα', ['class' => 'radio']) !!} Γυναίκα
                               </div>
                           </div-->
                           <div class="form-group  col-md-6">
                               {!! Form::label('identityType', 'Τύπος Ταυτότητας:') !!}
                               {!! Form::text('', null, ['class' => 'form-control', 'id' => 'identityType', 'placeholder' => 'Τύπος Ταυτότητας']) !!}
                           </div>
                           <div class="form-group  col-md-6">
                               {!! Form::label('identityTypeNumber', 'Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής:') !!}
                               {!! Form::text('', null, ['class' => 'form-control', 'id' => 'identityTypeNumber', 'placeholder' => 'Αριθμός Α.Δ.Τ./Διαβατηρίου/Άδειας Παραμονής']) !!}
                           </div>

                           <div class="form-group  col-md-4">
                              {!! Form::label('address', 'Διεύθυνση:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Διεύθυνση']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                               {!! Form::label('addressNumber', 'Αριθμός:') !!}
                               {!! Form::text('', null, ['class' => 'form-control', 'id' => 'addressNumber', 'placeholder' => 'Αριθμός']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('zipCode', 'Τ.Κ.:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'zipCode', 'placeholder' => 'Τ.Κ.']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('city', 'Πόλη:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Πόλη']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('country', 'Χώρα:') !!}
                              {!! Form::text('', null, ['class' => 'form-control', 'id' => 'country', 'placeholder' => 'Χώρα']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                             <div class="checkbox">
                              {!! Form::label('name', 'Κάτοικος Ελλάδας:') !!}
                              {!! Form::checkbox('greeceCitizen', null, true, ['class' => 'checker']) !!}
                             </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <h3>Personal Info</h3>
                        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.</p>
                        <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla.</p>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="tab2">
                  <div class="row">
                        <div class="row">
                           <div class="form-group col-md-4">
                              {!! Form::label('phoneNumberHome', 'Τηλέφωνο Οικίας:') !!}
                              {!! Form::text('phoneNumberHome', null, ['class' => 'form-control', 'id' => 'phoneNumberHome', 'placeholder' => 'Τηλέφωνο Οικίας']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('phoneNumberWork', 'Τηλέφωνο Εργασίας:') !!}
                              {!! Form::text('phoneNumberWork', null, ['class' => 'form-control', 'id' => 'phoneNumberWork', 'placeholder' => 'Τηλέφωνο Εργασίας']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('mobileNumber', 'Κινητό:') !!}
                              {!! Form::text('mobileNumber', null, ['class' => 'form-control', 'id' => 'mobileNumber', 'placeholder' => 'Κινητό']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                               {!! Form::label('fax', 'Fax:') !!}
                               {!! Form::text('fax', null, ['class' => 'form-control', 'id' => 'fax', 'placeholder' => 'Fax']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                               {!! Form::label('name', 'Email:') !!}
                               {!! Form::input('email', 'email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                               {!! Form::label('communicationMethod', 'Να επικοινωνήσουμε μαζί σας στο:') !!}
                               {!! Form::select('communicationMethod', ['email' => 'Ηλεκτρονικό ταχυδρομείο',
                                                                        'phoneNumberHome' => 'Τηλέφωνο Οικίας',
                                                                        'phoneNumberWork' => 'Τηλέφωνο Εργασίας',
                                                                        'mobileNumber' => 'Κινητό Τηλέφωνο'], null, ['class' => 'form-control']) !!}
                           </div>
                      </div>
                   </div>
               </div>
               <div class="tab-pane fade" id="tab3">
                  <div class="row">
                     <div class="col-md-12">
                           <div class="form-group  col-md-4">
                               {!! Form::label('educationLevel', 'Επίπεδο εκπαίδευσης:') !!}
                               {!! Form::select('educationLevel', ['gumnasio' => 'Γυμνάσιο',
                                                                   'lukeio' => 'Λύκειο',
                                                                   'anwteri' => 'Ανώτερη',
                                                                   'anwtati' => 'Ανώτατη',
                                                                   'metaptuxiaka' => 'Μεταπτυχιακά'], null, ['class' => 'form-control']) !!}
                           </div>
                           <div class="form-group col-md-4">
                              {!! Form::label('specialty', 'Ειδικότητα:') !!}
                              {!! Form::text('specialty', null, ['class' => 'form-control', 'id' => 'specialty', 'placeholder' => 'Ειδικότητα']) !!}
                           </div>
                           <div class="form-group  col-md-4">
                              {!! Form::label('department', 'Σχολή:') !!}
                              {!! Form::text('department', null, ['class' => 'form-control', 'id' => 'department', 'placeholder' => 'Σχολή']) !!}
                           </div>
                            <div class="form-group  col-md-4">
                                {!! Form::label('educationLevel', 'Δίπλωμα οδήγησης - Κατηγορία:') !!}
                                {!! Form::select('educationLevel', ['gumnasio' => 'Γυμνάσιο',
                                                                    'lukeio' => 'Λύκειο',
                                                                    'anwteri' => 'Ανώτερη',
                                                                    'anwtati' => 'Ανώτατη',
                                                                    'metaptuxiaka' => 'Μεταπτυχιακά'], null, ['class' => 'form-control']) !!}
                            </div>
                           <div class="form-group  col-md-4">
                             <div class="checkbox">
                              {!! Form::label('computerUse', 'Χρήση υπολογιστή:') !!}
                              {!! Form::checkbox('computerUse', null, true, ['class' => 'checker']) !!}
                             </div>
                           </div>
                           <div class="form-group  col-md-6">
                              {!! Form::label('additionalSkills', 'Πρόσθετες ικανότητες, προσόντα και εμπειρία:') !!}
                              {!! Form::textarea('additionalSkills', null, ['class' => 'form-control', 'id' => 'additionalSkills']) !!}
                           </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="tab4">
                  <h2 class="no-s">Thank You !</h2>
                  <div class="alert alert-info m-t-sm m-b-lg" role="alert">
                     Congratulations ! You got the last step.
                  </div>
               </div>
               <div class="tab-pane fade" id="tab5">
                                 <h2 class="no-s">Thank You !</h2>
                                 <div class="alert alert-info m-t-sm m-b-lg" role="alert">
                                    Congratulations ! You got the last step.
                                 </div>
               </div>
               <ul class="pager wizard">
                  <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                  <li class="next"><a href="#" class="btn btn-default">Next</a></li>
               </ul>
            </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>
<!--
<div class="form-group">
   {!! Form::label('name', 'Όνομα:') !!}
   {!! Form::text('', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
   {!! Form::label('name', 'Επώνυμο:') !!}
   {!! Form::text('', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
   {!! Form::label('name', 'Όνομα Πατέρα:') !!}
   {!! Form::text('', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
   {!! Form::label('name', 'Τύπος Ταυτότητας:') !!}
   {!! Form::text('', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
   {!! Form::label('name', 'Τύπος Ταυτότητας:') !!}
   {!! Form::text('', null, ['class' => 'form-control']) !!}
</div>
-->
@stop