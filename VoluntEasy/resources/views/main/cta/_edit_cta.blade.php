@if($isPermitted)
    <div class="row">
        <div class="col-md-12">
            <p>{{ trans('entities/cta.editCTA') }}</p>

            <p><a href="{{ url('participate/'.$action->publicAction->public_url) }}" target="_blank">{{ trans('entities/cta.view') }}</a></p>
        </div>
    </div>

    <hr/>

    {!! Form::model(null, ['id' => 'editPublicAction', 'method' => 'POST', 'action' => ['CTAController@update']]) !!}
    @include('main.cta._form')
    <input type="hidden" name="publicActionId" class="publicActionId" value="{{$action->publicAction->id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group text-right">
                <p class="text-danger errors" style="display:none;">{{ trans('entities/cta.fillFields') }}</p>
                {!! Form::submit( trans('default.save') , ['class' => 'btn btn-success', 'id' => 'updatePublicAction']) !!}
            </div>
        </div>
    </div>


    {!! Form::close() !!}


@section('footerScripts')
    <script>
        VE.ready(function () {
            var form = document.getElementById('editPublicAction');

            VE.on('#updatePublicAction', 'click', function (event) {
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

            <p><a href="{{ url('participate/'.$action->publicAction->public_url) }}" target="_blank">{{ trans('entities/cta.view') }}</a></p>
        </div>
    </div>
@endif
