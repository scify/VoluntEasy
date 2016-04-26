//save a subtask
$("#storeSubTask").click(function (e) {
    e.preventDefault();
    if ($("#addSubTask .name").val() == null || $("#addSubTask .name").val() == '')
        $("#addSubTask .subtask-name_err").show();
    else {
        $("#addSubTask .subtask-name_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/store",
            method: 'POST',
            data: $("#createSubTask").serialize(),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//update a subtask
$("#updateSubTask").click(function (e) {
    e.preventDefault();
    if ($("#editSubTask .name").val() == null || $("#editSubTask .name").val() == '')
        $("#editSubTask .subtask-name_err").show();
    else {
        $("#editSubTask .subtask-name_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/update",
            method: 'POST',
            data: $("#editSubTaskForm").serialize(),
            success: function (result) {
                location.reload();
            }
        });
    }
});


//populate the edit subtask modal with data before displaying it
$(".editSubTask").click(function (e) {

    $.when(getSubtask($(this).attr('data-subtask-id')))
        .then(function () {

            $("#editSubTask .taskId").val(subTask.task_id);
            $("#editSubTask .subTaskId").val(subTask.id);
            $("#editSubTask .name").val(subTask.name);
            $("#editSubTask .description").val(subTask.description);
            $("#editSubTask .due_date").datepicker("update", subTask.due_date);

            $("#editSubTask .subtask-priorities option[value='" + subTask.priority + "']").prop('selected', true);


            if (subTask.users.length > 0) {
                $('#editSubTask input:radio[name=assignToSubtask][value=user]').attr('checked', 'checked');
                $('#editSubTask input:radio[name=assignToSubtask][value=user]').parent().addClass('checked');

                $('#editSubTask .subtaskUserSelect').removeAttr('disabled');
                $('#editSubTask .subtaskUserSelect').val(subTask.users[0].id);
                $('#editSubTask .subtaskVolunteerSelect').attr('disabled', 'disabled');
            }
            else {
                $('#editSubTask .subtaskUserSelect').attr('disabled', 'disabled');
            }

            if (subTask.volunteers.length > 0) {
                $('#editSubTask input:radio[name=assignToSubtask][value=volunteer]').attr('checked', 'checked');
                $('#editSubTask input:radio[name=assignToSubtask][value=volunteer]').parent().addClass('checked');

                $('#editSubTask .subtaskVolunteerSelect').removeAttr('disabled');
                $('#editSubTask .subtaskVolunteerSelect').val(subTask.volunteers[0].id);
                $('#editSubTask .subtaskUserSelect').attr('disabled', 'disabled');
            }
            else {
                $('#editSubTask .subtaskVolunteerSelect').attr('disabled', 'disabled');
            }


            //show modal
            $('#editSubTask .todos').show();
            $('#editSubTask').modal('show');
        });
});


//delete a subtask
$(".deleteSubTask").click(function () {
    if (confirm(Lang.get('js-components.deleteSubtask')) == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/delete/" + $(this).attr('data-subtask-id'),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//set the userSelect disabled or not depending on checkbox value
$('.assignToSubtask').click(function () {
    var mode = 'store';
    if ($(this).hasClass('edit'))
        mode = 'edit';

    if ($(this).val() == 'user') {
        $('.subtaskUserSelect.' + mode).removeAttr('disabled');
        $('.subtaskVolunteerSelect.' + mode).attr('disabled', 'disabled');
    }
    else if ($(this).val() == 'volunteer') {
        $('.subtaskVolunteerSelect.' + mode).removeAttr('disabled');
        $('.subtaskUserSelect.' + mode).attr('disabled', 'disabled');
    }
});


/* show the subtask info at the side div */
function showSubTaskInfo(subTaskId) {

    $.when(getSubtask(subTaskId))
        .then(function () {
            $(".subTaskInfo .due_date").text(subTask.due_date == null ? '' : ', ' + Lang.get('js-components.expires') + ' ' + subTask.due_date);
            $(".subTaskInfo .name").text(subTask.name);
            $(".subTaskInfo .description").text(subTask.description == null || subTask.description == '' ? '' : subTask.description);

            $(".subTaskInfo .editSubTask").attr('data-subtask-id', subTask.id);
            $(".subTaskInfo .editSubTask").attr('data-task-id', subTask.task_id);
            $(".subTaskInfo .deleteSubTask").attr('data-subtask-id', subTask.id);


            //set priorities
            priorityText = '';
            if (subTask.priority == 1)
                priorityText = Lang.get('js-components.low');
            if (subTask.priority == 2)
                priorityText = Lang.get('js-components.medium');
            if (subTask.priority == 3)
                priorityText = Lang.get('js-components.high');
            if (subTask.priority == 4)
                priorityText = Lang.get('js-components.urgent');


            $(".subTaskInfo .priority").html('<i class="fa fa-arrow-up priority-' + subTask.priority + '" title="' + priorityText + '"></i>');
            $(".subTaskInfo .priority").attr('data-priority', subTask.priority);


            //image for assigned to user/volunteer
            imagePath = '';
            if (subTask.users.length > 0) {
                assignedToName = subTask.users[0].name + ' ' + subTask.users[0].last_name;
                imagePath = (subTask.users[0].image_name == null || subTask.users[0].image_name == "" ?
                $("body").attr('data-url') + '/assets/images/default.png' : $("body").attr('data-url') + '/assets/uploads/users/' + subTask.users[0].image_name);
            }
            if (subTask.volunteers.length > 0) {
                assignedToName = subTask.volunteers[0].name + ' ' + subTask.volunteers[0].last_name;
                imagePath = (subTask.volunteers[0].image_name == null || volunteers.users[0].image_name == "" ?
                $("body").attr('data-url') + '/assets/images/default.png' : $("body").attr('data-url') + '/assets/uploads/users/' + subTask.volunteers[0].image_name);
            }

            if (imagePath != '')
                $(".subTaskInfo .assignedTo").html(Lang.get('js-components.assignedTo') + ' <img class="img-circle avatar userImage" src="' + imagePath + '" width="30" height="30" title="' + assignedToName + '">');
            else
                $(".subTaskInfo .assignedTo").html('');


            //add the work dates
            html = '';
            if (subTask.shifts.length == 0) {
                $('.noShifts').show();
                $('.shiftsTable').hide();
            }
            else {
                $.each(subTask.shifts, function (i, shift) {

                    html += '<tr><td>' + shift.comments + '</td>';
                    if (shift.from_date != null)
                        html += '<td>' + shift.from_date + '</td>';
                    else
                        html += '<td>-</td>';
                    if (shift.from_hour != null && shift.to_hour != null)
                        html += '<td>' + shift.from_hour + '-' + shift.to_hour + '</td>';
                    else if (shift.from_hour != null)
                        html += '<td>shift.from_hour</td>';
                    else
                        html += '<td>-</td>';
                    if (shift.volunteer_sum != null)
                        html += '<td>' + shift.volunteers.length + '/' + shift.volunteer_sum + '</td>';
                    else
                        html += '<td>-</td>';

                    if (isPermitted == 'true') {
                        html += '<td><button class="btn btn-sm btn-success edit-btn" onclick="editShift(' + shift.id + ')"><i class="fa fa-edit"></i></button>';
                        html += '<button class="btn btn-sm btn-danger" onclick="deleteShift(' + shift.id + ')"><i class="fa fa-trash"></i></button></td>';
                    }
                    html += '</tr>';

                    $('.shiftsTable > tbody:last-child').html(html);
                    $('.shiftsTable').show();
                    $('.noShifts').hide();
                });
            }

            $(".taskInfo").hide();
            $(".subTaskInfo").show();
        });
}


//get a subtask by its id
function getSubtask(id) {
    return $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/subtasks/one/" + id,
        success: function (result) {
            subTask = result;
        }
    });
}
