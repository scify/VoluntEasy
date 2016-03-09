@if($isPermitted)
    <div class="row">
        <div class="col-md-12">
            <p>Επεξεργαστείτε τη δημόσια σελίδα που θα βλέπουν οι εθελοντές για να δηλώσουν το ενδιαφέρον τους για τη
                δράση.</p>

            <p><a href="{{ url('participate/'.$action->publicAction->public_url) }}" target="_blank">Προβολή δημόσιας
                    σελίδας</a></p>
        </div>
    </div>

    <hr/>

    {!! Form::model(null, ['id' => 'editPublicAction', 'method' => 'GET', 'action' => ['CTAController@update']]) !!}
    @include('main.cta._form')
    <input type="hidden" name="publicActionId" class="publicActionId" value="{{$action->publicAction->id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group text-right">
                <p class="text-danger errors" style="display:none;">Συμπληρώστε τα απαιτούμενα πεδία.</p>
                {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'updatePublicAction']) !!}
            </div>
        </div>
    </div>


    {!! Form::close() !!}


@section('footerScripts')
    <script>
        $('#updatePublicAction').click(function () {
            event.preventDefault();

            if ($('#public_description').val() == null || $('#public_description').val() == '' || $('#public_address').val() == null || $('#public_address').val() == '') {
                $('#editPublicAction .errors').show();
            }
            else {
                $('#editPublicAction .errors').hide();

                $.ajax({
                    type: $('#editPublicAction').attr('method'),
                    url: $('#editPublicAction').attr('action'),
                    data: $('#editPublicAction').serialize(),
                    success: function (data) {
                        location.reload();
                    }

                });
                return false; // prevent send form
            }
        });


    </script>
@append

@else
    <div class="row">
        <div class="col-md-12">
            <p>Δεν έχετε δικαίωμα να επεξεργαστείτε τη δημόσια σελίδας αυτής της δράσης.</p>

            <p><a href="{{ url('participate/'.$action->publicAction->public_url) }}" target="_blank">Προβολή δημόσιας
                    σελίδας</a></p>
        </div>
    </div>
@endif