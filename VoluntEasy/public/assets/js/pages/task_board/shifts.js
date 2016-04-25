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


//populate the addShift modal with data before displaying it
$(".addShift").click(function (e) {

    $("#addShift .subtaskId").val(subTask.id);

    refreshDateTime();

    //show modal
    $('#addShift').modal('show');
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

            console.log(shift.cta_volunteers);


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
