<table id="collaborationsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/collaborations.name') }}</th>
        <th>{{ trans('entities/collaborations.description') }}</th>
        <th>{{ trans('entities/collaborations.type') }}</th>
        <th>{{ trans('entities/collaborations.startDate') }}</th>
        <th>{{ trans('entities/collaborations.endDate') }}</th>
        <th>{{ trans('entities/collaborations.actions') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/collaborations.name') }}</th>
        <th>{{ trans('entities/collaborations.description') }}</th>
        <th>{{ trans('entities/collaborations.type') }}</th>
        <th>{{ trans('entities/collaborations.startDate') }}</th>
        <th>{{ trans('entities/collaborations.endDate') }}</th>
        <th>{{ trans('entities/collaborations.actions') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var url = VE.url;

        window.table = VE.table('#collaborationsTable', {
            url: '/api/collaborations',
            order: [[4, 'desc']],
            columns: [
                {
                    // collaboration name with link
                    data: null, render: function (data) {
                        return '<a href="' + url('/collaborations/one/' + data.id) + '">' + VE.esc(data.name) + '</a>';
                    }
                },
                {
                    // only the first 50 characters of the comments
                    data: null, render: function (data) {
                        var comments = data.comments || '';
                        return VE.esc(comments.length > 50 ? comments.substring(0, 50) + '...' : comments);
                    }
                },
                {
                    data: null, render: function (data) {
                        return VE.esc(data.type ? data.type.description : '');
                    }
                },
                {data: 'start_date'},
                {data: 'end_date'},
                {
                    // edit/delete buttons
                    data: null, orderable: false, render: function (data) {
                        return '<ul class="list-inline">' +
                            '<li><a href="' + url('/collaborations/edit/' + data.id) + '" class="btn btn-success" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.edit')) + '"><i class="fa fa-edit"></i></a></li>' +
                            '<li><button type="button" class="btn btn-danger" data-delete-collaboration="' + data.id + '" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.delete')) + '"><i class="fa fa-trash"></i></button></li>' +
                            '</ul>';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroCollaborators'),
            buttons: ['print', 'csv']
        });

        VE.searchForm('#searchForm', window.table);

        VE.on(document, 'click', '[data-delete-collaboration]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteCollab'))) return;
            VE.http.post('/collaborations/delete/' + el.getAttribute('data-delete-collaboration'))
                .then(function () { location.reload(); })
                .catch(VE.fail);
        });
    });
</script>
@append
