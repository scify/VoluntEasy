@foreach ($unit->allChildren as $unit)
    @if (sizeof($unit['allChildren']) > 0)
        <li data-id="{{ $unit['id'] }}">{{ $unit['id'].' '.$unit['description']}}
            <ul>
                @include('main.units.partials._branch', $unit['allChildren'])
            </ul>
        </li>
    @else
         <li data-id="{{ $unit['id'] }}">{{ $unit['id'].' '.$unit['description'] }}</li>
    @endif
@endforeach