<table id="volunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Όνομα</th>
        <th>Email</th>
        <!--th>Διεύθυνση</th-->
        <!--th>Τηλέφωνο</th-->
        <th>Μονάδες</th>
        <!--th>Αξιολόγηση</th-->
        <th>Ενέργειες</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>ID</th>
        <th>Όνομα</th>
        <th>Email</th>
        <!--th>Διεύθυνση</th-->
        <!--th>Τηλέφωνο</th-->
        <th>Μονάδες</th>
        <!--th>Αξιολόγηση</th-->
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
            {
                // display unit statuses
                data: null, render: function (data, type, row) {
                var status = '';

                if (data.blacklisted == 1)
                    status += '<div class="status blacklisted">Blacklisted</div>';
                else if (data.not_available == 1)
                    status += '<div class="status notavailable">Μη διαθέσιμος</div>';
                else {
                    $.each(data.units, function (index, unit) {
                        if (unit.status == 'Pending')
                            status += '<div class="status pending" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι υπό ένταξη στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Available')
                            status += '<div class="status available" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι διαθέσιμος στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Active')
                            status += '<div class="status active" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι ενεργός σε δράσεις στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                    });
                }
                return status;
            }
            },
            /*{
                //show volunteer rating
                data: null, render: function (data, type, row) {

                var ratings = '';

                if (data.rating_attr1 == 0 || data.rating_attr2 == 0 || data.rating_attr3 == 0)
                    ratings += '<em class="text-grey">Καμία αξιολόγηση</em>';
                else
                {
                    ratings += '<span id="attr1" class="attribute rating" data-score="' + data.rating_attr1 + '"></span>';
                    ratings += '<small><span> Συνέπεια</span><br/>';
                    ratings += '<span id="attr2" class="attribute rating" data-score="' + data.rating_attr2 + '"></span>';
                    ratings += '<span> Στυλ</span><br/>';
                    ratings += '<span id="attr3" class="attribute rating" data-score="' + data.rating_attr3 + '"></span>';
                    ratings += '<span> Αγάπη για γάτες</span></small>';
                }

                return ratings;
            }
            },*/
            {
                //if the user is permitted to edit/delete the volunteer,
                //then show the appropriate buttons
                data: null, render: function (data, type, row) {
                var html = '';
                html = '<ul class="list-inline">';
                html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '" class=" btn btn-primary" data-toggle="tooltip"';
                html += 'data-placement="bottom" title="Προβολή Προφίλ"><i class="fa fa-eye"></i></a></li>';


                if (data.permitted) {
                    html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/edit/' + data.id + '" class=" btn btn-success" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="Επεξεργασία"><i class="fa fa-edit"></i></a></li>';
                    html += '<li><button class=" btn btn-danger" onclick="deleteVolunteer(' + data.id + ')" data-id="' + data.id + '" data-toggle="tooltip"';
                    html += 'data-placement="bottom" title="Διαγραφή"><i class="fa fa-trash"></i></a>';
                    html += '</li>';

                    //if the volunteer has not been assigned to root unit, display appropriate button
                    if (data.assignToRoot && data.blacklisted != 1 && data.not_available != 1) {
                        html += '<li><a href="' + $("body").attr('data-url') + '/volunteers/addToRootUnit/' + data.id + '" data-toggle="tooltip"';
                        html += 'class=" btn btn-info" data-placement="bottom" title="Ανάθεση στη μονάδα μου"><i class="fa fa-home"></i></a></li>';
                    }
                }

                html += '</ul>';

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
            {'bSortable': false, 'aTargets': [4]}
        ],
        "aaSorting": [],
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
        }/*,
        "fnInitComplete": function (oSettings, json) {
            $('.attribute.rating').raty({
                starOff: '{{ asset("assets/plugins/raty/lib/images/star-off.png")}}',
                starOn: '{{ asset("assets/plugins/raty/lib/images/star-on.png")}}',
                starHalf: '{{ asset("assets/plugins/raty/lib/images/star-half.png")}}',
                readOnly: true,
                score: function () {
                    console.log('raty');
                    return $(this).attr('data-score');
                }
            });
        }*/
    });


    function deleteVolunteer(id) {
        if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε τον εθελοντή;") == true) {
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
