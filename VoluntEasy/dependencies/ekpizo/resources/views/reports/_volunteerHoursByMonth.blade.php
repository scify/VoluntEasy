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
    // the hours of the volunteers in each action: a dropdown with the actions and a table
    VE.ready(function () {
        var volunteersByAction = [];
        var totalHours = 0;
        var dropDown = document.getElementById('actionsdDropDown');

        // the rows [id, name, hours] of the volunteers of an action
        function actionRows(actionId) {
            var rows = [];
            volunteersByAction.some(function (action) {
                if (String(action.id) === String(actionId)) {
                    action.volunteers.forEach(function (volunteer) {
                        rows.push([volunteer.id, volunteer.name, volunteer.hours]);
                    });
                    totalHours = action.totalHours;
                    return true;
                }
                return false;
            });
            return rows;
        }

        var byHoursTable = VE.table('#hoursByAction', {
            lengthChange: false,
            data: [],
            columns: [{data: 0}, {data: 1}, {data: 2}],
            pageLength: 5,
            drawCallback: function () {
                // the total hours of the action in the footer
                var footerCell = document.querySelector('#hoursByAction tfoot th:nth-child(3)');
                if (footerCell) footerCell.textContent = Lang.get('js-components.totalHours') + ': ' + totalHours;
            },
            language: VE.tableLanguage('js-components.zeroVolunteers')
        });

        VE.http.get('/reports/volunteerHoursByAction').then(function (result) {
            volunteersByAction = result || [];

            // the dropdown to filter the report by action, with the first action selected
            dropDown.insertAdjacentHTML('beforeend', '<label>' + VE.esc(Lang.get('js-components.action')) + '</label><select class="form-control">' +
                volunteersByAction.map(function (action, index) {
                    return '<option value="' + VE.esc(action.id) + '"' + (index === 0 ? ' selected' : '') + '>' + VE.esc(action.description) + '</option>';
                }).join('') + '</select>');

            var select = dropDown.querySelector('select');
            byHoursTable.setData(actionRows(select.value));
        }).catch(VE.fail);

        // when the user selects a different action, show the data of that action
        dropDown.addEventListener('change', function (event) {
            byHoursTable.setData(actionRows(event.target.value));
        });
    });
</script>
@append
