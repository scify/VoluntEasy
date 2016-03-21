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
    var table = $('#availableVolunteersTable').dataTable({
        "pageLength": 5,
        "bFilter": false,
        "bLengthChange": false,
        "ajax": $("body").attr('data-url') + '/api/volunteers/status/available',
        "columns": [
            {data: "id"},
            {
                //concat first name with last name
                data: null, render: function (data, type, row) {
                html = '<a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '">' + data.name + ' ' + data.last_name + '</a>';
                html += '<br/><small><a href="mailto:' + data.email + '">' + data.email + '</a></small>'
                return html;
            }
            },
            {
                //show the available units
                data: null, render: function (data, type, row) {
                var status = '';
                var count = 0;

                $.each(data.units, function (index, unit) {
                    if (unit.status == 'Available') {
                        if (count == 0)
                            status += '<a href="' + $("body").attr('data-url') + '/units/one/' + unit.id + '">' + unit.description + '</a>';
                        else
                            status += ', <a href="' + $("body").attr('data-url') + '/units/one/' + unit.id + '">' + unit.description + '</a>';

                        count++;
                    }
                });
                return status;
            }
            }
        ],
        //custom text
        "language": {
            "lengthMenu": Lang.get('js-components.lengthMenu'),
            "zeroRecords": Lang.get('js-components.zeroVolunteers'),
            "info": Lang.get('js-components.info'),
            "infoEmpty": Lang.get('js-components.zeroVolunteers'),
            "paginate": {
                "first": Lang.get('js-components.first'),
                "last": Lang.get('js-components.last'),
                "next": ">",
                "previous": "<"
            }
        }
    });
</script>
@append
