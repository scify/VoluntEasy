<p class="lead" id="unitDescription">{{$unit->description}}</p>
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

<div class="text-right">
    <a href="{{ url('main/units/edit/'.$unit->id) }}" class="btn btn-success"><i
            class="fa fa-edit"></i> Επεξεργασία</a>
    <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Διαγραφή</button>
</div>