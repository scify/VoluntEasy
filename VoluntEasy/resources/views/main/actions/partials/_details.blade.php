<p>{{ $action->comments }}</p>
<p>Διάρκεια: {{ $action->start_date }} έως {{ $action->end_date }}</p>
<p>Email υπευθύνου: {{ $action->email=='' ? '-' : $action->email }}</p>


