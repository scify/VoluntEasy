@foreach ($unit->allChildren as $unit)
    @if (sizeof($unit['allChildren']) > 0)
        <li data-id="{{ $unit['id'] }}"><span class="description">{{ $unit['description']}}</span>
            <ul>
                @include('main.tree._branch', $unit['allChildren'])
            </ul>
        </li>
    @else
        <li data-id="{{ $unit['id'] }}" class="leaf"><span class="description">{{ $unit['description']}}</span></li>
    @endif
@endforeach
