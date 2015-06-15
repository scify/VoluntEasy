@foreach ($unit->allChildren as $unit)
    @if (sizeof($unit['allChildren']) > 0)
        <li>{{ $unit['id'].' '.$unit['description']}}
            <ul>
                @include('main.units.partials._branch', $unit['allChildren'])
            </ul>
        </li>
    @else
         <li>{{ $unit['id'].' '.$unit['description'] }}</li>
    @endif
@endforeach