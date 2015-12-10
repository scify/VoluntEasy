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
                <div class="row">
                    <div class="col-md-5">
                        <h3>{{ $volunteer->name }} {{ $volunteer->last_name }}
                            @if($volunteer->gender_id!=null && $volunteer->gender_id==1)
                            | <i class="fa fa-mars"></i>
                            @elseif($volunteer->gender_id!=null && $volunteer->gender_id==2)
                            | <i class="fa fa-venus"></i>
                            @endif
                            @if($volunteer->age>0)
                            | {{ $volunteer->age }} ετών</h3>
                            @endif

                        <p><i class="fa fa-envelope"></i> <a href="mailto:{{ $volunteer->email }}">{{ $volunteer->email
                                }}</a> @if ($volunteer->comm_method_id==1) <i class="fa fa-star" data-toggle="tooltip"
                                                                              title="Προτιμώμενος τρόπος επικοινωνίας"></i>
                            @endif

                            @if($volunteer->cell_tel!=null && $volunteer->cell_tel!='')
                            | <i class="fa fa-phone"></i> {{ $volunteer->cell_tel }} @if ($volunteer->comm_method_id==4)
                            <i
                                class="fa fa-star" data-toggle="tooltip"
                                title="Προτιμώμενος τρόπος επικοινωνίας"></i>
                            @endif
                            @endif
                            @if($volunteer->city!=null && $volunteer->country!='')
                            | <i class="fa fa-map-marker"></i>
                            {{ $volunteer->city }}, {{ $volunteer->country }}
                            @endif
                        </p>
                    </div>
                @if($volunteer->blacklisted)
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-danger">Ο εθελοντής έχει επισημανθεί ως blacklisted <br/>
                            @if($volunteer->permitted)
                            <small><a href="#" data-toggle="modal" data-target="#unblacklisted">Σήμανση εθελοντή ως
                                    μη blacklisted</a></small>
                            @endif
                        </h3>
                    </div>
                </div>
                @endif
                @if($volunteer->not_available)
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-danger">Ο εθελοντής έχει επισημανθεί ως μη διαθέσιμος για το διάστημα <strong>{{
                                $volunteer->not_availableFrom}} - {{ $volunteer->not_availableTo}}</strong> <br/>
                            @if($volunteer->permitted)
                            <small><a href="#" data-toggle="modal" data-target="#notAvailableInfo">Πληροφορίες</a>
                            </small>
                            |
                            <small><a href="#" data-toggle="modal" data-target="#available">Σήμανση εθελοντή ως
                                    διαθέσιμος</a></small>
                            @endif
                        </h4>
                    </div>
                </div>
                @endif


                <div class="row top-margin">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"
                                                                      class="{{ $errors->has('name') || $errors->has('last_name') || $errors->has('fathers_name') ||$errors->has('birth_date') ? 'tab has-error' : ''}}"><i
                                        class="fa fa-user m-r-xs"></i>Ατομικά
                                    Στοιχεία</a></li>
                            @if(!$volunteer->blacklisted && !$volunteer->hideStatus)
                            <li role="presentation"><a href="#tab2" data-toggle="tab"
                                                       class="{{ $errors->has('email') ? 'tab has-error' : ''}}"><i
                                        class="fa fa-circle-o-notch m-r-xs"></i>Τρέχουσα κατάσταση</a></li>
                            @endif
                            <li role="presentation"><a href="#tab3" data-toggle="tab"
                                                       class="{{ $errors->has('participation_reason') ? 'tab has-error' : ''}}"><i
                                        class="fa fa-bullseye m-r-xs"></i>Συμμετοχή σε δράσεις</a></li>
                            <li role="presentation"><a href="#tab4" data-toggle="tab"
                                                       class="{{ $errors->has('participation_reason') ? 'tab has-error' : ''}}"><i
                                        class="fa fa-history m-r-xs"></i>Ιστορικό</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <!-- tab1 Ατομικά στοιχεία.-->
                    <div class="tab-pane active fade in" id="tab1">
                        @include($partialsPath.'._profile_details')
                    </div>
                    <div class="tab-pane fade in" id="tab2">
                        @include($partialsPath.'._profile_status')

                        @if(!$volunteer->blacklisted && isset($volunteer->hideStatus) && !$volunteer->hideStatus)
                        @include($partialsPath.'._profile_pending')
                        @endif

                        {{--@if($available>0)
                        @include($partialsPath.'._profile_available')
                        @endif --}}
                    </div>
                    <div class="tab-pane fade in" id="tab3">
                        @include($partialsPath.'._profile_actions')
                    </div>

                    <div class="tab-pane fade in" id="tab4">
                        @include($partialsPath.'._timeline')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@if($volunteer->not_available)
<div class="modal fade" id="available">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Σήμανση εθελοντή ως διαθέσιμος</h4>
            </div>
            <div class="modal-body">
                {!! Form::formInput('notAvailableComments', 'Σχόλια', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'value' => $volunteer->not_availableComments, 'id'
                =>
                'notAvailableComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-success available" data-volunteer-id="{{ $volunteer->id }}"
                        data-status-duration-id="{{ $volunteer->not_availableId }}">
                    Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="notAvailableInfo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Πληροφορίες διαθεσιμότητας</h4>
            </div>
            <div class="modal-body">
                <p>Μη διαθέσιμος από <strong>{{ $volunteer->not_availableFrom }}</strong> έως <strong>{{
                        $volunteer->not_availableTo }}</strong></p>

                <p>Σχόλια<br/>
                    @if($volunteer->not_availableComments==null || $volunteer->not_availableComments=='')
                    <em>Κανένα σχόλιο</em>
                    @else
                    {{ $volunteer->not_availableComments }}
                    @endif
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endif


@if($volunteer->blacklisted)
<div class="modal fade" id="unblacklisted">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Σήμανση εθελοντή ως διαθέσιμος</h4>
            </div>
            <div class="modal-body">
                <p>Σε περίπτωση που θέλετε να επισημάνετε τον εθελοντή ως διαθέσιμο, ο εθελοντής θα μπορεί να
                    ενταχθεί
                    ξανά σε δράσεις και μονάδες.</p>
                {!! Form::formInput('comments', 'Σχόλια', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Σχόλια σχετικά με τον εθελοντή', 'value' => $volunteer->comments, 'id'
                =>
                'blacklistedComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-danger unblacklisted" data-volunteer-id="{{ $volunteer->id }}">
                    Αποθήκευση
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endif


@stop


@section('footerScripts')
<script>

    //change volunteer status to available
    $(".available").click(function () {
        console.log('clicky')
        $.ajax({
            url: $("body").attr('data-url') + '/volunteers/available',
            method: 'POST',
            data: {
                'id': $(this).attr('data-status-duration-id'),
                'comments': $("#notAvailableComments").val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    });


    //change volunteer status to unblacklisted
    $(".unblacklisted").click(function () {
        $.ajax({
            url: $("body").attr('data-url') + '/volunteers/unblacklisted',
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

    //delete user and return to user list
    function deleteVolunteer(id) {
        if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε τον εθελοντή;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    window.location = $("body").attr('data-url') + '/volunteers';
                }
            });
        }
    }
</script>
@append
