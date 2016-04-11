<p><strong>{{ trans('entities/volunteers.knowsWord') }}:</strong> {{ $volunteer->extras!=null && $volunteer->extras->knows_word ? trans('default.yes') : trans('default.no') }}</strong></p>

<p><strong>{{ trans('entities/volunteers.knowsExcel') }}:</strong> {{ $volunteer->extras!=null && $volunteer->extras->knows_excel ? trans('default.yes') : trans('default.no') }}</p>

<p><strong>{{ trans('entities/volunteers.knowsPowerpoint') }}:</strong> {{ $volunteer->extras!=null && $volunteer->extras->knows_powerpoint ? trans('default.yes') : trans('default.no') }}</p>
