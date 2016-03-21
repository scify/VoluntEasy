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
    var table = $('#newVolunteersTable').dataTable({
        "pageLength": 5,
        "bFilter": false,
        "bLengthChange": false,
        "ajax": $("body").attr('data-url') + '/api/volunteers/status/new',
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
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                    var html = '';

                    if (data.permitted) {
                        html = '<ul class="list-inline">';
                        html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/edit/' + data.id + '" class=" btn btn-success" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="{{ trans('default.edit') }}"><i class="fa fa-edit"></i></a></li>';
                        html += '<li><button class=" btn btn-danger" onclick="deleteVolunteer(' + data.id + ')" data-id="' + data.id + '" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="{{ trans('default.delete') }}"><i class="fa fa-trash"></i></a>';
                        html += '</li>';

                        //if the volunteer has not been assigned to root unit, display appropriate button
                        if (data.assignToRoot) {
                            html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/addToRootUnit/' + data.id + '" data-toggle="tooltip"';
                            html += 'class=" btn btn-info" data-placement="bottom" title="{{ trans('entities/volunteers.assignToMyUnit') }}"><i class="fa fa-home"></i></a></li>';
                        }

                        html += '</ul>';
                    }
                    return html;
                }
            }
        ],
        //disable ordering at the last column (edit, delete buttons)
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [2]}
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
