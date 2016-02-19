/* General js scripts about the task board*/

//global variables to keep the task and subtask
var task;
var subTask;


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
                console.log(result);
                //location.reload();
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
                console.log(result);
                //location.reload();
            }
        });
    }
});

//populate the edit task modal with data before displaying it
$(".editTask").click(function (e) {


    $("#editTask #taskId").val($(this).attr('data-task-id'));
    $("#editTask #due_date").datepicker("update", $(".taskInfo .due_date").text());
    $("#editTask #name").val($(".taskInfo .name").text());
    $("#editTask #description").val($(".taskInfo .description").text());
    $("#editTask #priorities option[value='" + $(".taskInfo .priority").attr('data-priority') + "']").prop('selected', true);

    //show modal
    $('#editTask').modal('show');
});

//populate the edit subtask modal with data before displaying it
$(".editSubTask").click(function (e) {

    $("#editSubTask #taskId").val($(this).attr('data-task-id'));
    $("#editSubTask #subTaskId").val($(this).attr('data-subtask-id'));
    $("#editSubTask #subtask-name").val($(".subTaskInfo .name").text());
    $("#editSubTask #subtask-description").val($(".subTaskInfo .description").text());

    $("#subtask-priorities option[value='" + $(".subTaskInfo .priority") + "']").prop('selected', true);
/*
    volunteers = [];
    $.each(result.volunteers, function (index, value) {
        volunteers.push(value.id);
    });

    $("#editSubTask #subtaskVolunteers").val(volunteers).trigger("change");
*/
    //show modal
    $('#editSubTask').modal('show');
});


//delete a task
$(".deleteTask").click(function () {
    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το task;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/delete/" + $(this).attr('data-task-id'),
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


//add another editable fields to fill in work date and hours
function addWorkDate() {


    var lastTr = $("#workDates tr:last");

    if ($(lastTr).find('.workDate input').val() == null || $(lastTr).find('.workDate input').val() == '' ||
        $(lastTr).find('.workHourFrom input').val() == null || $(lastTr).find('.workHourFrom input').val() == '' ||
        $(lastTr).find('.workHourTo input').val() == null || $(lastTr).find('.workHourTo input').val() == '') {
        $(".workError").show();
    }
    else {
        $(".workError").hide();
        $("#workDates tr:last").clone().find("input").each(function () {
            $(this).val('');
        }).end().appendTo("#workDates");


        $(".date").datepicker({
            language: 'el',
            format: 'dd/mm/yyyy',
            autoclose: true
        });
        $(".time").timepicker({
            lang: {
                'am': ' π.μ.',
                'pm': ' μ.μ.'
            }
        });
    }
}

function showTaskInfo(taskId) {
    //fetch the task data to show in the sidebar
    $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/one/" + taskId,
        success: function (result) {
            $(".subTaskInfo").hide();

            $(".taskInfo .due_date").text(result.due_date == null ? '-' : result.due_date);
            $(".taskInfo .name").text(result.name);
            $(".taskInfo .description").text(result.description == null ? '-' : result.description);

            $(".taskInfo .editTask").attr('data-task-id', result.id);
            $(".taskInfo .deleteTask").attr('data-task-id', result.id);


            /*   var status = '-';
             console.log(result);
             if (result.todoSubtasks != null && result.todoSubtasks.length() > 0 &&
             (result.doingSubtasks == null || result.doingSubtasks.length() == 0) &&
             (result.doneSubtasks == null || result.doneSubtasks.length() == 0))

             status = '<span class="status todo">TO DO</span>';

             else if (result.doneSubtasks != null && result.doneSubtasks.length() > 0 &&
             (result.doingSubtasks == null || result.doingSubtasks.length() == 0) &&
             (result.todoSubtasks == null || result.todoSubtasks.length() == 0))

             status = '<span class="status done">DONE</span>';

             else if (result.doingSubtasks != null && result.doingSubtasks.length() > 0)
             status = '<span class="status doing">DOING</span>';

             $(".taskInfo .tstatus").html(status);
             */

            if (result.priority == 1)
                $(".taskInfo .priority").text('Χαμηλή');
            if (result.priority == 2)
                $(".taskInfo .priority").text('Μεσαία');
            if (result.priority == 3)
                $(".taskInfo .priority").text('Υψηλή');
            if (result.priority == 4)
                $(".taskInfo .priority").text('Επείγον');

            $(".taskInfo .priority").attr('data-priority', result.priority);

            $(".taskInfo").show();
        }
    });
}


function showSubTaskInfo(subTaskId) {
    //fetch the task data to show in the sidebar
    $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/subtasks/one/" + subTaskId,
        success: function (result) {
            $(".taskInfo").hide();

            console.log(result);

            $(".subTaskInfo .due_date").text(result.due_date == null ? '-' : result.due_date);
            $(".subTaskInfo .name").text(result.name);
            $(".subTaskInfo .description").text(result.description == null ? '-' : result.description);

            $(".subTaskInfo .editSubTask").attr('data-subtask-id', result.id);
            $(".subTaskInfo .editSubTask").attr('data-task-id', result.task_id);
            $(".subTaskInfo .deleteSubTask").attr('data-subtask-id', result.id);

            if (result.priority == 1)
                $(".subTaskInfo .priority").text('Χαμηλή');
            if (result.priority == 2)
                $(".subTaskInfo .priority").text('Μεσαία');
            if (result.priority == 3)
                $(".subTaskInfo .priority").text('Υψηλή');
            if (result.priority == 4)
                $(".subTaskInfo .priority").text('Επείγον');

            $(".subTaskInfo .priority").attr('data-priority', result.priority);


            html = '';
            //beware the classy code
            $.each(result.work_dates, function (i, date) {
                html += '<h4>' + date.from_date + '</h4>';

                $.each(date.hours, function (i, hour) {
                    html += '<p>' + hour.from_hour + '-' + hour.to_hour;
                    html += '<br/>Σχόλια: ' + (hour.comments == null ? '-' : hour.comments) + '<br/>';
                    html += '</p>';
                });
            });

            $(".workDatesInfo").html('');
            $(".workDatesInfo").append(html);

            $(".subTaskInfo").show();
        }
    });
}


$('.date').datepicker({
    language: 'el',
    format: 'dd/mm/yyyy',
    autoclose: true
});

$('.time').timepicker({
    lang: {
        'am': ' π.μ.',
        'pm': ' μ.μ.'
    }
});

$(".multiple").select2();


