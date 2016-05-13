//save a task
$("#storeTask").click(function (e) {
    e.preventDefault();
    if ($("#addTask .name").val() == null || $("#addTask .name").val() == '')
        $("#addTask .name_err").show();
    else {
        $("#addTask .name_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/store",
            method: 'POST',
            data: $("#createTask").serialize(),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//update a task
$("#updateTask").click(function (e) {
    e.preventDefault();
    if ($("#editTaskForm .name").val() == null || $("#editTaskForm .name").val() == '')
        $("#editTaskForm .name_err").show();
    else {
        $("#editTaskForm .name_err").hide();
        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/update",
            method: 'GET',
            data: $("#editTaskForm").serialize(),
            success: function (result) {
                location.reload();
            }
        });
    }
});


//delete a task
$(".deleteTask").click(function () {
    if (confirm(Lang.get('js-components.deleteTask')) == true) {
      /*  $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/delete/" + $(this).attr('data-task-id'),
            success: function (result) {
                //location.reload();
            }
        });*/
    }
});


//set the userSelect and volunteerSelect disabled or not depending on checkbox value
$('.assignToTask').click(function () {
    var mode = 'store';
    if ($(this).hasClass('edit'))
        mode = 'edit';

    if ($(this).val() == 'user') {
        $('.taskUserSelect.' + mode).removeAttr('disabled');
        $('.taskVolunteerSelect.' + mode).attr('disabled', 'disabled');
    }
    else if ($(this).val() == 'volunteer') {
        $('.taskVolunteerSelect.' + mode).removeAttr('disabled');
        $('.taskUserSelect.' + mode).attr('disabled', 'disabled');
    }
});


//display all the task details, shifts and checklist
$('.viewTask').click(function () {

    var taskId = $(this).attr('data-task-id');

    $.when(getTask(taskId))
        .then(function () {

            imagePath = '';
            if (task.users.length > 0) {
                assignedToName = task.users[0].name + ' ' + task.users[0].last_name;
                imagePath = (task.users[0].image_name == null || task.users[0].image_name == "" ?
                $("body").attr('data-url') + '/assets/images/default.png' : $("body").attr('data-url') + '/assets/uploads/users/' + task.users[0].image_name);
            }
            if (task.volunteers.length > 0) {
                assignedToName = task.volunteers[0].name + ' ' + task.volunteers[0].last_name;
                imagePath = (task.volunteers[0].image_name == null || volunteers.users[0].image_name == "" ?
                $("body").attr('data-url') + '/assets/images/default.png' : $("body").attr('data-url') + '/assets/uploads/users/' + task.volunteers[0].image_name);
            }

            if (imagePath != '')
                $(".taskInfo .assignedTo").html(Lang.get('js-components.assignedTo') + ' <img class="img-circle avatar userImage" src="' + imagePath + '" width="30" height="30" title="' + assignedToName + '">');
            else
                $(".taskInfo .assignedTo").html('');

            priorityText = '';
            if (task.priority == 1)
                priorityText = Lang.get('js-components.low');
            if (task.priority == 2)
                priorityText = Lang.get('js-components.medium');
            if (task.priority == 3)
                priorityText = Lang.get('js-components.high');
            if (task.priority == 4)
                priorityText = Lang.get('js-components.urgent');


            $(".taskInfo .priority").html('<i class="fa fa-arrow-up priority-' + task.priority + '" title="' + priorityText + '"></i>');
            $(".taskInfo .priority").attr('data-priority', task.priority);

            fillTaskFields();
            drawShiftsTable("#taskShifts", task, 'task');
            drawChecklist('task');
            $('#viewTask .add-task').attr('data-mode-id', task.id);

            $('#viewTask').modal('show');

        });

});

//prefill the task fields at the edit form
function fillTaskFields() {
    $("#taskDetails .taskId").val(task.id);
    $("#taskDetails .due_date").datepicker("update", task.due_date);
    $("#taskDetails .name").val(task.name);
    $("#taskDetails .description").val(task.description);
    $("#taskDetails .priorities option[value='" + task.priority + "']").prop('selected', true);

    $("#taskDetails #updateTask").attr('data-task-id', task.id);
    $("#taskDetails .deleteTask").attr('data-task-id', task.id);


    if (task.users.length > 0) {
        $('#taskDetails input:radio[name=assignToTask][value=user]').attr('checked', 'checked');
        $('#taskDetails input:radio[name=assignToTask][value=user]').parent().addClass('checked');

        $('#taskDetails .taskUserSelect').removeAttr('disabled');
        $('#taskDetails .taskUserSelect').val(task.users[0].id);
        $('#taskDetails .taskVolunteerSelect').attr('disabled', 'disabled');
    }
    else {
        $('#taskDetails .taskUserSelect').attr('disabled', 'disabled');
    }

    if (task.volunteers.length > 0) {
        $('#taskDetails input:radio[name=assignToTask][value=volunteer]').attr('checked', 'checked');
        $('#taskDetails input:radio[name=assignToTask][value=volunteer]').parent().addClass('checked');

        $('#taskDetails .taskVolunteerSelect').removeAttr('disabled');
        $('#taskDetails .taskVolunteerSelect').val(task.volunteers[0].id);
        $('#taskDetails .taskUserSelect').attr('disabled', 'disabled');
    }
    else {
        $('#taskDetails .taskVolunteerSelect').attr('disabled', 'disabled');
    }
}


//get a task by its id
function getTask(id) {
    return $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/one/" + id,
        success: function (result) {
            task = result;
        }
    });
}
