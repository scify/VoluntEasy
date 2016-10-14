<table id="volunteersByActionTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>@lang('default.action')</th>
        <th>@lang('default.duration')</th>
        <th>@lang('default.totalRequiredVolunteers')</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>@lang('default.action')</th>
        <th>@lang('default.duration')</th>
        <th>@lang('default.totalRequiredVolunteers')</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>

    var table = $('#volunteersByActionTable').dataTable({
        "bFilter": false,
        // "order": [[ 2, "desc" ]],
        "ajax": $("body").attr('data-url') + '/reports/volunteersByAction',
        "columns": [
            {
                //show action name with link
                data: null, render: function (data, type, row) {
                var html = '';
                html += '<a href="' + $("body").attr('data-url') + '/actions/one/' + data.id + '">' + data.description + '</a>';
                return html;
            }
            },
            {
                //show only xx first characters of comments
                data: null, render: function (data, type, row) {
                var html = '';

                if (data.expired)
                    html = '<span class="inactive">' + data.start_date + ' - ' + data.end_date + '</span>';
                else
                    html = data.start_date + ' - ' + data.end_date;


                return html;
            }
            },
            {
                //show only xx first characters of comments
                data: null, render: function (data, type, row) {
                var html = data.volunteer_count + ' / ';

                if (data.volunteer_sum == null || data.volunteer_sum == '')
                    html += '-';
                else
                    html += data.volunteer_sum;

                return html;
            }
            }
        ],
        //custom text
        "language": {
            "lengthMenu": "_MENU_ γραμμές ανά σελίδα",
            "zeroRecords": "Δεν υπάρχουν δράσεις",
            "info": "Σελίδα _PAGE_ από _PAGES_",
            "infoEmpty": "Δεν υπάρχουν δράσεις",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
                "first": "Πρώτη",
                "last": "Τελευταία",
                "next": "Επόμενη",
                "previous": "Προηγούμενη"
            }
        },
        dom: 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": $("body").attr('data-url') + "/assets/plugins/data-tables/extras/tabletools/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Αντιγραφή"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Εκτύπωση"
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                }
            ]
        }
    });

</script>
@append

