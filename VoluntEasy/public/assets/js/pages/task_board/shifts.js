//assign a ctavolunteer to an existing volunteer
function assignToVolunteer(volunteer_id, cta_volunteer_id) {
    if (confirm(Lang.get('js-components.assignVolunteer')) == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/ctaVolunteer/assignToVolunteer",
            data: {
                cta_volunteer_id: cta_volunteer_id,
                volunteer_id: volunteer_id,
                action_id: $("#actionId").attr('data-action-id')
            },
            success: function (result) {
                location.reload();
            }
        });
    }
}

//delete a shift
function deleteShift(id, mode) {

    if (confirm(Lang.get('js-components.deleteShift')) == true) {

        $.ajax({
            method: 'GET',
            url: getShiftUrl(mode) + 'delete/' + id,
            data: {
                action_id: $("#actionId").attr('data-action-id')
            },
            success: function (result) {
                location.reload();
            }
        });
    }
}

//delete a shift
function deleteCTAVolunteer(id) {

    if (confirm(Lang.get('js-components.removeVolunteer')) == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/ctaVolunteer/delete/" + id,
            success: function (result) {
                location.reload();
            }
        });
    }
}

function drawShiftRow(shift, parentId, mode) {
    var html = '';

    if (shift == null) {
        shift = {
            id: 0,
            comments: null,
            from_date: null,
            from_hour: null,
            to_hour: null,
            volunteer_sum: null
        }
    }

    html += '<tr>';
    html += '<td class="col-md-2"><span class="comments myeditable editable text required" data-type="text" data-name="comments" data-value="' + shift.comments + '" data-pk="' + shift.id + '"></span></td>';
    html += '<td class="col-md-2"><span class="fromDate myeditable editable date required" data-type="date" data-name="fromDate" data-value="' + shift.from_date + '" data-pk="' + shift.id + '"></span></td>';
    html += '<td class="col-md-1"><span class="fromHour myeditable editable time hours required" data-type="select" data-name="fromHour" data-value="' + shift.from_hour + '"  data-pk="' + shift.id + '"></span></td>';
    html += '<td class="col-md-1"><span class="toHour myeditable editable time hours required" data-type="select" data-name="toHour" data-value="' + shift.to_hour + '" data-pk="' + shift.id + '"></span></td>';
    html += '<td class="col-md-1"><span class="volunteerSum text myeditable editable required" data-type="text" data-name="volunteerSum" data-value="' + shift.volunteer_sum + '" data-pk="' + shift.id + '"></span></td>';
    html += '<td class="col-md-3"><span class="availableVolunteers myeditable editable select2" data-type="select2" data-name="availableVolunteers" data-pk="' + shift.id + '" data-mode="' + mode + '" data-parent-id="' + parentId + '"></span></td>';
    if (isPermitted == 'true') {
        html += '<td class="col-md-2"><button class="btn btn-sm btn-success save-btn right-margin" onclick="updateShift(\'' + shift.id + '\',\'' + parentId + '\', \'' + mode + '\')"><i class="fa fa-save"></i></button>';
        if (shift.id != 0)
            html += '<button class="btn btn-sm btn-danger save-btn" onclick="deleteShift(\'' + shift.id + '\', \'' + mode + '\')"><i class="fa fa-trash"></i></button></td>';
    }
    html += '</tr>';

    return html;
}

//draw the shifts table and add the x-editable fields
function drawShiftsTable(parentId, type, mode) {
    //add the work dates
    var html = '';

    if (type.shifts.length == 0) {
        html += drawShiftRow(null, parentId, mode);
    }
    else {
        $.each(type.shifts, function (i, shift) {
            html += drawShiftRow(shift, parentId, mode);
        });

        html += '<tr><td colspan="7" class="newShift"><strong>' + Lang.get('js-components.newShift') + '</strong></td></tr>';
        html += drawShiftRow(null, parentId, mode);
    }

    $(parentId + ' .shiftsTable > tbody:last-child').html(html);

    initEditables(parentId, mode);
}

//store a new shift
function storeShift(shiftId, parentId, mode) {

    var comments = $(parentId + ' .comments[data-pk=' + shiftId + ']').text();
    var dateFrom = $(parentId + ' .fromDate[data-pk=' + shiftId + ']').text();
    var volunteerSum = $(parentId + ' .volunteerSum[data-pk=' + shiftId + ']').text();

    if (comments == 'Empty' || dateFrom == 'Empty' || volunteerSum == 'Empty') {
        $("#shiftError").show();
    }
    else {
        $("#shiftError").hide();
        $.ajax({
            url: getShiftUrl(mode) + 'store',
            method: 'GET',
            data: getShiftData(mode, 0, parentId, comments, dateFrom, volunteerSum),
            success: function (result) {
                location.reload();
            }
        });
    }
}

