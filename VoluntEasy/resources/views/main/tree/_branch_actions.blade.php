@foreach ($unit->allChildren as $unit)
@if (sizeof($unit['allChildren']) > 0)
<li data-id="{{ $unit['id'] }}" class="parent {{ (isset($creating) && $creating=='unit') ? 'disabled notAssigned' : '' }} {{ isset($creating) && $creating=='action' ? 'disabled hasUnits' : ''}} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span
        class="description">{{ $unit['description']}}</span>
    <ul>
        @include('main.tree._branch_actions', ['unit' => $unit])
    </ul>
</li>
@else
<li data-id="{{ $unit['id'] }}"
    class="leaf {{ sizeof($unit->actions) > 0 ? 'hasActions' : '' }} {{ in_array($unit->id, $userUnits) ? '' : 'disabled notAssigned' }} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}} {{ isset($creating) && $creating=='unit' && sizeof($unit->actions) > 0 ? 'disabled' : ''}}">
    <span class="description">{{ $unit['description']}}</span>
    @if (sizeof($unit->actions) > 0)
    <ul>
        @foreach ($unit->actions as $action)
        <li class="action {{ isset($creating) && $creating=='unit' ? 'disabled' : ''}}" data-id="{{ $action->id }}"><span class="description">{{ $action['description']}}</span></li>
        @endforeach
    </ul>
    @endif
</li>
@endif
@endforeach

