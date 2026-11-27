@if($isPermitted)
    <div class="row">
        <div class="col-md-12">
            <p>{{ trans('entities/cta.createCTA') }}</p>

            <p><a href="{{ url('cta') }}" target="_blank">{{ trans('entities/cta.sample') }}</a></p>
        </div>
    </div>

    <hr/>

    {!! Form::open(['id' => 'createPublicAction', 'method' => 'POST', 'action' => ['CTAController@store']]) !!}
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
        VE.ready(function () {
            var form = document.getElementById('createPublicAction');

            VE.on('#savePublicAction', 'click', function (event) {
                event.preventDefault();
                var errors = form.querySelector('.errors');

                if (!document.getElementById('public_description').value || !document.getElementById('public_address').value) {
                    VE.show(errors);
                    return;
                }
                VE.hide(errors);
                VE.http.postForm(form)
                    .then(function () { location.reload(); })
                    .catch(VE.fail);
            });
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
