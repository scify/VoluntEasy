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
function deleteShift(id) {

    if (confirm(Lang.get('js-components.deleteShift')) == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/shifts/delete/" + id,
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
    html += '<td><span class="fromHour myeditable editable time hours required" data-type="select" data-name="fromHour" data-value="09" data-pk="0"></span>:<span class="fromHour myeditable editable time minutes required" data-type="select" data-name="fromMinute" data-value="00" data-pk="0"></span></td>';
    html += '<td><span class="toHour myeditable editable time hours required" data-type="select" data-name="toHour" data-value="11" data-pk="0"></span>:<span class="toHour myeditable editable time minutes required" data-type="select" data-name="toMinute" data-value="30" data-pk="0"></span></td>';
    html += '<td><span class="volunteerSum text myeditable editable required" data-type="text" data-name="volunteerSum" data-pk="0"></span></td>';
    html += '<td><span class="availableVolunteers myeditable editable select2" data-type="text" data-name="availableVolunteers" data-pk="0"></span></td>';
    html += '';
    if (isPermitted == 'true') {
        html += '<td><button class="btn btn-sm btn-success save-btn" onclick="storeShift(\'' + parentId + '\', \'' + mode + '\')"><i class="fa fa-save"></i></button>';
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

            html += '<tr><td>' + shift.comments + '</td>';
            if (shift.from_date != null)
                html += '<td>' + shift.from_date + '</td>';
            else
                html += '<td>-</td>';

            html += '<td>' + shift.from_hour + '</td>';
            html += '<td>' + shift.to_hour + '</td>';
            if (shift.volunteer_sum != null)
                html += '<td>' + shift.volunteers.length + '/' + shift.volunteer_sum + '</td>';
            else
                html += '<td>-</td>';
            html += '<td>-</td>';

            if (isPermitted == 'true') {
                html += '<button class="btn btn-sm btn-danger" onclick="deleteShift(' + shift.id + ')"><i class="fa fa-trash"></i></button></td>';
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
function storeShift(parentId, mode) {

    var comments = $(parentId + ' .comments').text();
    var dateFrom = $(parentId + ' .fromDate').text();
    var volunteerSum = $(parentId + ' .volunteerSum').text();

    if (comments == 'Empty' || dateFrom == 'Empty' || volunteerSum == 'Empty') {
        $("#shiftError").show();
    }
    else {
        $("#shiftError").hide();
        $.ajax({
            url: getStoreShiftUrl(mode) + 'store',
            method: 'GET',
            data: {
                comments: $(parentId + ' .comments').text(),
                dateFrom: $(parentId + ' .fromDate').text(),
                hourFrom: $(parentId + ' .fromHour.hours').text() + ':' + $(parentId + ' .fromHour.minutes').text(),
                hourTo: $(parentId + ' .toHour.hours').text() + ':' + $(parentId + ' .toHour.minutes').text(),
                volunteerSum: $(parentId + ' .volunteerSum').text(),
                taskId: task.id,
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
        url: getStoreShiftUrl(mode) + 'update'
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
        url: getStoreShiftUrl(mode) + 'update',
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
        url: getStoreShiftUrl(mode) + 'update',
        source: [
            {value: '07', text: '07'},
            {value: '08', text: '08'},
            {value: '09', text: '09'},
            {value: '10', text: '10'},
            {value: '10', text: '10'},
            {value: '11', text: '11'},
            {value: '12', text: '12'},
            {value: '13', text: '13'},
            {value: '14', text: '14'},
            {value: '15', text: '15'},
            {value: '16', text: '16'},
            {value: '17', text: '17'},
            {value: '18', text: '18'},
            {value: '19', text: '19'},
            {value: '20', text: '20'},
            {value: '21', text: '21'},
            {value: '22', text: '22'},
            {value: '23', text: '23'},
            {value: '00', text: '00'},
            {value: '01', text: '01'},
            {value: '02', text: '02'},
            {value: '03', text: '03'},
            {value: '04', text: '04'},
            {value: '05', text: '05'},
            {value: '06', text: '06'},
        ]
    });
    $(parentId + ' .myeditable.time.minutes').editable({
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
        url: getStoreShiftUrl(mode) + 'update',
        source: [
            {value: '00', text: '00'},
            {value: '10', text: '10'},
            {value: '20', text: '20'},
            {value: '30', text: '30'},
            {value: '40', text: '40'},
            {value: '50', text: '50'}
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
function getStoreShiftUrl(mode) {
    if (mode == 'task')
        return $("body").attr('data-url') + "/actions/tasks/shifts/";
    else
        return $("body").attr('data-url') + "/actions/tasks/subtasks/shifts/";
}
