<table id="actionsTable" class="display table table-striped data-table" cellspacing="0" width="100%" data-unit-id="{{ $unit->id }}">
    <thead>
    <tr>
        <th>{{ trans('entities/actions.name') }}</th>
        <th>{{ trans('entities/actions.comments') }}</th>
        <th>{{ trans('entities/actions.startDate') }}</th>
        <th>{{ trans('entities/actions.endDate') }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/actions.name') }}</th>
        <th>{{ trans('entities/actions.comments') }}</th>
        <th>{{ trans('entities/actions.startDate') }}</th>
        <th>{{ trans('entities/actions.endDate') }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#actionsTable').dataTable({
        "bFilter": false,
        "order": [[ 3, "desc" ]],
        "ajax": $("body").attr('data-url') + '/api/units/' + $('#volunteersTable').attr('data-unit-id') + '/actions',
        "columns": [
            {
                //concat first name with last name
                data: null, render: function (data, type, row) {
                return '<a href="' + $("body").attr('data-url') + '/actions/one/' + data.id + '">' + data.description+ '</a>';
            }
            },
            {data: "comments"},
            {data: "start_date"},
            {data: "end_date"},


        ],
        //custom text
        "language": {
            "lengthMenu": Lang.get('js-components.lengthMenu'),
            "zeroRecords": Lang.get('js-components.zeroActions'),
            "info": Lang.get('js-components.info'),
            "infoEmpty": Lang.get('js-components.zeroActions'),
            "paginate": {
                "first": Lang.get('js-components.first'),
                "last": Lang.get('js-components.last'),
                "next": ">",
                "previous": "<"
            }
        },
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

</script>
@append
