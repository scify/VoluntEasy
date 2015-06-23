@foreach ($unit->allChildren as $unit)
@if (sizeof($unit['allChildren']) > 0)
<li data-id="{{ $unit['id'] }}" {{ in_array($unit->id, $active) ? 'class=active-node' : '' }}><span class="description">{{ $unit['description']}}</span>
<ul>
    @include('main.units.partials._branch_actives', $unit['allChildren'])
</ul>
</li>
@else
<li data-id="{{ $unit['id'] }}"  {{ in_array($unit->id, $active) ? 'class=active-node' : '' }}><span class="description">{{ $unit['description']}}</span>
@endif
@endforeach