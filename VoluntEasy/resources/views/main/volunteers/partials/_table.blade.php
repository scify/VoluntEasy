<table id="volunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.email') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
        <th>{{ trans('entities/volunteers.activities') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
          <th>{{ trans('entities/volunteers.id') }}</th>
                <th>{{ trans('entities/volunteers.name') }}</th>
                <th>{{ trans('entities/volunteers.email') }}</th>
                <th>{{ trans('entities/units.units') }}</th>
                <th>{{ trans('entities/volunteers.activities') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var url = VE.url;
        var unitStatus = {
            Pending: ['pending', function (unit) { return Lang.get('js-components.volunteerPendingUnit') + unit.description; }],
            Available: ['available', function (unit) { return Lang.choice('js-components.volunteerAvailableUnit', 1) + unit.description; }],
            Active: ['active', function (unit) { return Lang.choice('js-components.volunteerActiveUnit', 1) + unit.description; }]
        };

        function button(href, cls, icon, title) {
            return '<li><a href="' + href + '" class="btn ' + cls + '" data-toggle="tooltip" data-placement="bottom" title="' +
                VE.esc(title) + '"><i class="fa ' + icon + '"></i></a></li>';
        }

        window.table = VE.table('#volunteersTable', {
            url: '/api/volunteers',
            columns: [
                {data: 'id'},
                {
                    data: null, render: function (data) {
                        return '<a href="' + url('/volunteers/one/' + data.id) + '">' + VE.esc(data.name + ' ' + data.last_name) + '</a>';
                    }
                },
                {
                    data: null, render: function (data) {
                        return '<a href="mailto:' + VE.esc(data.email) + '">' + VE.esc(data.email) + '</a>';
                    }
                },
                {
                    // the status of the volunteer in each unit
                    data: null, render: function (data) {
                        if (data.blacklisted == 1) return '<div class="status blacklisted">' + VE.esc(Lang.get('js-components.blacklisted')) + '</div>';
                        if (data.not_available == 1) return '<div class="status notavailable">' + VE.esc(Lang.choice('js-components.notAvailable', 1)) + '</div>';
                        return (data.units || []).map(function (unit) {
                            var status = unitStatus[unit.status];
                            if (!status) return '';
                            return '<div class="status ' + status[0] + '" data-toggle="tooltip" data-placement="bottom" title="' +
                                VE.esc(status[1](unit)) + '">' + VE.esc(unit.description) + '</div>';
                        }).join('');
                    }
                },
                {
                    // view, edit, delete and "assign to my unit" for the permitted users
                    data: null, orderable: false, render: function (data) {
                        var html = '<ul class="list-inline">' +
                            button(url('/volunteers/one/' + data.id), 'btn-primary', 'fa-eye', Lang.get('js-components.viewProfile'));
                        if (data.permitted) {
                            html += button(url('/volunteers/edit/' + data.id), 'btn-success', 'fa-edit', Lang.get('js-components.edit'));
                            html += '<li><button type="button" class="btn btn-danger" data-delete-volunteer="' + data.id + '" data-toggle="tooltip" ' +
                                'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.delete')) + '"><i class="fa fa-trash"></i></button></li>';
                            if (data.assignToRoot && data.blacklisted != 1 && data.not_available != 1) {
                                html += '<li><button type="button" class="btn btn-info" data-add-to-root="' + data.id + '" data-toggle="tooltip" ' +
                                    'data-placement="bottom" title="' + VE.esc(Lang.get('js-components.assignToMyUnit')) + '"><i class="fa fa-home"></i></button></li>';
                            }
                        }
                        return html + '</ul>';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroVolunteers'),
            buttons: ['print', 'csv']
        });

        VE.searchForm('#searchForm', window.table);

        VE.on(document, 'click', '[data-delete-volunteer]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteVolunteer'))) return;
            VE.http.post('/volunteers/delete/' + el.getAttribute('data-delete-volunteer'))
                .then(function () { location.reload(); })
                .catch(VE.fail);
        });

        VE.on(document, 'click', '[data-add-to-root]', function (event, el) {
            var id = el.getAttribute('data-add-to-root');
            VE.http.post('/volunteers/addToRootUnit/' + id)
                .then(function () { location.href = url('/volunteers/one/' + id); })
                .catch(VE.fail);
        });
    });
</script>
@append
