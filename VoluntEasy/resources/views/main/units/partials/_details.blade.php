<p id="unitComments">{{$active->comments}}</p>

@if(sizeof($active->users)==0)
    <h3>Η μονάδα δεν έχει κανέναν υπεύθυνο</h3>
@elseif(sizeof($active->users)==1)
    <h3>Υπεύθυνος Μονάδας</h3>
    <p class="user-list"><img src="{{ asset('assets/images/avatar4.png')}}" alt="" class="user-image-small">
    <a href="{{ url('main/users/one/'.$active->users[0]->id) }}">{{$active->users[0]->name}}</a></p>
@else
    <h3>Υπεύθυνοι Μονάδας:</h3>
    <ul class="list-unstyled">
        @foreach($active->users as $user)
        <li><p class="user-list"><img src="{{ asset('assets/images/avatar4.png')}}" alt="" class="user-image-small">
            <a href="{{ url('main/users/one/'.$active->users[0]->id) }}">{{$active->users[0]->name}}</a></p>
        </li>
        @endforeach
    </ul>
@endif


@if(sizeof($active->actions)==0)
<h3>Η μονάδα δεν έχει καμία δράση</h3>
@else
<h3>Δράσεις:</h3>
<ul class="list-unstyled">
    @foreach($active->actions as $action)
    <li><p class="user-list"><a href="{{ url('main/users/one/'.$active->users[0]->id) }}">{{$action->description}}</a></p>
    </li>
    @endforeach
</ul>
@endif

<div class="text-right">
    <a href="{{ url('main/units/edit/'.$active->id) }}" class="btn btn-success"><i
            class="fa fa-edit"></i> Επεξεργασία</a>
    <a href="{{ url('main/units/delete/'.$active->id) }}" class="btn btn-danger"><i
            class="fa fa-edit"></i> Διαγραφή</a>
</div>