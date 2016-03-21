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


    var table = $('#volunteersTable').dataTable({
        "bFilter": false,
        "ajax": $("body").attr('data-url') + '/api/volunteers',
        "columns": [
            {data: "id"},
            {
                //concat first name with last name
                data: null, render: function (data, type, row) {
                return '<a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '">' + data.name + ' ' + data.last_name + '</a>';
            }
            },
            {
                //make email address clickable
                data: null, render: function (data, type, row) {
                return '<a href="mailto:' + data.email + '">' + data.email + '</a>';
            }
            },
            {
                // display unit statuses
                data: null, render: function (data, type, row) {
                var status = '';

                if (data.blacklisted == 1)
                    status += '<div class="status blacklisted">'+Lang.get('js-components.blacklisted')+'</div>';
                else if (data.not_available == 1)
                    status += '<div class="status notavailable">'+Lang.choice('js-components.notAvailable', 1)+'</div>';
                else {
                    $.each(data.units, function (index, unit) {
                        if (unit.status == 'Pending')
                            status += '<div class="status pending" data-toggle="tooltip" data-placement="bottom" title="' + Lang.get('js-components.volunteerPendingUnit') + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Available')
                            status += '<div class="status available" data-toggle="tooltip" data-placement="bottom" title="' + Lang.choice('js-components.volunteerAvailableUnit', 1) + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Active')
                            status += '<div class="status active" data-toggle="tooltip" data-placement="bottom" title="' + Lang.choice('js-components.volunteerActiveUnit', 1) + unit.description + '">' + unit.description + '</div>';
                    });
                }
                return status;
            }
            },
            {
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                var html = '';
                html = '<ul class="list-inline">';
                html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '" class=" btn btn-primary" data-toggle="tooltip"';
                html += 'data-placement="bottom" title="' + Lang.get('js-components.viewProfile') + '"><i class="fa fa-eye"></i></a></li>';


                if (data.permitted) {
                    html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/edit/' + data.id + '" class=" btn btn-success" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="' + Lang.get('js-components.edit') + '"><i class="fa fa-edit"></i></a></li>';
                    html += '<li><button class=" btn btn-danger" onclick="deleteVolunteer(' + data.id + ')" data-id="' + data.id + '" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="' + Lang.get('js-components.delete') + '"><i class="fa fa-trash"></i></a>';
                    html += '</li>';

                    //if the volunteer has not been assigned to root unit, display appropriate button
                    if (data.assignToRoot && data.blacklisted != 1 && data.not_available != 1) {
                        html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/addToRootUnit/' + data.id + '" data-toggle="tooltip"';
                        html += 'class=" btn btn-info" data-placement="bottom" title="' + Lang.get('js-components.assignToMyUnit') + '"><i class="fa fa-home"></i></a></li>';
                    }
                }

                html += '</ul>';

                return html;
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
        },
        //disable ordering at the last column (edit, delete buttons)
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [4]}
        ],
        "aaSorting": [],
        dom: 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": $("body").attr('data-url') + "/assets/plugins/data-tables/extras/tabletools/swf/copy_csv_xls_pdf.swf",
           "aButtons": [
                           {
                               "sExtends": "copy",
                               "sButtonText": Lang.get('js-components.copy')
                           },
                           {
                               "sExtends": "print",
                               "sButtonText": Lang.get('js-components.print')
                           },
                           {
                               "sExtends": "csv",
                               "sButtonText": Lang.get('js-components.csv')
                           }
                       ]
        }
    });


    function deleteVolunteer(id) {
        if (confirm(Lang.get('js-components.deleteVolunteer')) == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    location.reload();
                }
            });
        }
    }

</script>
@append
