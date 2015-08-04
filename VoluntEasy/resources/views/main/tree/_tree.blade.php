<div id="unitsTree"></div>
<ul id="tree" style="display:none;">

    {-- Render tree when user views create unit page --}
    {-- User should be able to only click the units which s/he has access to (i.e. in_array($userUnits)) --}
    {-- and the units which do not have actions. --}
    {-- We should also display some useful tooltips on hover. --}

    @if(isset($creating) && $creating=='unit')
    <li data-id="{{$tree->id}}" class="root parent {{ in_array($tree->id, $userUnits) ? '' : 'disabled notAssigned' }} {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span
            class="description">{{$tree->description}}</span>
        <ul>
            @include('main.tree._branch_actions', ['unit' => $tree])
        </ul>
    </li>


    {-- Render tree when user views create action page --}
    {-- User should be able to only click the units which s/he has access to (i.e. in_array($userUnits)) --}
    {-- and the units that are leaves (do not have child units). --}
    {-- We should also display some useful tooltips on hover. --}

    @elseif(isset($creating) && $creating=='action')
    <li data-id="{{$tree->id}}" class="root disabled hasUnits parent {{ isset($tooltips) && $tooltips==true ? 'tooltips' : ''}}"><span
            class="description">{{$tree->description}}</span>
        <ul>
            @include('main.tree._branch_actions', ['unit' => $tree])
        </ul>
    </li>


    @elseif(isset($actives))
    <li data-id="{{$tree->id}}"
        class="root {{ ((isset($editing) && $editing=='unit' && in_array($tree->id, $actives)) || in_array($tree->id, $actives)) ? 'active-node' : '' }}"><span class="description">{{$tree->description}}</span>
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
