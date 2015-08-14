<table id="volunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Email</th>
        <!--th>Διεύθυνση</th-->
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th>Ενέργειες</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>#</th>
        <th>Όνομα</th>
        <th>Email</th>
        <!--th>Διεύθυνση</th-->
        <th>Τηλέφωνο</th>
        <th>Μονάδες</th>
        <th>Ενέργειες</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    var table = $('#volunteersTable').dataTable({
        "bFilter": false,
        "ajax": $("body").attr('data-url') + '/api/volunteers',
        "columns": [
            {data: "id"},
            {
                //concat first name with last name
                data: null, render: function (data, type, row) {
                return '<a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '">' + data.name + ' ' + data.last_name + '</a>';
            }
            },
            {
                //make email address clickable
                data: null, render: function (data, type, row) {
                return '<a href="mailto:' + data.email + '">' + data.email + '</a>';
            }
            },
            /*{
             //concat address with city, post box and country
             data: null, render: function (data, type, row) {
             var address = '';
             if (data.address != null && data.address != '')
             address += data.address;
             if (data.city != null && data.city != '')
             address += ', ' + data.city;
             if (data.post_box != null && data.post_box != '')
             address += ', ' + data.post_box;
             if (data.country != null && data.country != '')
             address += ', ' + data.country;

             return address;
             }
             },*/
            {
                //concat all phones
                data: null, render: function (data, type, row) {
                var phones = '';
                if (data.cell_tel != null && data.cell_tel != '')
                    phones += data.cell_tel;
                if (data.home_tel != null && data.home_tel != '')
                    phones += ', ' + data.home_tel;
                if (data.work_tel != null && data.work_tel != '')
                    phones += ', ' + data.work_tel;

                return phones;
            }
            },
            {
                // display unit statuses
                data: null, render: function (data, type, row) {
                var status = '';

                if (data.blacklisted == 1)
                    status += '<div class="status blacklisted">Μη διαθέσιμος</div>';
                else {
                    //if the volunteer has not been assigned to root unit, display appropriate button
                    /*  if (data.assignToRoot) {
                     status = '<a href="' + $("body").attr('data-url') + '/volunteers/addToRootUnit/' + data.id + '" class="btn btn-info">Ένταξη στη μονάδα μου</a>';
                     }
                     else {*/
                    $.each(data.units, function (index, unit) {
                        if (unit.status == 'Pending')
                            status += '<div class="status pending" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι υπό ένταξη στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Available')
                            status += '<div class="status available" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι διαθέσιμος στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Active')
                            status += '<div class="status active" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι ενεργός σε δράσεις στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                    });
                    // }
                }
                return status;
            }
            }, {
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                    var html = '';


                    if (data.permitted) {
                        html = '<ul class="list-inline">';
                        html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/edit/' + data.id + '" class=" btn btn-success" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit"></i></a></li>';
                        html += '<li><button class=" btn btn-danger" onclick="deleteVolunteer(' + data.id + ')" data-id="' + data.id + '" data-toggle="tooltip"';
                        html += 'data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash"></i></a>';
                        html += '</li>';

                        //if the volunteer has not been assigned to root unit, display appropriate button
                        if (data.assignToRoot && data.blacklisted!=1) {
                            html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/addToRootUnit/' + data.id + '" data-toggle="tooltip"';
                            html += 'class=" btn btn-info" data-placement="bottom" title="Ανάθεση στη μονάδα μου"><i class="fa fa-home"></i></a></li>';
                        }

                        html += '</ul>';
                    }
                    return html;
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
                },
                {
                    "sExtends": "xls"
                }
            ]
        }
    });


    function deleteVolunteer(id) {
        if (confirm("Είτε σίγουροι ότι θέλετε να διαγράψετε τον εθελοντή;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/delete/' + id,
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
