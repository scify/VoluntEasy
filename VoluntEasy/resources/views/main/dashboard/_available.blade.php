<table id="availableVolunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Μονάδες</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Μονάδες</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#availableVolunteersTable').dataTable({
        "pageLength": 5,
        "bFilter": false,
        "bLengthChange": false,
        "ajax": $("body").attr('data-url') + '/api/volunteers/available',
        "columns": [
            {data: "id"},
            {
                //concat first name with last name
                data: null, render: function (data, type, row) {
                html = '<a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '">' + data.name + ' ' + data.last_name + '</a>';
                html += '<br/><small><a href="mailto:' + data.email + '">' + data.email + '</a></small>'
                return html;
            }
            },
            {
                //show the available units
                data: null, render: function (data, type, row) {
                var status = '';

                $.each(data.units, function (index, unit) {
                    if (index == 0)
                        status += unit.description;
                    else
                        status += ', ' + unit.description;
                });
                return status;
            }
            }
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
                "next": ">",
                "previous": "<"
            }
        }/*,
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
         }*/
    });
</script>
@append