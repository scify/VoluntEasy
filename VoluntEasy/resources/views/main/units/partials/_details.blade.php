<p id="unitComments">{{$unit->comments}}</p>

@if(sizeof($unit->users)==0)
    <h3>Η μονάδα δεν έχει κανέναν υπεύθυνο</h3>
@elseif(sizeof($unit->users)==1)
    <h3>Υπεύθυνος Μονάδας</h3>
    <p class="user-list"><img src="{{ asset('assets/images/avatar4.png')}}" alt="" class="user-image-small">
    <a href="{{ url('main/users/one/'.$unit->users[0]->id) }}">{{$unit->users[0]->name}}</a></p>
@else
    <h3>Υπεύθυνοι Μονάδας:</h3>
    <ul class="list-unstyled">
        @foreach($unit->users as $user)
        <li><p class="user-list"><img src="{{ asset('assets/images/avatar4.png')}}" alt="" class="user-image-small">
            <a href="{{ url('main/users/one/'.$unit->users[0]->id) }}">{{$unit->users[0]->name}}</a></p>
        </li>
        @endforeach
    </ul>
@endif


@if(sizeof($unit->actions)==0)
<h3>Η μονάδα δεν έχει καμία δράση</h3>
@else
<h3>Δράσεις:</h3>
<ul class="list-unstyled">
    @foreach($unit->actions as $action)
    <li><p class="user-list"><a href="{{ url('main/users/one/'.$unit->users[0]->id) }}">{{$action->description}}</a></p>
    </li>
    @endforeach
</ul>
@endif

