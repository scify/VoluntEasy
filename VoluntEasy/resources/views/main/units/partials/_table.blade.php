<table id="unitsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/units.name') }}</th>
        <th>{{ trans('entities/units.comments') }}</th>
        <th>{{ trans('entities/units.actions') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/units.name') }}</th>
        <th>{{ trans('entities/units.comments') }}</th>
        <th>{{ trans('entities/units.actions') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#unitsTable').dataTable({
        "bFilter": false,
        "ajax": $("body").attr('data-url') + '/api/units',
        "columns": [
            {
                //show unit name with link
                data: null, render: function (data, type, row) {
                var html = '';
                html += '<a href="' + $("body").attr('data-url') + '/units/one/' + data.id + '">' + data.description + '</a>';
                if (data.parent != null)
                    html += '<br/><small>' + Lang.get('js-components.belongsTo') + ' ' + data.parent.description + '</small>';

                return html;
            }
            },
            {
                //show only xx first characters of comments
                data: null, render: function (data, type, row) {
                if (data.comments.length > 50)
                    return data.comments.substring(0, 50) + "...";
                else
                    return data.comments;
            }
            },
            {
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                var html = '';

                if (data.permitted) {
                    html = '<ul class="list-inline">';
                    html += '<li><a href="' + $("body").attr('data-url') + '/units/edit/' + data.id + '" class="btn btn-success" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="' + Lang.get('js-components.edit') + '"><i class="fa fa-edit"></i></a></li>';

                    if (data.parent != null) {
                        html += '<li><btn class="btn btn-danger" onclick="deleteUnit(' + data.id + ');" data-id="' + data.id + '" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="' + Lang.get('js-components.delete') + '"><i class="fa fa-trash"></i></btn>';
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
            "zeroRecords": Lang.get('js-components.zeroUnits'),
            "info": Lang.get('js-components.info'),
            "infoEmpty": Lang.get('js-components.zeroUnits'),
            "paginate": {
                "first": Lang.get('js-components.first'),
                "last": Lang.get('js-components.last'),
                "next": ">",
                "previous": "<"
            }
        },
        //disable ordering at the last column (edit, delete buttons)
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [2]}
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


    function deleteUnit(id) {
        if (confirm(Lang.get('js-components.deleteUnit')) == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/units/delete/' + id,
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
