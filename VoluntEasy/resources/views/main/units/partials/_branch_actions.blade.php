@foreach ($unit->allChildren as $unit)
@if (sizeof($unit['allChildren']) > 0)
<li data-id="{{ $unit['id'] }}" class="{{ in_array($unit->id, $userUnits) ? '' : 'disabled' }}"><span class="description">{{ $unit['id'].$unit['description']}}</span>
    <ul>
        @include('main.units.partials._branch_actions', $unit['allChildren'])
    </ul>
</li>
@else
<li data-id="{{ $unit['id'] }}" class="leaf {{ sizeof($unit->actions) > 0 ? 'hasActions' : '' }} {{ in_array($unit->id, $userUnits) ? '' : 'disabled' }}"><span class="description">{{ $unit['id'].$unit['description']}}</span>
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
