@foreach ($unit->allChildren as $unit)
@if (sizeof($unit['allChildren']) > 0)
<li data-id="{{ $unit['id'] }}" class="disabled parent"><span
        class="description">{{ $unit['id'].$unit['description']}}</span>
    <ul>
        @include('main.tree._branch_actions', ['unit' => $unit])
    </ul>
</li>
@else
<li data-id="{{ $unit['id'] }}"
    class="leaf {{ sizeof($unit->actions) > 0 ? 'hasActions' : '' }} {{ in_array($unit->id, $userUnits) ? '' : 'disabled notAssigned' }}">
    <span class="description">{{ $unit['id'].$unit['description']}}</span>
    @if (sizeof($unit->actions) > 0)
    <ul>
        @foreach ($unit->actions as $action)
        <li class="action" data-id="{{ $action->id }}"><span class="description">{{ $action['description']}}</span></li>
        @endforeach
    </ul>
    @endif
</li>
@endif
@endforeach

