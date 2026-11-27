<table id="volunteersTable" class="display table table-striped data-table" cellspacing="0" width="100%"
       data-unit-id="{{ $action->id }}" data-expired="{{$action->expired}}">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.email') }}</th>
        <th>{{ trans('entities/volunteers.address') }}</th>
        <th>{{ trans('entities/volunteers.phone') }}</th>
        @if(!$action->expired)
        <th>{{ trans('entities/volunteers.id') }}</th>
        @else
        <th></th>
        @endif
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/volunteers.email') }}</th>
        <th>{{ trans('entities/volunteers.address') }}</th>
        <th>{{ trans('entities/volunteers.phone') }}</th>
        @if(!$action->expired)
        <th>{{ trans('entities/volunteers.id') }}</th>
        @else
        <th></th>
        @endif
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    VE.ready(function () {
        var tableEl = document.getElementById('volunteersTable');
        var expired = tableEl.getAttribute('data-expired');
        var statuses = {
            Pending: ['pending', 'js-components.pending'],
            Available: ['available', 'js-components.available'],
            Active: ['active', 'js-components.active']
        };

        function filled(value) {
            return value !== null && value !== undefined && value !== '';
        }

        window.table = VE.table(tableEl, {
            url: '/api/actions/' + tableEl.getAttribute('data-unit-id') + '/volunteers',
            columns: [
                {data: 'id'},
                {
                    // first name and last name
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
                    // address, city, post box and country
                    data: null, render: function (data) {
                        var address = filled(data.address) ? data.address : '';
                        ['city', 'post_box', 'country'].forEach(function (key) {
                            if (filled(data[key])) address += ', ' + data[key];
                        });
                        return VE.esc(address);
                    }
                },
                {
                    // all the phones
                    data: null, render: function (data) {
                        var phones = filled(data.cell_tel) ? VE.esc(data.cell_tel) : '';
                        ['home_tel', 'work_tel'].forEach(function (key) {
                            if (filled(data[key])) phones += '<br/>' + VE.esc(data[key]);
                        });
                        return phones;
                    }
                },
                {
                    // the status of the volunteer in the unit
                    data: null, render: function (data) {
                        if (expired != 0 || !data.units || !data.units.length) return '';
                        var status = statuses[data.units[0].status];
                        return status ? '<div class="status ' + status[0] + '">' + VE.esc(Lang.choice(status[1], 1)) + '</div>' : '';
                    }
                }
            ],
            language: VE.tableLanguage('js-components.zeroVolunteers'),
            buttons: ['copy', 'print', 'csv']
        });
    });
</script>
@append
