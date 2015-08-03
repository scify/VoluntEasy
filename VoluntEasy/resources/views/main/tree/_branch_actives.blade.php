@foreach ($unit->allChildren as $unit)
@if (sizeof($unit['allChildren']) > 0)
<li data-id="{{ $unit['id'] }}" class="branch {{ isset($editing) && $editing=='unit' && in_array($unit->id, $actives) ? 'active-node' : '' }}"><span class="description">{{ $unit['description']}}</span>
<ul>
    @include('main.tree._branch_actives', $unit['allChildren'])
</ul>
</li>
@else
<li data-id="{{ $unit['id'] }}"
    class="leaf {{ isset($editing) && $editing=='unit' && in_array($unit->id, $actives) ? 'active-node' : '' }}">
    <span class="description">{{ $unit['description']}}</span>
    @if (sizeof($unit->actions) > 0)
    <ul>
        @foreach ($unit->actions as $action)
        <li class="action {{ isset($editing) && $editing=='action' && in_array($action->id, $actives) ? 'active-node' : '' }}" data-id="{{ $action->id }}"><span class="description">{{ $action['description']}}</span></li>
        @endforeach
    </ul>
    @endif
</li>
@endif
@endforeach

