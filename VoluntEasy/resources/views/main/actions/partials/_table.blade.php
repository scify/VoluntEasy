<table id="actionsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>

        <th>#</th>
        <th>Περιγραφή</th>
        <th>Σχόλια</th>
        <th>Μονάδα</th>
        <th>Ημ. Έναρξης</th>
        <th>Ημ. Λήξης</th>
        <th>Ενέργειες</th>
    </tr>
    </thead>

    <tfoot>
    <tr>

        <th>#</th>
        <th>Περιγραφή</th>
        <th>Σχόλια</th>
        <th>Μονάδα</th>
        <th>Ημ. Έναρξης</th>
        <th>Ημ. Λήξης</th>
        <th>Ενέργειες</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#actionsTable').dataTable({
        "bFilter": false,
        "ajax": $("body").attr('data-url') + '/api/actions',
        "columns": [
            {data: "id"},
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
                  return data.comments.substring(0,50) + "...";
            }
            },
            {data: "unit.description"},
            {data: "start_date"},
            {data: "end_date"},
            {
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                var html = '';

                if (data.permitted) {
                    html = '<ul class="list-inline">';
                    html += '<li><a href="' + $("body").attr('data-url') + '/actions/edit/' + data.id + '" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a></li>';
                    html += '<li><a href="' + $("body").attr('data-url') + '/actions/delete/' + data.id + '" class="delete" data-id="' + data.id + '" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash fa-2x"></i></a>';
                    html += '</li></ul>';
                }

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
                    "sButtonText": "Αντιγραφή"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Εκτύπωση"
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                },
                {
                    "sExtends": "xls"
                }
            ]
        }
    });

</script>
@append

