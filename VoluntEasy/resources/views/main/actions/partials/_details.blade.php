<p>
    @foreach($branch as $key => $unit)
    @if($key < sizeof($branch)-1)
    <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a> <i class="fa fa-angle-right"></i>
    @else
    <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
    @endif
    @endforeach
</p>
<p>{{ $action->comments }}</p>
<p>Διάρκεια: {{ $action->start_date }} έως {{ $action->end_date }}</p>
<p>Email υπευθύνου: {{ $action->email=='' ? '-' : $action->email }}</p>


