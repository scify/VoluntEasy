<table id="actionsTable" class="display table table-striped data-table" cellspacing="0" width="100%" data-unit-id="{{ $unit->id }}">
    <thead>
    <tr>
        <th>{{ trans('entities/actions.name') }}</th>
        <th>{{ trans('entities/actions.comments') }}</th>
        <th>{{ trans('entities/actions.startDate') }}</th>
        <th>{{ trans('entities/actions.endDate') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/actions.name') }}</th>
        <th>{{ trans('entities/actions.comments') }}</th>
        <th>{{ trans('entities/actions.startDate') }}</th>
        <th>{{ trans('entities/actions.endDate') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var tableEl = document.getElementById('actionsTable');

        VE.table(tableEl, {
            url: '/api/units/' + tableEl.getAttribute('data-unit-id') + '/actions',
            order: [[3, 'desc']],
            columns: [
                {
                    // action name with link
                    data: null, render: function (data) {
                        return '<a href="' + VE.url('/actions/one/' + data.id) + '">' + VE.esc(data.description) + '</a>';
                    }
                },
                {data: 'comments'},
                {data: 'start_date'},
                {data: 'end_date'}
            ],
            language: VE.tableLanguage('js-components.zeroActions'),
            buttons: ['print', 'csv']
        });
    });
</script>
@append
