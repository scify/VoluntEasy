<table id="usersTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/users.id') }}</th>
        <th>{{ trans('entities/users.name') }}</th>
        <th>{{ trans('entities/users.email') }}</th>
        <th>{{ trans('entities/users.address') }}</th>
        <th>{{ trans('entities/users.phone') }}</th>
        <th>{{ trans('entities/users.units') }}</th>
        <th>{{ trans('entities/users.actions') }}</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>{{ trans('entities/users.id') }}</th>
        <th>{{ trans('entities/users.name') }}</th>
        <th>{{ trans('entities/users.email') }}</th>
        <th>{{ trans('entities/users.address') }}</th>
        <th>{{ trans('entities/users.phone') }}</th>
        <th>{{ trans('entities/users.units') }}</th>
        <th>{{ trans('entities/users.actions') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#usersTable').dataTable({
        "bFilter": false,
        "ajax": $("body").attr('data-url') + '/api/users',
        "columns": [
            {data: "id"},
            {
                //show user name with link
                data: null, render: function (data, type, row) {
                var html = '';
                html += '<a href="' + $("body").attr('data-url') + '/users/one/' + data.id + '">' + data.name + '</a>';
                return html;
            }
            },
            {data: "email"},
            {data: "addr"},
            {data: "tel"},
            {
                //show user units
                data: null, render: function (data, type, row) {
                var html = '';

                $.each(data.units, function (key, unit) {
                    if (key == 0)
                        html += '<a href="' + $("body").attr('data-url') + '/units/one/' + unit.id + '">' + unit.description + '</a>';
                    else
                        html += ', <a href="' + $("body").attr('data-url') + '/units/one/' + unit.id + '">' + unit.description + '</a>';
                });

                return html;
            }
            },
            {
                //if the user is permitted to edit/delete the users,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                var html = '';

                if (data.permitted) {
                    html = '<ul class="list-inline">';
                    html += '<li><a href="' + $("body").attr('data-url') + '/users/edit/' + data.id + '" class="btn btn-success" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="' + Lang.get('js-components.edit') + '"><i class="fa fa-edit"></i></a></li>';
                    if (!data.isAdmin) {
                        html += '<li><button class="btn btn-danger" onclick="deleteUser(' + data.id + ')" data-id="' + data.id + '" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="' + Lang.get('js-components.delete') + '"><i class="fa fa-trash"></i></button>';
                    }
                    html += '</li></ul>';
                }

                return html;
            }
            }
        ],
        //custom text
        "language": {
            "lengthMenu": Lang.get('js-components.lengthMenu'),
            "zeroRecords": Lang.get('js-components.zeroUsers'),
            "info": Lang.get('js-components.info'),
            "infoEmpty": Lang.get('js-components.zeroUsers'),
            "paginate": {
                "first": Lang.get('js-components.first'),
                "last": Lang.get('js-components.last'),
                "next": ">",
                "previous": "<"
            }
        },
        //disable ordering at the last column (edit, delete buttons)
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [6]}
        ],
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


    function deleteUser(id) {
        if (confirm(Lang.get('js-components.deleteUser')) == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/users/delete/' + id,
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
