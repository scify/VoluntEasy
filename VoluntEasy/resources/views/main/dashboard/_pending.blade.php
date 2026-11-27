<table id="pendingVolunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
        <th>{{ trans_choice('entities/volunteers.pendingStuff', 10) }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
        <th>{{ trans_choice('entities/volunteers.pendingStuff', 10) }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        function pendingUnits(data) {
            return (data.units || []).filter(function (unit) { return unit.status == 'Pending'; });
        }

        var table = VE.table('#pendingVolunteersTable', {
            lengthChange: false,
            url: '/api/volunteers/status/pending',
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
                    // all the pending units
                    data: null, render: function (data) {
                        return pendingUnits(data).map(function (unit) { return '<p>' + VE.esc(unit.description) + '</p>'; }).join('');
                    }
                },
                {
                    // the current pending step for each unit (a unit can have no incomplete step)
                    data: null, render: function (data) {
                        return pendingUnits(data).map(function (unit) {
                            var step = (unit.steps || [])[0];
                            return '<p>' + (step ? VE.esc(step.description) : '-') + '</p>';
                        }).join('');
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroVolunteers')
        });
        // no page length menu in the dashboard widgets
    });
</script>
@append
