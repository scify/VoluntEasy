@if(sizeof($active->actions)==0)
<h3>{{ trans('entities/units.noActions') }}</h3>
@else
<ul class="list-unstyled">
    @foreach($active->actions as $action)
    <li><p class="user-list"><a href="{{ url('actions/one/'.$active->id) }}">{{$action->description}}</a></p>
    </li>
    @endforeach
</ul>
@endif


<button type="button" class="btn btn-info" data-toggle="modal" data-target="#actionModal">{{ trans('entities/units.addAction') }}</button>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="actionModal" aria-labelledby="actionModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">{{ trans('entities/units.addAction') }}</h4>
            </div>
            <div class="modal-body">
                @include('main.actions.partials._form', ['submitButtonText' => {{ trans('default.save') }}])
            </div>
        </div>
    </div>
</div>


