<p>{{ $action->comments }}</p>
<p>{{ trans('entities/collaborations.duration') }}: {{ $action->start_date }} έως {{ $action->end_date }}</p>
<p>{{ trans('entities/collaborations.execEmail') }}: {{ $action->email=='' ? '-' : $action->email }}</p>


