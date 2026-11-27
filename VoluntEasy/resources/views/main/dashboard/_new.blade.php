<table id="newVolunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.activities') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.activities') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var table = VE.table('#newVolunteersTable', {
            lengthChange: false,
            url: '/api/volunteers/status/new',
            pageLength: 5,
            order: [[0, 'asc']],
            columns: [
                {data: 'id'},
            {
                // name and email
                data: null, render: function (data) {
                    return '<a href="' + VE.url('/volunteers/one/' + data.id) + '">' + VE.esc(data.name + ' ' + data.last_name) + '</a>' +
                        '<br/><small><a href="mailto:' + VE.esc(data.email) + '">' + VE.esc(data.email) + '</a></small>';
                }
            },
                {
                    // edit, delete and "assign to my unit" for the permitted users
                    data: null, orderable: false, render: function (data) {
                        if (!data.permitted) return '';
                        var html = '<ul class="list-inline">' +
                            '<li><a href="' + VE.url('/volunteers/edit/' + data.id) + '" class="btn btn-success" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="{{ trans('default.edit') }}"><i class="fa fa-edit"></i></a></li>' +
                            '<li><button type="button" class="btn btn-danger" data-delete-new-volunteer="' + data.id + '" data-toggle="tooltip" ' +
                            'data-placement="bottom" title="{{ trans('default.delete') }}"><i class="fa fa-trash"></i></button></li>';
                        if (data.assignToRoot) {
                            html += '<li><button type="button" class="btn btn-info" data-add-new-to-root="' + data.id + '" data-toggle="tooltip" ' +
                                'data-placement="bottom" title="{{ trans('entities/volunteers.assignToMyUnit') }}"><i class="fa fa-home"></i></button></li>';
                        }
                        return html + '</ul>';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroVolunteers')
        });
        // no page length menu in the dashboard widgets

        // delete the volunteer and go to the volunteer list
        VE.on(document, 'click', '[data-delete-new-volunteer]', function (event, el) {
            if (!VE.confirm(Lang.get('js-components.deleteVolunteer'))) return;
            VE.http.post('/volunteers/delete/' + el.getAttribute('data-delete-new-volunteer'))
                .then(function () { window.location = VE.url('/volunteers'); })
                .catch(VE.fail);
        });

        VE.on(document, 'click', '[data-add-new-to-root]', function (event, el) {
            var id = el.getAttribute('data-add-new-to-root');
            VE.http.post('/volunteers/addToRootUnit/' + id)
                .then(function () { window.location = VE.url('/volunteers/one/' + id); })
                .catch(VE.fail);
        });
    });
</script>
@append
