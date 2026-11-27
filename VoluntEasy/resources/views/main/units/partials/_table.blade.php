<table id="unitsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/units.name') }}</th>
        <th>{{ trans('entities/units.comments') }}</th>
        <th>{{ trans('entities/units.actions') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/units.name') }}</th>
        <th>{{ trans('entities/units.comments') }}</th>
        <th>{{ trans('entities/units.actions') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var url = VE.url;

        window.table = VE.table('#unitsTable', {
            url: '/api/units',
            order: [[0, 'asc']],
            columns: [
                {
                    // unit name with link and the parent unit
                    data: null, render: function (data) {
                        var html = '<a href="' + url('/units/one/' + data.id) + '">' + VE.esc(data.description) + '</a>';
                        if (data.parent != null)
                            html += '<br/><small>' + VE.esc(Lang.get('js-components.belongsTo') + ' ' + data.parent.description) + '</small>';
                        return html;
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
                    // edit/delete buttons for the permitted users
                    data: null, orderable: false, render: function (data) {
                        if (!data.permitted) return '';
                        var html = '<ul class="list-inline">' +
                            '<li><a href="' + url('/units/edit/' + data.id) + '" class="btn btn-success" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.edit')) + '"><i class="fa fa-edit"></i></a></li>';
                        if (data.parent != null) {
                            html += '<li><button type="button" class="btn btn-danger" data-delete-unit="' + data.id + '" data-toggle="tooltip" ' +
                                'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.delete')) + '"><i class="fa fa-trash"></i></button></li>';
                        }
                        return html + '</ul>';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroUnits'),
            buttons: ['print', 'csv']
        });

        VE.searchForm('#searchForm', window.table);

        VE.on(document, 'click', '[data-delete-unit]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteUnit'))) return;
            VE.http.post('/units/delete/' + el.getAttribute('data-delete-unit'))
                .then(function () { location.reload(); })
                .catch(VE.fail);
        });
    });
</script>
@append
