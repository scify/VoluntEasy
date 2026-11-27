<table id="usersTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/users.id') }}</th>
        <th>{{ trans('entities/users.name') }}</th>
        <th>{{ trans('entities/users.information') }}</th>
        <th>{{ trans('entities/users.roles') }}</th>
        <th>{{ trans('entities/users.actions') }}</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>{{ trans('entities/users.id') }}</th>
        <th>{{ trans('entities/users.name') }}</th>
        <th>{{ trans('entities/users.information') }}</th>
        <th>{{ trans('entities/users.roles') }}</th>
        <th>{{ trans('entities/users.actions') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var url = VE.url;

        function links(items, path) {
            return (items || []).map(function (item) {
                return '<a href="' + url(path + item.id) + '">' + VE.esc(item.description) + '</a>';
            }).join(', ');
        }

        window.table = VE.table('#usersTable', {
            url: '/api/users',
            order: [[0, 'asc']],
            columns: [
                {data: 'id'},
                {
                    // user name with link
                    data: null, render: function (data) {
                        var name = data.name + (data.last_name != null ? ' ' + data.last_name : '');
                        return '<a href="' + url('/users/one/' + data.id) + '">' + VE.esc(name) + '</a>';
                    }
                },
                {
                    // email, address and phone
                    data: null, render: function (data) {
                        var html = '';
                        if (data.email)
                            html += '<i class="fa fa-envelope"></i> ' + VE.esc(data.email);
                        if ((data.email && data.addr) || (data.email && data.tel))
                            html += '<br/>';
                        if (data.addr)
                            html += '<i class="fa fa-map-marker"></i> ' + VE.esc(data.addr);
                        if (data.addr && data.tel)
                            html += '<br/>';
                        if (data.tel)
                            html += '<i class="fa fa-phone"></i> ' + VE.esc(data.tel);
                        return html;
                    }
                },
                {
                    // roles with their units/actions
                    data: null, render: function (data) {
                        return (data.roles || []).map(function (role) {
                            if (role.name == 'admin')
                                return VE.esc(Lang.get('js-components.admin')) + '<br/>';
                            var html = '';
                            if (role.name == 'unit_manager')
                                html += VE.esc(Lang.get('js-components.unitManager')) + ': ' + links(data.units, '/units/one/');
                            if (role.name == 'action_manager')
                                html += VE.esc(Lang.get('js-components.actionManager')) + ': ' + links(data.actions, '/actions/one/');
                            return html + '<br/>';
                        }).join('');
                    }
                },
                {
                    // edit/delete buttons for the permitted users
                    data: null, orderable: false, render: function (data) {
                        if (!data.permitted) return '';
                        var html = '<ul class="list-inline">' +
                            '<li><a href="' + url('/users/edit/' + data.id) + '" class="btn btn-success" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.edit')) + '"><i class="fa fa-edit"></i></a></li>';
                        if (!data.isAdmin) {
                            html += '<li><button type="button" class="btn btn-danger" data-delete-user="' + data.id + '" data-toggle="tooltip" ' +
                                'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.delete')) + '"><i class="fa fa-trash"></i></button></li>';
                        }
                        return html + '</ul>';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroUsers'),
            buttons: ['print', 'csv']
        });

        VE.searchForm('#searchForm', window.table);

        VE.on(document, 'click', '[data-delete-user]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteUser'))) return;
            VE.http.post('/users/delete/' + el.getAttribute('data-delete-user'))
                .then(function () { location.reload(); })
                .catch(VE.fail);
        });
    });
</script>
@append
