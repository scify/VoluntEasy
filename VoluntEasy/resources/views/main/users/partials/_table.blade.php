<table id="usersTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Email</th>
        <th>Διεύθυνση</th>
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Email</th>
        <th>Διεύθυνση</th>
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th></th>
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
                        html += '<a href="' + $("body").attr('data-url') + '/users/one/' + unit.id + '">' + unit.description + '</a>';
                    else
                        html += ', <a href="' + $("body").attr('data-url') + '/users/one/' + unit.id + '">' + unit.description + '</a>';
                });

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
                    html += '<li><a href="' + $("body").attr('data-url') + '/users/edit/' + data.id + '" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit fa-2x"></i></a></li>';
                    html += '<li><a href="' + $("body").attr('data-url') + '/users/delete/' + data.id + '" class="delete" data-id="' + data.id + '" data-toggle="tooltip"';
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
            "zeroRecords": "Δεν υπάρχουν χρήστες",
            "info": "Σελίδα _PAGE_ από _PAGES_",
            "infoEmpty": "Δεν υπάρχουν χρήστες",
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
