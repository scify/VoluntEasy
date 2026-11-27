<table id="actionsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/actions.name')  }}</th>
        <th>{{ trans('entities/actions.description')  }}</th>
        <th>{{ trans('entities/units.unit')  }}</th>
        <th>{{ trans('entities/actions.startDate')  }}</th>
        <th>{{ trans('entities/actions.endDate')  }}</th>
        <th>{{ trans('entities/actions.tableActions')  }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/actions.name')  }}</th>
        <th>{{ trans('entities/actions.description')  }}</th>
        <th>{{ trans('entities/units.unit')  }}</th>
        <th>{{ trans('entities/actions.startDate')  }}</th>
        <th>{{ trans('entities/actions.endDate')  }}</th>
        <th>{{ trans('entities/actions.tableActions')  }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var url = VE.url;

        window.table = VE.table('#actionsTable', {
            url: '/api/actions',
            order: [[4, 'desc']],
            columns: [
                {
                    // the action name with a link
                    data: null, render: function (data) {
                        return '<a href="' + url('/actions/one/' + data.id) + '">' + VE.esc(data.description) + '</a>';
                    }
                },
                {
                    // only the first 50 characters of the comments
                    data: null, render: function (data) {
                        var comments = data.comments || '';
                        return VE.esc(comments.length > 50 ? comments.substring(0, 50) + '...' : comments);
                    }
                },
                {data: 'unit.description'},
                {data: 'start_date'},
                {data: 'end_date'},
                {
                    // edit and delete buttons for the permitted users
                    data: null, orderable: false, render: function (data) {
                        if (!data.permitted) return '';
                        return '<ul class="list-inline">' +
                            '<li><a href="' + url('/actions/edit/' + data.id) + '" class="btn btn-success" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.edit')) + '"><i class="fa fa-edit"></i></a></li>' +
                            '<li><button type="button" class="btn btn-danger" data-delete-action="' + data.id + '" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.delete')) + '"><i class="fa fa-trash"></i></button></li>' +
                            '</ul>';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroActions'),
            buttons: ['copy', 'print', 'csv']
        });

        VE.searchForm('#searchForm', window.table);

        VE.on(document, 'click', '[data-delete-action]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteAction'))) return;
            VE.http.post('/actions/delete/' + el.getAttribute('data-delete-action'))
                .then(function () { location.reload(); })
                .catch(VE.fail);
        });
    });
</script>
@append
