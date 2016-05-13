//set the task id in the modal
$(".addSubTask").click(function () {
    $(".modal-body .taskId").val($(this).attr('data-task-id'));
    $('#addSubTask .todos').hide();
    $("#subtask-priorities option[value='2']").prop('selected', true);
})

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
    if ($("#editSubTaskForm .name").val() == null || $("#editSubTaskForm .name").val() == '')
        $("#editSubTaskForm .subtask-name_err").show();
    else {
        $("#editSubTaskForm .subtask-name_err").hide();

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


//display all the subtask details, shifts and checklist
$('.viewSubtask').click(function () {

    var subtaskId = $(this).attr('data-subtask');

    $.when(getSubtask(subtaskId))
        .then(function () {


            var imagePath = '';
            var assignedToName = '';

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
                $(".subtaskInfo .assignedTo").html(Lang.get('js-components.assignedTo') + ' <img class="img-circle avatar userImage" src="' + imagePath + '" width="30" height="30" title="' + assignedToName + '">');
            else
                $(".subtaskInfo .assignedTo").html('');

            var priorityText = '';
            if (subTask.priority == 1)
                priorityText = Lang.get('js-components.low');
            if (subTask.priority == 2)
                priorityText = Lang.get('js-components.medium');
            if (subTask.priority == 3)
                priorityText = Lang.get('js-components.high');
            if (subTask.priority == 4)
                priorityText = Lang.get('js-components.urgent');


            $(".subtaskInfo .priority").html('<i class="fa fa-arrow-up priority-' + subTask.priority + '" title="' + priorityText + '"></i>');
            $(".subtaskInfo .priority").attr('data-priority', subTask.priority);

            fillSubtaskFields();
            drawShiftsTable("#subtaskShifts", subTask, 'subtask');
            drawChecklist('subtask');
            $('#viewSubtask .add-task').attr('data-mode-id', subTask.id);

            $('#viewSubtask').modal('show');

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

//set the userSelect and volunteerSelect disabled or not depending on checkbox value
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


function fillSubtaskFields() {

    $("#editSubTaskForm .taskId").val(subTask.task_id);
    $("#editSubTaskForm .subTaskId").val(subTask.id);
    $("#editSubTaskForm .name").val(subTask.name);
    $("#editSubTaskForm .description").val(subTask.description);
    $("#editSubTaskForm .due_date").datepicker("update", subTask.due_date);

    $("#editSubTask .subtask-priorities option[value='" + subTask.priority + "']").prop('selected', true);


    if (subTask.users.length > 0) {
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=user]').attr('checked', 'checked');
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=user]').parent().addClass('checked');

        $('#editSubTaskForm .subtaskUserSelect').removeAttr('disabled');
        $('#editSubTaskForm .subtaskUserSelect').val(subTask.users[0].id);
        $('#editSubTaskForm .subtaskVolunteerSelect').attr('disabled', 'disabled');
    }
    else {
        $('#editSubTaskForm .subtaskUserSelect').attr('disabled', 'disabled');
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=user]').attr('checked', 'false');
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=user]').parent().removeClass('checked');

        $('#editSubTaskForm .subtaskUserSelect').val(0);
    }

    if (subTask.volunteers.length > 0) {
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=volunteer]').attr('checked', 'checked');
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=volunteer]').parent().addClass('checked');

        $('#editSubTaskForm .subtaskVolunteerSelect').removeAttr('disabled');
        $('#editSubTaskForm .subtaskVolunteerSelect').val(subTask.volunteers[0].id);
        $('#editSubTaskForm .subtaskUserSelect').attr('disabled', 'disabled');
    }
    else {
        $('#editSubTaskForm .subtaskVolunteerSelect').attr('disabled', 'disabled');
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=volunteer]').attr('checked', 'false');
        $('#editSubTaskForm input:radio[name=assignToSubtask][value=volunteer]').parent().removeClass('checked');

        $('#editSubTaskForm .subtaskVolunteerSelect').val(0);
        $('#editSubTaskForm .subtaskVolunteerSelect').val(0);
    }
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
