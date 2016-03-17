<p>{{ $action->comments }}</p>
<p>{{ trans('entities/actions.duration') }}: {{ $action->start_date }} έως {{ $action->end_date }}</p>
<p>{{ trans('entities/actions.execEmail') }}: {{ $action->email=='' ? '-' : $action->email }}</p>


