<p id="unitComments">{{$active->comments}}</p>

@if(sizeof($active->users)==0)
<h3>Η μονάδα δεν έχει κανέναν υπεύθυνο</h3>
@elseif(sizeof($active->users)==1)
<h3>Υπεύθυνος Μονάδας</h3>
<ul class="list-unstyled">
<li class="user-list">
        <div class="msg-img"><img src="{{ asset('assets/uploads/'.$user->image_name)}}" alt="" class="user-image-small userImage"></div>
        <p class="msg-name"> <a href="{{ url('users/one/'.$active->users[0]->id) }}">{{$active->users[0]->name}}</a></p>
        <p class="msg-text"><i class="fa fa-envelope"></i> <a href="mail:to{{ $active->users[0]->email }}">{{ $active->users[0]->email }}</a> |
            <i class="fa fa-home"></i> {{ $active->users[0]->addr }} |
            <i class="fa fa-phone"></i> {{ $active->users[0]->tel }}</p>
    </li>
    </ul>
@else
<h3>Υπεύθυνοι Μονάδας:</h3>
<ul class="list-unstyled">
    @foreach($active->users as $user)
    <li class="user-list">
        <div class="msg-img"><img src="{{ asset('assets/uploads/'.$user->image_name)}}" alt="" class="user-image-small userImage"></div>
        <p class="msg-name"> <a href="{{ url('users/one/'.$user->id) }}">{{$user->name}}</a><p>
        <p class="msg-text"><i class="fa fa-envelope"></i> <a href="mail:to{{ $user->email }}">{{ $user->email }}</a> |
            <i class="fa fa-home"></i> {{ $user->addr }} |
            <i class="fa fa-phone"></i> {{ $user->tel }}</p>
    </li>
    @endforeach
</ul>
@endif

@if($type=='leaf')
@if(sizeof($active->actions)==0)
<h3>Η μονάδα δεν έχει καμία δράση</h3>
@else
<h3>Δράσεις:</h3>
<ul class="list-unstyled">
    @foreach($active->actions as $action)
    <li><p class="user-list"><a href="{{ url('actions/one/'.$action->id) }}">{{$action->description}}</a></p>
    </li>
    @endforeach
</ul>
@endif
@endif

