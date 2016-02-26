<div class="row">
    <div class="col-md-12">
        <p>Δημιουργήστε τη δημόσια σελίδα που θα βλέπουν οι εθελοντές για να δηλώσουν το ενδιαφέρον τους για τη
            δράση.</p>

        <p><a href="{{ url('cta') }}" target="_blank">Δείγμα δημόσιας σελίδας</a></p>
    </div>
</div>

<hr/>

{!! Form::open(['id' => 'createPublicAction', 'method' => 'GET', 'action' => ['CTAController@store']]) !!}
@include('main.cta._form')

<div class="row">
    <div class="col-md-12">
        <div class="form-group text-right">
            <p class="text-danger errors" style="display:none;">Συμπληρώστε τα απαιτούμενα πεδία.</p>
            {!! Form::submit('Αποθήκευση', ['class' => 'btn btn-success', 'id' => 'savePublicAction']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}


@section('footerScripts')
<script>
    $('#savePublicAction').click(function () {
        event.preventDefault();

        if ($('#public_description').val() == null || $('#public_description').val() == '' || $('#public_address').val() == null || $('#public_address').val() == '') {
            $('#createPublicAction .errors').show();
            console.log('aaa')
        }
        else {
            $('#createPublicAction .errors').hide();

            $.ajax({
                type: $('#createPublicAction').attr('method'),
                url: $('#createPublicAction').attr('action'),
                data: $('#createPublicAction').serialize(),
                success: function (data) {
                    console.log(data);
                    location.reload();
                }

            });
            return false; // prevent send form
        }
    });


</script>

@append
