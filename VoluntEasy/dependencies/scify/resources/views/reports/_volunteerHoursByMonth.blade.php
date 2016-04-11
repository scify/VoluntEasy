<div class="pull-right" id="actionsdDropDown"></div>
<table id="hoursByAction" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans_choice('entities/volunteers.time', 10) }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans_choice('entities/volunteers.time', 10) }}</th>
    </tr>
    </tfoot>
</table>

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
            var actionsdDropDown = '<label>' + Lang.get('js-components.action') + '</label><select class="form-control">';

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
            "language": {
                "lengthMenu": Lang.get('js-components.lengthMenu'),
                "zeroRecords": Lang.get('js-components.zeroVolunteers'),
                "info": Lang.get('js-components.info'),
                "infoEmpty": Lang.get('js-components.zeroVolunteers'),
                "paginate": {
                    "first": Lang.get('js-components.first'),
                    "last": Lang.get('js-components.last'),
                    "next": ">",
                    "previous": "<"
                }
            }, "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                // Update footer
                $(api.column(2).footer()).html(Lang.get('js-components.totalHours')+': ' + totalHours);
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
