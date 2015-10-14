<table id="actionsTable" class="display table table-striped data-table" cellspacing="0" width="100%" data-unit-id="{{ $unit->id }}">
    <thead>
    <tr>
        <th>Όνομα</th>
        <th>Σχόλια</th>
        <th>Ημ. Έναρξης</th>
        <th>Ημ. Λήξης</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>Όνομα</th>
        <th>Σχόλια</th>
        <th>Ημ. Έναρξης</th>
        <th>Ημ. Λήξης</th>
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
            "lengthMenu": "_MENU_ γραμμές ανά σελίδα",
            "zeroRecords": "Δεν υπάρχουν εθελοντές",
            "info": "Σελίδα _PAGE_ από _PAGES_",
            "infoEmpty": "Δεν υπάρχουν εθελοντές",
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
