<table id="usersTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Όνομα</th>
        <th>Email</th>
        <th>Διεύθυνση</th>
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th>Ενέργειες</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>ID</th>
        <th>Όνομα</th>
        <th>Email</th>
        <th>Διεύθυνση</th>
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th>Ενέργειες</th>
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
                    html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit"></i></a></li>';
                    if (!data.isAdmin) {
                        html += '<li><button class="btn btn-danger" onclick="deleteUser(' + data.id + ')" data-id="' + data.id + '" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash"></i></button>';
                    }
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


    function deleteUser(id) {
        if (confirm("Είτε σίγουροι ότι θέλετε να διαγράψετε το χρήστη;") == true) {
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
