<table id="collaborationsTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Όνομα</th>
        <th>Περιγραφή</th>
        <th>Τύπος</th>
        <th>Ημ. Έναρξης</th>
        <th>Ημ. Λήξης</th>
        <th>Ενέργειες</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>Όνομα</th>
        <th>Περιγραφή</th>
        <th>Τύπος</th>
        <th>Ημ. Έναρξης</th>
        <th>Ημ. Λήξης</th>
        <th>Ενέργειες</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#collaborationsTable').dataTable({
        "bFilter": false,
        "order": [[4, "desc"]],
        "ajax": $("body").attr('data-url') + '/api/collaborations',
        "columns": [
            {
                //show action name with link
                data: null, render: function (data, type, row) {
                var html = '';
                html += '<a href="' + $("body").attr('data-url') + '/collaborations/one/' + data.id + '">' + data.name + '</a>';
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
                //show only xx first characters of comments
                data: null, render: function (data, type, row) {
                    return data.type.description;
            }
            },
            {data: "start_date"},
            {data: "end_date"},
            {
                //show the edit/delete buttons
                data: null, render: function (data, type, row) {
                var html = '';

                html = '<ul class="list-inline">';
                html += '<li><a href="' + $("body").attr('data-url') + '/collaborations/edit/' + data.id + '"  class="btn btn-success" data-toggle="tooltip"';
                html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit"></i></a></li>';
                html += '<li><btn class="btn btn-danger" onclick="deleteCollaboration(' + data.id + ');" data-id="' + data.id + '" data-toggle="tooltip"';
                html += 'data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash"></i></btn>';
                html += '</li></ul>';


                return html;
            }
            }
        ],
        //custom text
        "language": {
            "lengthMenu": "_MENU_ γραμμές ανά σελίδα",
            "zeroRecords": "Δεν υπάρχουν συνεργαζόμενοι φορείς",
            "info": "Σελίδα _PAGE_ από _PAGES_",
            "infoEmpty": "Δεν υπάρχουν συνεργαζόμενοι φορείς",
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
            {'bSortable': false, 'aTargets': [5]}
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
                }
            ]
        }
    });


    function deleteCollaboration(id) {
        if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το συνεργαζόμενου φορέα;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/collaborations/delete/' + id,
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
