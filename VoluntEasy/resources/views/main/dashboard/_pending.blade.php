<table id="pendingVolunteersTable" class="display table table-striped table-condensed data-table" cellspacing="0"
       width="100%">
    <input type="hidden" name="pending_statuses[]" data-text="communicationStep" value="@lang('entities/volunteers.communicationStep')">
    <input type="hidden" name="pending_statuses[]" data-text="interviewStep" value="@lang('entities/volunteers.interviewStep')">
    <input type="hidden" name="pending_statuses[]" data-text="assignmentStep" value="@lang('entities/volunteers.assignmentStep')">
    <input type="hidden" name="pending_statuses[]" data-text="pendingStep" value="@lang('entities/volunteers.pendingStep')">
    <thead>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
        <th>{{ trans_choice('entities/volunteers.pendingStuff', 10) }}</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>{{ trans('entities/volunteers.id') }}</th>
        <th>{{ trans('entities/volunteers.name') }}</th>
        <th>{{ trans('entities/units.units') }}</th>
        <th>{{ trans_choice('entities/volunteers.pendingStuff', 10) }}</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    // get the steps statuses with their translation
    var statuses = new Array();
    $("input[name^='pending_statuses']").each(function(index, value){
        statuses[$(this).data("text")] = $(this).attr("value");

    });

    var table = $('#pendingVolunteersTable').dataTable({
        "pageLength": 5,
        "bFilter": false,
        "bLengthChange": false,
        "ajax": $("body").attr('data-url') + '/api/volunteers/status/pending',
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
                //show all the pending units
                data: null, render: function (data, type, row) {
                var units = '';

                $.each(data.units, function (index, unit) {
                    if (unit.status == 'Pending')
                        units += '<p>' + unit.description + '</p>';
                });

                return units;
            }
            },
            {
                //show the current pending step for each unit
                data: null, render: function (data, type, row) {
                var status = '';

                $.each(data.units, function (index, unit) {
                    if (unit.status == 'Pending')
                        status += '<p>' + statuses[unit.steps[0].description] + '</p>';

                });
                return status;
            }
            }
        ],
        //custom text
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
        }
    });
</script>
@append
