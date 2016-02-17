/* General js scripts about the task board*/

$(".board-card").draggable({
    containment: ".task-" + $(this).attr('data-task') + ".board-row ",
    connectToSortable: ".board-column"
});

$(".board-column").sortable({
    placeholder: "ui-state-highlight",
    stop: function (event, ui) {
        var status;

        //when the task is moved, the status changes
        if ($(this).hasClass('todo'))
            status = 'To Do';
        else if ($(this).hasClass('doing'))
            status = 'Doing';
        else
            status = 'Done';

        //change the status while remaining at the same page
        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/updateStatus",
            method: 'GET',
            data: {
                "action_id": $("#actionId").attr("data-action-id"),
                "task_id": $(ui.item).attr("data-task"),
                "subTaskId": $(ui.item).attr("data-subtask"),
                "status": status
            },
            success: function (result) {
            }
        });
    }
});

//set the task id in the modal
$(".addSubTask").click(function () {
    $(".modal-body #taskId").val($(this).attr('data-task-id'));
    $("#subtask-priorities option[value='2']").prop('selected', true);
})


//save a task
$("#storeTask").click(function (e) {
    e.preventDefault();
    if ($("#name").val() == null || $("#name").val() == '')
        $("#name_err").show();
    else {
        $("#name_err").hide();

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


//save a subtask
$("#storeSubTask").click(function (e) {
    e.preventDefault();
    if ($("#subtask-name").val() == null || $("#subtask-name").val() == '')
        $("#subtask-name_err").show();
    else {
        $("#subtask-name_err").hide();

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
    if ($("#editSubTask #subtask-name").val() == null || $("#editSubTask #subtask-name").val() == '')
        $("#editSubTask #subtask-name_err").show();
    else {
        $("#editSubTask #subtask-name_err").hide();

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

//populate the edit task modal with data before displaying it
function editTask(taskId) {

    //fetch the subtask data to show in the modal
    $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/one/" + taskId,
        success: function (result) {
            $("#editTask #taskId").val(result.id);
            $("#editTask #due_date").datepicker("update", result.due_date);
            $("#editTask #name").val(result.name);
            $("#editTask #description").val(result.description);
            $("#editTask #priorities option[value='" + result.priority + "']").prop('selected', true);
        }
    });

    //show modal
    $('#editTask').modal('show');
}

//populate the edit subtask modal with data before displaying it
function editSubTask(subTaskId) {

    //fetch the subtask data to show in the modal
    $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/subtasks/one/" + subTaskId,
        success: function (result) {
            $("#editSubTask #taskId").val(result.task_id);
            $("#editSubTask #subTaskId").val(result.id);
            $("#editSubTask #subtask-name").val(result.name);
            $("#editSubTask #subtask-description").val(result.description);
            $("#editSubTask #subtask-due_date").datepicker("update", result.due_date);
            $("#subtask-priorities option[value='" + result.priority + "']").prop('selected', true);

            volunteers = [];
            $.each(result.volunteers, function( index, value ) {
                volunteers.push(value.id);
            });

            $("#editSubTask #subtaskVolunteers").val(volunteers).trigger("change");
        }
    });

    //show modal
    $('#editSubTask').modal('show');
}

//delete a task
$("#deleteTask").click(function () {
    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το task;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/delete/" + $("#taskId").val(),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//delete a subtask
$("#deleteSubTask").click(function () {
    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το subtask;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/delete/" + $("#subTaskId").val(),
            success: function (result) {
                location.reload();
            }
        });
    }
});


$('.date').datepicker({
    language: 'el',
    format: 'dd/mm/yyyy',
    autoclose: true
});

$(".multiple").select2();
