@foreach ($unit->allChildren as $unit)
@if (sizeof($unit['allChildren']) > 0)
<li data-id="{{ $unit['id'] }}" class="branch {{ in_array($unit->id, $actives) ? 'active-node' : '' }} {{ in_array($unit['id'], $userUnits) ? '' : 'disabled' }} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span class="description">{{ $unit['description']}}</span>
<ul>
    @include('main.tree._branch_actives', $unit['allChildren'])
</ul>
</li>
@else
<li data-id="{{ $unit['id'] }}"  class="leaf {{ in_array($unit->id, $actives) ? 'active-node' : '' }} {{ in_array($unit['id'], $userUnits) ? '' : 'disabled notAssigned' }} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span class="description">{{ $unit['description']}}</span></li>
@endif
@endforeach
