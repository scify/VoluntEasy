@foreach ($unit->allChildren as $unit)
    @if (sizeof($unit['allChildren']) > 0)
        <li data-id="{{ $unit['id'] }}">{{ $unit['id'] }} <span class="description">{{ $unit['description']}}</span>
            <ul>
                @include('main.units.partials._branch', $unit['allChildren'])
            </ul>
        </li>
    @else
        <li data-id="{{ $unit['id'] }}">{{ $unit['id'] }} <span class="description">{{ $unit['description']}}</span>
    @endif
@endforeach