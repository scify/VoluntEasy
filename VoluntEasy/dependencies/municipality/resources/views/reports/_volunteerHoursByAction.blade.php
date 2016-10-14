<div class="row  bottom-margin">
    <div class="col-md-3 pull-right">
        <div id="actionsdDropDown"></div>
    </div>
</div>
<table id="hoursByAction" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>@lang('default.name')</th>
        <th>@lang('default.hours')</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>ID</th>
        <th>@lang('default.name')</th>
        <th>@lang('default.hours')</th>
    </tr>
    </tfoot>
</table>

<input type="hidden" name="name" value="@lang('default.name')">
<input type="hidden" name="hours" value="@lang('default.hours')">
<input type="hidden" name="action" value="@lang('default.action')">
<input type="hidden" name="totalHours" value="@lang('default.totalHours')">

@section('footerScripts')
<script>

    var volunteersByAction;
    var byHoursTable;
    var totalHours = 0;

    $.ajax({
        url: $("body").attr('data-url') + "/reports/volunteerHoursByAction",
        method: 'GET',
        success: function (result) {
            volunteersByAction = result;

            //First we need to initialize the dropdown from where the user can filter the report by year
            var actionsdDropDown = '<label>' + $("input[name='action']").val() + '</label><select class="form-control">';

            //Add the years options and set the current year as selected
            $.each(result, function (key, value) {
                if (key == 0)
                    actionsdDropDown += '<option value=' + value.id + ' selected>' + value.description + '</option>';
                else
                    actionsdDropDown += '<option value=' + value.id + '>' + value.description + '</option>';

            });

            $("#actionsdDropDown").append(actionsdDropDown);

            var actionId = $("#actionsdDropDown option:selected").val();
            initActionsTable(initVolunteerActionsDataset(actionId));
        }
    });

    //when the user selects a different action,
    //we must show the action's data
    $("#actionsdDropDown").change(function () {

        var actionId = $("#actionsdDropDown option:selected").val();

        byHoursTable.fnClearTable();

        byHoursTable.fnAddData(initVolunteerActionsDataset(actionId));
    });

    function initActionsTable(dataSet) {

        byHoursTable = $('#hoursByAction').dataTable({
            "pageLength": 5,
            "bFilter": false,
            "bLengthChange": false,
            data: dataSet,
            columns: [
                {title: "ID"},
                {title: $("input[name='name']").val()},
                {title: $("input[name='hours']").val()}
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
            }, "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                // Update footer
                $(api.column(2).footer()).html($("input[name='totalHours']").val() + ': ' + totalHours);
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
    }

    function initVolunteerActionsDataset(actionId) {
        var dataSet = [];

        $.each(volunteersByAction, function (key, value) {
            if (value.id == actionId) {

                $.each(value.volunteers, function (i, volunteer) {
                    dataSet.push([volunteer.id, volunteer.name, volunteer.hours]);
                });

                totalHours = value.totalHours;
            }
        });

        return dataSet;
    }
</script>
@append
