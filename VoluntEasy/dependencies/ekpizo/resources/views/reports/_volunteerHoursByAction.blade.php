<div class="pull-right" id="actionsdDropDown"></div>
<table id="hoursByAction" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Όνομα</th>
        <th>Ώρες</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>ID</th>
        <th>Όνομα</th>
        <th>Ώρες</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>

    var volunteersByAction;

    $.ajax({
        url: $("body").attr('data-url') + "/reports/volunteerHoursByAction",
        method: 'GET',
        success: function (result) {

            console.log(result);

            volunteersByAction = result;
            //First we need to initialize the dropdown from where the user can filter the report by year
            var actionsdDropDown = '<select class="form-control">';

            //Add the years options and set the current year as selected
            $.each(result, function (key, value) {
                actionsdDropDown += '<option value=' + value.id + ' selected>' + value.description + '</option>';
            });

            $("#actionsdDropDown").append(actionsdDropDown);

            initActionsTable(6);
        }
    });

    function initActionsTable(actionId) {

        var dataSet = [];

        $.each(volunteersByAction, function (key, value) {
            if (value.id == actionId) {

                $.each(value.volunteers, function (i, volunteer) {
                    dataSet.push([volunteer.id, volunteer.name, volunteer.hours]);
                });

            }
        });

        var table = $('#hoursByAction').dataTable({
            "pageLength": 5,
            "bFilter": false,
            "bLengthChange": false,
            data: dataSet,
            columns: [
                { title: "Id" },
                { title: "Όνομα" },
                { title: "Ώρες" }
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
            }
        });
    }
</script>
@append
