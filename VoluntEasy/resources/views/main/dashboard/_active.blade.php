<table id="activeVolunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/actions.actions') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/actions.actions') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var table = VE.table('#activeVolunteersTable', {
            lengthChange: false,
            url: '/api/volunteers/status/active',
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
                    // the actions of the volunteer
                    data: null, render: function (data) {
                        return (data.actions || []).map(function (action) {
                            return '<a href="' + VE.url('/actions/one/' + action.id) + '">' + VE.esc(action.description) + '</a>';
                        }).join(', ');
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroVolunteers')
        });
        // no page length menu in the dashboard widgets
    });
</script>
@append
