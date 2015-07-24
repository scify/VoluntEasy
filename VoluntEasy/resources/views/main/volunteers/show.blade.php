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
                    <div class="col-md-12 text-right">
                        <a href="{{ url('volunteers/edit/'.$volunteer->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> Επεξεργασία</a>
                        <a href="{{ url('volunteers/delete/'.$volunteer->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i> Διαγραφή</a>
                    </div>
                </div>
                @if($volunteer->blacklisted)
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-danger">Ο εθελοντής έχει επισημανθεί ως μη διαθέσιμος <br/>
                        <small><a href="#" data-toggle="modal" data-target="#unblacklisted">Σήμανση εθελοντή ως διαθέσιμος</a></small>
                        </h3>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"
                                                                      class="{{ $errors->has('name') || $errors->has('last_name') || $errors->has('fathers_name') ||$errors->has('birth_date') ? 'tab has-error' : ''}}"><i
                                    class="fa fa-user m-r-xs"></i>Ατομικά
                                Στοιχεία</a></li>
                            @if(!$volunteer->blacklisted)
                            <li role="presentation"><a href="#tab2" data-toggle="tab"
                                                       class="{{ $errors->has('email') ? 'tab has-error' : ''}}"><i
                                    class="fa fa-circle-o-notch m-r-xs"></i>Τρέχουσα κατάσταση</a></li>
                            @endif
                            <li role="presentation"><a href="#tab3" data-toggle="tab"
                                                       class="{{ $errors->has('participation_reason') ? 'tab has-error' : ''}}"><i
                                    class="fa fa-file-o m-r-xs"></i>Ιστορικό δράσεων</a></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <!-- tab1 Ατομικά στοιχεία.-->
                    <div class="tab-pane active fade in" id="tab1">
                        @include('main.volunteers.partials._profile_details')
                    </div>
                    <div class="tab-pane fade in" id="tab2">
                        @include('main.volunteers.partials._profile_status')

                        @if(!$volunteer->blacklisted)
                        @include('main.volunteers.partials._profile_pending')
                        @endif

                        @if($available>0)
                        @include('main.volunteers.partials._profile_available')
                        @endif
                    </div>
                    <div class="tab-pane fade in" id="tab3" style="background-color: rgb(233, 237, 242);">
                        @include('main.volunteers.partials._timeline')
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@if($volunteer->blacklisted)
<!-- Select unit modal -->
<div class="modal fade" id="unblacklisted">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Σήμανση εθελοντή ως διαθέσιμος</h4>
            </div>
            <div class="modal-body">
                <p>Σε περίπτωση που θέλετε να επισημάνετε τον εθελοντή ως διαθέσιμο, ο εθελοντής θα μπορεί να ενταχθεί ξανά σε δράσεις και μονάδες.</p>
                {!! Form::formInput('comments', 'Σχόλια', $errors, ['class' => 'form-control', 'type' =>
                'textarea', 'placeholder' => 'Σχόλια σχετικά με τον εθελοντή', 'value' => $volunteer->comments, 'id' => 'blacklistedComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-danger unblacklisted" data-volunteer-id="{{ $volunteer->id }}">Αποθήκευση</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif


@stop


@section('footerScripts')
<script>
    //change volunteer status to unblacklisted
    $(".unblacklisted").click(function(){
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
</script>
@append
