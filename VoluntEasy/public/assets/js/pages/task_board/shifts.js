//save a subtask
$("#storeShift").click(function (e) {
    e.preventDefault();
    if ($("#addShiftForm .shift_comments").val() == null || $("#addShiftForm .shift_comments").val() == '')
        $("#addShiftForm .comments_err").show();
    else {
        $("#addShiftForm .comments_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/shifts/store",
            method: 'GET',
            data: $("#addShiftForm").serialize(),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//update a shift
$("#updateShift").click(function (e) {
    e.preventDefault();
    if ($("#editShiftForm .shift_comments").val() == null || $("#editShiftForm .shift_comments").val() == '')
        $("#editShiftForm .subtask-comments_err").show();
    else {
        $("#editShiftForm .subtask-comments_err").hide();

        volunteers = [];
        $("#sub_volunteers_to option").each(function (name, val) {
            volunteers.push(val.value);
        });

        data = $("#editShiftForm").serializeArray();
        data.push({name: 'volunteers', value: volunteers});
        data.push({name: 'action_id', value: $("#actionId").attr('data-action-id')});

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/shifts/update",
            method: 'GET',
            data: data,
            success: function (result) {
                location.reload();
                //console.log(result);
            }
        });
    }
});


//populate the addSubtaskShift modal with data before displaying it
$(".addSubtaskShift").click(function (e) {

    $("#addSubtaskShift .subtaskId").val(subTask.id);

    refreshDateTime();

    //show modal
    $('#addSubtaskShift').modal('show');
});

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


//add another editable fields to fill in work date and hours
function addShift(parentId) {

    if (validateWorkTable(parentId)) {
        $(".workError").show();
    }
    else {
        $(".workError").hide();
        $(parentId + " .shifts tr:last").clone().find("input").each(function () {
            $(this).val('');
        }).end().appendTo(parentId + " .shifts");

        refreshDateTime();
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

//populate the editShift modal before showing
function editShift(id) {

    $.each(subTask.shifts, function (i, shift) {

        if (id == shift.id) {
            $("#editShift .shiftId").val(shift.id);
            $("#editShift .shift_comments").val(shift.comments);
            $("#editShift .dateFrom").val(shift.from_date);
            $("#editShift .hourFrom").val(shift.from_hour);
            $("#editShift .hourTo").val(shift.to_hour);
            $("#editShift .volunteerSum").val(shift.volunteer_sum);

            //check if ctaVolunteers table should be displayed,
            //aka the table that holds the volunteers that have claimed interest in the action
            if (shift.cta_volunteers.length == 0) {
                $(".ctaVolunteers").hide();
            }
            else {
                var html = '';
                $.each(shift.cta_volunteers, function (i, cta) {
                    html += '<tr><td>' + cta.first_name + ' ' + cta.last_name + '</td>';
                    html += '<td><a href="mailto:' + cta.email + '">' + cta.email + '</a>, ' + cta.phone_number;

                    if (cta.comments != null && cta.comments != '')
                        html += '<br/>' + Lang.get('js-components.volunterComments') + ': ' + cta.comments + '</td>';
                    else
                        html += '</td>';

                    if (cta.volunteer.length > 0) {
                        //ctavolunteer is assigned to a profile
                        html += '<td>' + Lang.get('js-components.assignedToProfile', {
                            linkStart: '<a href="' + $("body").attr("data-url") + '/volunteers/one/' + cta.volunteer[0].id + '" target="_blank">',
                            linkEnd: '</a>'
                        }) + '</td>';

                        html += '<td><button type="button"   class="btn btn-danger btn-sm right-margin" title="' + Lang.get('js-components.reject') + '" onclick="deleteCTAVolunteer(' + cta.id + ')"><i class="fa fa-trash"></i></button></td>';
                    }
                    else if (cta.mightBe != null) {
                        //ctavolunteer found in platform, not assigned to any actual volunteer profile
                        html += '<td>' + Lang.get('js-components.volunteerFound', {
                            linkStart: '<a href="' + $("body").attr("data-url") + '/volunteers/one/' + cta.mightBe.id + '" target="_blank">',
                            linkEnd: '</a>'
                        }) + '</td>';

                        html += '<td><button type="button" class="btn btn-success btn-sm right-margin" title="' + Lang.get('js-components.approve') + '" onclick="assignToVolunteer(' + cta.mightBe.id + ',' + cta.id + ')"><i class="fa fa-check"></i></button>';
                        html += '<button type="button" class="btn btn-danger btn-sm right-margin" title="' + Lang.get('js-components.reject') + '" onclick="deleteCTAVolunteer(' + cta.id + ')"><i class="fa fa-trash"></i></button></td>';
                    }
                    else {
                        //ctavolunteer not found in platform
                        html += '<td>' + Lang.get('js-components.volunteerNotFound') + '</td>';
                        html += '<td><button type="button"  class="btn btn-danger btn-sm right-margin" title="' + Lang.get('js-components.reject') + '" onclick="deleteCTAVolunteer(' + cta.id + ')"><i class="fa fa-trash"></i></button></td>';
                    }

                    html += '</tr>';
                });

                $('.ctaVolunteers table > tbody:last-child').html(html);
                $(".ctaVolunteers").show();
            }

            populateVolunteers(id);
            refreshDateTime();
            $('#editShift').modal('show');
            return false;
        }
    });
}

//draw the row that holds empty fields to be filled
function drawNewShiftRow(parentId, mode) {
    var html = '';

    html += '<tr><td colspan="7"><i>' + Lang.get('js-components.newShift') + '</i></td></tr>';
    html += '<tr><td><span class="comments myeditable editable text required" data-type="text" data-name="comments" data-pk="0"></span></td>';
    html += '<td><span class="fromDate myeditable editable date required" data-type="date" data-name="fromDate" data-pk="0"></span></td>';
    html += '<td><span class="fromHour myeditable editable time hours required" data-type="select" data-name="fromHour" data-value="09" data-pk="0"></span></td>';
    html += '<td><span class="toHour myeditable editable time hours required" data-type="select" data-name="toHour" data-value="11" data-pk="0"></span></td>';
    html += '<td><span class="volunteerSum text myeditable editable required" data-type="text" data-name="volunteerSum" data-pk="0"></span></td>';
    html += '<td><span class="availableVolunteers myeditable editable select2" data-type="text" data-name="availableVolunteers" data-pk="0"></span></td>';
    html += '';
    if (isPermitted == 'true') {
        html += '<td><button class="btn btn-sm btn-success save-btn" onclick="storeShift(0, \'' + parentId + '\', \'' + mode + '\')"><i class="fa fa-save"></i></button>';
    }
    html += '</tr>';

    return html;
}

//draw the shifts table and add the x-editable fields
function drawShiftsTable(parentId, type, mode) {
    //add the work dates
    var html = '';

    if (type.shifts.length == 0) {
        // $(parentId + ' .noShifts').hide();
        //$(parentId + ' .shiftsTable').hide();
        html = drawNewShiftRow(parentId, mode);
        $(parentId + ' .shiftsTable > tbody:last-child').html(html);
        $(parentId + ' .shiftsTable').show();
    }
    else {

        $.each(type.shifts, function (i, shift) {

            html += '<tr><td><span class="comments myeditable editable text required" data-type="text" data-name="comments" data-value="' + shift.comments + '" data-pk="' + shift.id + '"></span></td>';
            html += '<td><span class="fromDate myeditable editable date required" data-type="date" data-name="fromDate" data-value="' + shift.from_date + '" data-pk="' + shift.id + '"></span></td>';
            html += '<td><span class="fromHour myeditable editable time hours required" data-type="select" data-name="fromHour" data-value="' + shift.from_hour + '"  data-pk="' + shift.id + '"></span>';
            html += '<td><span class="toHour myeditable editable time hours required" data-type="select" data-name="toHour" data-value="' + shift.to_hour + '" data-pk="' + shift.id + '"></span>';
            html += '<td><span class="volunteerSum text myeditable editable required" data-type="text" data-name="volunteerSum"  data-value="' + shift.volunteer_sum + '" data-pk="' + shift.id + '"></span></td>';
            html += '<td><span class="availableVolunteers myeditable editable select2" data-type="text" data-name="availableVolunteers"  data-value="' + shift.volunteerSum + '" data-pk="' + shift.id + '"></span></td>';
            html += '';
            if (isPermitted == 'true') {
                html += '<td><button class="btn btn-sm btn-success save-btn right-margin" onclick="updateShift(\'' + shift.id + '\',\'' + parentId + '\', \'' + mode + '\')"><i class="fa fa-save"></i></button>';
                html += '<button class="btn btn-sm btn-danger save-btn" onclick="deleteShift(\'' + shift.id + '\', \'' + mode + '\')"><i class="fa fa-trash"></i></button></td>';
            }
            html += '</tr>';
        });

        html += drawNewShiftRow(parentId, mode);

        $(parentId + ' .shiftsTable > tbody:last-child').html(html);
        $(parentId + ' .shiftsTable').show();
        $(parentId + ' .noShifts').hide();
    }

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
            data: {
                comments: comments,
                dateFrom: dateFrom,
                hourFrom: $(parentId + ' .fromHour.hours[data-pk=' + shiftId + ']').text(),
                hourTo: $(parentId + ' .toHour.hours[data-pk=' + shiftId + ']').text(),
                volunteerSum: volunteerSum,
                taskId: task.id,
            },
            success: function (result) {
                console.log(result);
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
            data: {
                comments: comments,
                dateFrom: dateFrom,
                hourFrom: $(parentId + ' .fromHour.hours[data-pk=' + shiftId + ']').text(),
                hourTo: $(parentId + ' .toHour.hours[data-pk=' + shiftId + ']').text(),
                volunteerSum: volunteerSum,
                taskId: task.id,
                shiftId: shiftId,
            },
            success: function (result) {
                console.log(result);
            }
        });
    }
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

    //$(parentId + ' .myeditable.select2').editable({type: 'select2'});
}


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
