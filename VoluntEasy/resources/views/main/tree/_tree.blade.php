<div id="unitsTree"></div>
<ul id="tree" style="display:none;">
    @if(isset($actions) && $actions==true)
    <li data-id="{{$tree->id}}" class="root disabled parent"><span
            class="description">{{$tree->description}}</span>
        <ul>
            @include('main.tree._branch_actions', ['unit' => $tree])
        </ul>
    </li>
    @elseif(isset($actives))
        <li data-id="{{$tree->id}}"
            class="root {{ in_array($tree->id, $actives) ? 'active-node' : '' }} {{ in_array($tree->id, $userUnits) ? '' : 'disabled notAssigned' }} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span class="description">{{$tree->description}}</span>
            <ul>
                @include('main.tree._branch_actives', ['unit' => $tree, 'actives' => $actives])
            </ul>
        </li>
    @else
        <li data-id="{{$tree->id}}"
            class="{{ in_array($tree->id, $userUnits) ? '' : 'disabled notAssigned' }} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span
                class="description">{{$tree->description}}</span>
            <ul>
                @include('main.tree._branch', ['unit' => $tree])
            </ul>
        </li>
    @endif
</ul>
@include('main.tree._legend')
