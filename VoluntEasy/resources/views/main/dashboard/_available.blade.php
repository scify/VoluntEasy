<table id="availableVolunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var table = VE.table('#availableVolunteersTable', {
            lengthChange: false,
            url: '/api/volunteers/status/available',
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
                    // the units where the volunteer is available
                    data: null, render: function (data) {
                        return (data.units || []).filter(function (unit) { return unit.status == 'Available'; }).map(function (unit) {
                            return '<a href="' + VE.url('/units/one/' + unit.id) + '">' + VE.esc(unit.description) + '</a>';
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
