<p>{{ $action->comments }}</p>
<p>{{ trans('entities/actions.duration') }}: {{ $action->start_date }} {{ trans('default.to') }} {{ $action->end_date }}</p>
<p>{{ trans('entities/actions.execEmail') }}: {{ $action->email=='' ? '-' : $action->email }}</p>


