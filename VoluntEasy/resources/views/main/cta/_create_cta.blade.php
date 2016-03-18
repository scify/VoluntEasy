@if($isPermitted)
    <div class="row">
        <div class="col-md-12">
            <p>{{ trans('entities/cta.createCTA') }}</p>

            <p><a href="{{ url('cta') }}" target="_blank">{{ trans('entities/cta.sample') }}</a></p>
        </div>
    </div>

    <hr/>

    {!! Form::open(['id' => 'createPublicAction', 'method' => 'GET', 'action' => ['CTAController@store']]) !!}
    @include('main.cta._form')

    <div class="row">
        <div class="col-md-12">
            <div class="form-group text-right">
                <p class="text-danger errors" style="display:none;">{{ trans('entities/cta.fillFields') }}</p>
                {!! Form::submit(trans('default.save'), ['class' => 'btn btn-success', 'id' => 'savePublicAction']) !!}
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
            }
            else {
                $('#createPublicAction .errors').hide();

                $.ajax({
                    type: $('#createPublicAction').attr('method'),
                    url: $('#createPublicAction').attr('action'),
                    data: $('#createPublicAction').serialize(),
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
            <p>{{ trans('entities/cta.noRights') }}</p>
        </div>
    </div>

@endif
