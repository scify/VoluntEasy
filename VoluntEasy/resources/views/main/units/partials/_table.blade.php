<table id="unitsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Σχόλια</th>
        <th></th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Σχόλια</th>
        <th></th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#unitsTable').dataTable({
        "bFilter": false,
        "ajax": $("body").attr('data-url') + '/api/units',
        "columns": [
            {data: "id"},
            {
                //show unit name with link
                data: null, render: function (data, type, row) {
                var html = '';
                html += '<a href="' + $("body").attr('data-url') + '/units/one/' + data.id + '">' + data.description + '</a>';
                if (data.parent != null)
                    html += '<br/><small>Ανήκει σε ' + data.parent.description + '</small>';

                return html;
            }
            },
            {data: "comments"},
            {
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                var html = '';

                if (data.permitted) {
                    html = '<ul class="list-inline">';
                    html += '<li><a href="' + $("body").attr('data-url') + '/units/edit/' + data.id + '" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a></li>';
                    html += '<li><a href="' + $("body").attr('data-url') + '/units/delete/' + data.id + '" class="delete" data-id="' + data.id + '" data-toggle="tooltip"';
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
            "zeroRecords": "Δεν υπάρχουν οργανωτικές μονάδες",
            "info": "Σελίδα _PAGE_ από _PAGES_",
            "infoEmpty": "Δεν υπάρχουν οργανωτικές μονάδες",
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
            {'bSortable': false, 'aTargets': [3]}
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
