@if(sizeof($active->actions)==0)
<h3>Η μονάδα δεν έχει καμία δράση</h3>
@else
<ul class="list-unstyled">
    @foreach($active->actions as $action)
    <li><p class="user-list"><a href="{{ url('main/actions/one/'.$active->id) }}">{{$action->description}}</a></p>
    </li>
    @endforeach
</ul>
@endif


<button type="button" class="btn btn-info" data-toggle="modal" data-target="#actionModal">Προσθήκη Δράσης</button>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="actionModal" aria-labelledby="actionModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Προσθήκη Δράσης</h4>
            </div>
            <div class="modal-body">
                @include('main.actions.partials._form', ['submitButtonText' => 'Αποθήκευση'])
            </div>
        </div>
    </div>
</div>