//update a new shift
function updateShift(shiftId, parentId, mode) {

    var comments = $(parentId + ' .comments[data-pk=' + shiftId + ']').text();
    var dateFrom = $(parentId + ' .fromDate[data-pk=' + shiftId + ']').text();
    var volunteerSum = $(parentId + ' .volunteerSum[data-pk=' + shiftId + ']').text();

    if (comments == 'Empty' || dateFrom == 'Empty' || volunteerSum == 'Empty') {
        $("#shiftError").show();
    }
    else {
        $("#shiftError").hide();
        $.ajax({
            url: getShiftUrl(mode) + 'update',
            method: 'GET',
            data: getShiftData(mode, shiftId, parentId, comments, dateFrom, volunteerSum),
            success: function (result) {
                location.reload();
            }
        });
    }
}

function getShiftData(mode, shiftId, parentId, comments, dateFrom, volunteerSum) {

    var data;
    console.log($('.selectAvailableVolunteers').val())


    if ($(".availableVolunteers").text() != 'Empty') {
        volunteers
    }

    if (mode == "task" && shiftId == 0)
        data = {
            comments: comments,
            dateFrom: dateFrom,
            hourFrom: $(parentId + ' .fromHour.hours[data-pk=' + shiftId + ']').text(),
            hourTo: $(parentId + ' .toHour.hours[data-pk=' + shiftId + ']').text(),
            volunteerSum: volunteerSum,
            taskId: task.id
        }
    else if (mode == "task" && shiftId != 0)
        data = {
            comments: comments,
            dateFrom: dateFrom,
            hourFrom: $(parentId + ' .fromHour.hours[data-pk=' + shiftId + ']').text(),
            hourTo: $(parentId + ' .toHour.hours[data-pk=' + shiftId + ']').text(),
            volunteerSum: volunteerSum,
            taskId: task.id,
            shiftId: shiftId
        }
    else if (mode == "subtask" && shiftId == 0)
        data = {
            comments: comments,
            dateFrom: dateFrom,
            hourFrom: $(parentId + ' .fromHour.hours[data-pk=' + shiftId + ']').text(),
            hourTo: $(parentId + ' .toHour.hours[data-pk=' + shiftId + ']').text(),
            volunteerSum: volunteerSum,
            subtaskId: subTask.id
        }
    else if (mode == "subtask" && shiftId != 0)
        data = {
            comments: comments,
            dateFrom: dateFrom,
            hourFrom: $(parentId + ' .fromHour.hours[data-pk=' + shiftId + ']').text(),
            hourTo: $(parentId + ' .toHour.hours[data-pk=' + shiftId + ']').text(),
            volunteerSum: volunteerSum,
            subtaskId: subTask.id,
            shiftId: shiftId
        }

    return data;
}

