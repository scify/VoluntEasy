<table id="volunteersTable" class="display table table-striped data-table" cellspacing="0" width="100%"
       data-unit-id="{{ $unit->id }}">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.email') }}</th>
        <th>{{ trans('entities/volunteers.address') }}</th>
        <th>{{ trans('entities/volunteers.phone') }}</th>
        <th>{{ trans('entities/volunteers.status') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.email') }}</th>
        <th>{{ trans('entities/volunteers.address') }}</th>
        <th>{{ trans('entities/volunteers.phone') }}</th>
        <th>{{ trans('entities/volunteers.status') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var tableEl = document.getElementById('volunteersTable');
        var statuses = {
            Pending: ['pending', 'js-components.pending'],
            Available: ['available', 'js-components.available'],
            Active: ['active', 'js-components.active']
        };

        function filled(value) {
            return value != null && value !== '';
        }

        VE.table(tableEl, {
            url: '/api/units/' + tableEl.getAttribute('data-unit-id') + '/volunteers',
            order: [[0, 'asc']],
            columns: [
                {data: 'id'},
                {
                    // first name with last name
                    data: null, render: function (data) {
                        return '<a href="' + VE.url('/volunteers/one/' + data.id) + '">' + VE.esc(data.name + ' ' + data.last_name) + '</a>';
                    }
                },
                {
                    // clickable email address
                    data: null, render: function (data) {
                        return '<a href="mailto:' + VE.esc(data.email) + '">' + VE.esc(data.email) + '</a>';
                    }
                },
                {
                    // address with city, post box and country
                    data: null, render: function (data) {
                        var address = '';
                        if (filled(data.address)) address += data.address;
                        if (filled(data.city)) address += ', ' + data.city;
                        if (filled(data.post_box)) address += ', ' + data.post_box;
                        if (filled(data.country)) address += ', ' + data.country;
                        return VE.esc(address);
                    }
                },
                {
                    // all the phones
                    data: null, render: function (data) {
                        var phones = [];
                        if (filled(data.cell_tel)) phones.push(VE.esc(data.cell_tel));
                        if (filled(data.home_tel)) phones.push(VE.esc(data.home_tel));
                        if (filled(data.work_tel)) phones.push(VE.esc(data.work_tel));
                        return phones.join('<br/>');
                    }
                },
                {
                    // status of the volunteer in the unit
                    data: null, render: function (data) {
                        var status = data.units && data.units[0] ? statuses[data.units[0].status] : null;
                        return status ? '<div class="status ' + status[0] + '">' + VE.esc(Lang.get(status[1])) + '</div>' : '';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroVolunteers'),
            buttons: ['print', 'csv']
        });
    });
</script>
@append