function initEditables(parentId, mode) {

    $(parentId + ' .myeditable.text').editable({
        mode: 'inline',
        send: 'never',
        value: '',
        unsavedclass: null,
        emptytext: function () {
            return Lang.get('js-components.empty');
        },
        validate: function (value) {
            if ($.trim(value) == '') {
                return Lang.get('js-components.requiredField');
            }
        },
        url: getShiftUrl(mode) + 'update'
    });

    $(parentId + ' .myeditable.date').editable({
        send: 'never',
        value: '',
        unsavedclass: null,
        emptytext: function () {
            return Lang.get('js-components.empty');
        },
        validate: function (value) {
            if ($.trim(value) == '') {
                return Lang.get('js-components.requiredField');
            }
        },
        url: getShiftUrl(mode) + 'update',
        format: 'dd/mm/yyyy',
        viewformat: 'dd/mm/yyyy',
        placement: "bottom",
        datetimepicker: {
            weekStart: 1
        }
    });

    $(parentId + ' .myeditable.select2').editable({
        value: null,
        source: [
            {id: 'gb', text: 'Great Britain'},
            {id: 'us', text: 'United States'},
            {id: 'ru', text: 'Russia'}
        ],
        autotext: 'always',
        tpl: '<select style="width:200px;" class="selectAvailableVolunteers" data-mode="' + mode + '" data-parent-id="' + parentId + '" data-pk="' + $(this).attr('data-pk') + '"></select>',
        type: 'select2',
        placement: 'bottom',
        select2: {
            width: 200,
            placeholder: 'Select volunteers',
            allowClear: true,
            multiple: true
        }
    });

    $(parentId + ' .myeditable.time.hours').editable({
        mode: 'inline',
        send: 'never',
        value: '',
        unsavedclass: null,
        emptytext: function () {
            return Lang.get('js-components.empty');
        },
        validate: function (value) {
            if ($.trim(value) == '') {
                return Lang.get('js-components.requiredField');
            }
        },
        url: getShiftUrl(mode) + 'update',
        source: [
            {value: '07:00', text: '07:00'},
            {value: '07:30', text: '07:30'},
            {value: '08:00', text: '08:00'},
            {value: '08:30', text: '08:30'},
            {value: '09:00', text: '09:00'},
            {value: '09:30', text: '09:30'},
            {value: '10:00', text: '10:00'},
            {value: '10:30', text: '10:30'},
            {value: '11:00', text: '11:00'},
            {value: '11:30', text: '11:30'},
            {value: '12:00', text: '12:00'},
            {value: '12:30', text: '12:30'},
            {value: '13:00', text: '13:00'},
            {value: '13:30', text: '13:30'},
            {value: '14:00', text: '14:00'},
            {value: '14:30', text: '14:30'},
            {value: '15:00', text: '15:00'},
            {value: '15:30', text: '15:30'},
            {value: '16:00', text: '16:00'},
            {value: '16:30', text: '16:30'},
            {value: '17:00', text: '17:00'},
            {value: '17:30', text: '17:30'},
            {value: '18:00', text: '18:00'},
            {value: '18:30', text: '18:30'},
            {value: '19:00', text: '19:00'},
            {value: '19:30', text: '19:30'},
            {value: '20:00', text: '20:00'},
            {value: '20:30', text: '20:30'},
            {value: '21:00', text: '21:00'},
            {value: '21:30', text: '21:30'},
            {value: '22:00', text: '22:00'},
            {value: '22:30', text: '22:30'},
            {value: '23:00', text: '23:00'},
            {value: '23:30', text: '23:30'},
            {value: '00:00', text: '00:00'},
            {value: '00:30', text: '00:30'},
            {value: '01:00', text: '01:00'},
            {value: '01:30', text: '01:30'},
            {value: '02:00', text: '02:00'},
            {value: '02:30', text: '02:30'},
            {value: '03:00', text: '03:00'},
            {value: '03:30', text: '03:30'},
            {value: '04:00', text: '04:00'},
            {value: '04:30', text: '04:30'},
            {value: '05:00', text: '05:00'},
            {value: '05:30', text: '05:30'},
            {value: '06:00', text: '06:00'},
            {value: '06:30', text: '06:30'},
        ]
    });
}


$("body").on("select2:select", ".selectAvailableVolunteers", function () {
    console.log($(this).val());
    mode = $(this).attr('data-mode');
    parentId = $(this).attr('data-parent-id');
    pk = $(this).attr('data-pk');

    $(parentId + '.availableVolunteers[data-mode=' + mode + '][data-pk=' + pk + ']').attr('data - values', values);
});


//fill the volunteers multiselect
function populateVolunteers(shiftId) {
    $('#sub_volunteers').html('');

    //set the already assigned volunteers
    $('#sub_volunteers_to').html('');
    assigned = [];
    $.each(subTask.shifts, function (i, shift) {
        if (shift.id == shiftId) {
            $.each(shift.volunteers, function (i, volunteer) {
                var option = $("<option></option>");
                option.val(volunteer.id);
                option.text(volunteer.name + ' ' + volunteer.last_name);

                $('#sub_volunteers_to').append(option);

                assigned.push(volunteer.id);
            });
            return false;
        }
    });

    //add the immediately available volunteers
    //aka those that belong to the unit of the action
    $.each(subTask.unitVolunteers, function (i, volunteer) {
        if ($.inArray(volunteer.id, assigned) == -1) {
            var option = $("<option></option>");
            option.val(volunteer.id);
            option.text(volunteer.name + ' ' + volunteer.last_name);

            $('#sub_volunteers').append(option);
        }
    });
}


//return the url for storing/updating a task shoft or a subtask shift
function getShiftUrl(mode) {
    if (mode == 'task')
        return $("body").attr('data-url') + "/actions/tasks/shifts/";
    else
        return $("body").attr('data-url') + "/actions/tasks/subtasks/shifts/";
}
