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
    $(".modal-body .taskId").val($(this).attr('data-task-id'));
    $("#subtask-priorities option[value='2']").prop('selected', true);
})


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
                 //location.reload();
                console.log(result);
            }
        });
    }
});

//populate the edit task modal with data before displaying it
$(".editTask").click(function (e) {

    $("#editTask .taskId").val($(this).attr('data-task-id'));
    $("#editTask .due_date").datepicker("update", task.due_date);
    $("#editTask .name").val(task.name);
    $("#editTask .description").val(task.description);
    $("#editTask .priorities option[value='" + task.priority + "']").prop('selected', true);

    //show modal
    $('#editTask').modal('show');
});

//populate the edit subtask modal with data before displaying it
$(".editSubTask").click(function (e) {

    $("#editSubTask .taskId").val(subTask.task_id);
    $("#editSubTask .subTaskId").val(subTask.id);
    $("#editSubTask .name").val(subTask.name);
    $("#editSubTask .description").val(subTask.description);
    $("#editSubTask .due_date").datepicker("update", subTask.due_date);

    $("#editSubTask .subtask-priorities option[value='" + subTask.priority + "']").prop('selected', true);

    var lastTr = $("#editSubTask .workDates tr:first");

    //fill the workDates table
    $.each(subTask.work_dates, function (i, date) {

        $.each(date.hours, function (j, hour) {

            var clone = $("#editSubTask .workDates tr:last").clone().find("input, select, textarea").each(function () {
                var name = $(this).attr('name');
                console.log(name);
                if (name == "workDates[ids][]")
                    $(this).eq(j).val(date.id);
                else if (name == "workDates[dates][]")
                    $(this).eq(j).val(date.from_date);
                else if (name == "workDates[hourFrom][]")
                    $(this).eq(j).val(hour.from_hour);
                else if (name == "workDates[hourTo][]")
                    $(this).eq(j).val(hour.to_hour);
                else if (name == "workDates[volunteerSum][]")
                    $(this).eq(j).val(hour.volunteer_sum);
                else if (name == "workDates[subtaskVolunteers][]")
                //TODO: check this
                    $(this).eq(j).val('aaaa');
                else if (name == "workDates[comments][]")
                    $(this).eq(j).val(hour.comments);
            }).end()

            $("#editSubTask .workDates tr:last").remove();
            $(clone).appendTo("#editSubTask .workDates");
        });
    });

    refreshDateTime();

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
$(".deleteSubTask").click(function () {
    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το subtask;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/delete/" + $(this).attr('data-subtask-id'),
            success: function (result) {
                location.reload();
            }
        });
    }
});


//add another editable fields to fill in work date and hours
function addWorkDate(parentId) {

    if (validateWorkTable(parentId)) {
        $(".workError").show();
    }
    else {
        $(".workError").hide();
        $(".workDates tr:last").clone().find("input").each(function () {
            $(this).val('');
        }).end().appendTo("#workDates");

        refreshDateTime();
    }
}

/* show the task info at the side div */
function showTaskInfo(taskId) {
    //fetch the task data to show in the sidebar
    $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/one/" + taskId,
        success: function (result) {
            task = result;

            $(".subTaskInfo").hide();

            $(".taskInfo .due_date").text(task.due_date == null ? '-' : task.due_date);
            $(".taskInfo .name").text(task.name);
            $(".taskInfo .description").text(task.description == null || task.description == '' ? '-' : task.description);

            $(".taskInfo .editTask").attr('data-task-id', task.id);
            $(".taskInfo .deleteTask").attr('data-task-id', task.id);

            if (task.priority == 1)
                $(".taskInfo .priority").text('Χαμηλή');
            if (task.priority == 2)
                $(".taskInfo .priority").text('Μεσαία');
            if (task.priority == 3)
                $(".taskInfo .priority").text('Υψηλή');
            if (task.priority == 4)
                $(".taskInfo .priority").text('Επείγον');

            $(".taskInfo .priority").attr('data-priority', task.priority);

            $(".taskInfo").show();
        }
    });
}


/* show the subtask info at the side div */
function showSubTaskInfo(subTaskId) {
    //fetch the task data to show in the sidebar
    $.ajax({
        method: 'GET',
        url: $("body").attr('data-url') + "/actions/tasks/subtasks/one/" + subTaskId,
        success: function (result) {
            $(".taskInfo").hide();

            subTask = result;

            $(".subTaskInfo .due_date").text(subTask.due_date == null ? '-' : subTask.due_date);
            $(".subTaskInfo .name").text(subTask.name);
            $(".subTaskInfo .description").text(subTask.description == null || subTask.description == '' ? '-' : subTask.description);

            $(".subTaskInfo .editSubTask").attr('data-subtask-id', subTask.id);
            $(".subTaskInfo .editSubTask").attr('data-task-id', subTask.task_id);
            $(".subTaskInfo .deleteSubTask").attr('data-subtask-id', subTask.id);

            if (subTask.priority == 1)
                $(".subTaskInfo .priority").text('Χαμηλή');
            if (subTask.priority == 2)
                $(".subTaskInfo .priority").text('Μεσαία');
            if (subTask.priority == 3)
                $(".subTaskInfo .priority").text('Υψηλή');
            if (subTask.priority == 4)
                $(".subTaskInfo .priority").text('Επείγον');

            $(".subTaskInfo .priority").attr('data-priority', subTask.priority);


            html = '';
            //beware the classy code
            $.each(subTask.work_dates, function (i, date) {
                html += '<h4>' + date.from_date + '</h4>';

                $.each(date.hours, function (i, hour) {
                    html += '<p>' + hour.from_hour + '-' + hour.to_hour + '<br/>';
                    html += 'Αριθμός εθελοντών: ' + (hour.volunteer_sum == null ? '-' : hour.volunteer_sum) + '<br/>';
                    html += 'Σχόλια: ' + (hour.comments == null ? '-' : hour.comments) + '<br/>';
                    html += '</p>';
                });
            });

            $(".workDatesInfo").html('');
            $(".workDatesInfo").append(html);

            $(".subTaskInfo").show();
        }
    });
}

/* validate the work date tables, check that no row is incomplete */
function validateWorkTable(parentId) {
    var lastTr = $(parentId + " .workDates tr:last");

    if (($(lastTr).find('.workDate input').val() == null || $(lastTr).find('.workDate input').val() == '' ||
        $(lastTr).find('.workHourFrom input').val() == null || $(lastTr).find('.workHourFrom input').val() == '' ||
        $(lastTr).find('.workHourTo input').val() == null || $(lastTr).find('.workHourTo input').val() == '')) {
        return true;
    }
    else return false;
}

function refreshDateTime() {

    $(".date").datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('show', function (selected) {
        if (selected.date != null) {
            var date = new Date(selected.date.valueOf());
            $(this).attr('data-date', date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());
        }
    }).on('changeDate', function (selected) {
        var date = new Date(selected.date.valueOf());
        $(this).attr('data-date', date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());
    });

    $(".time").timepicker({
        lang: {
            'am': ' π.μ.',
            'pm': ' μ.μ.'
        }
    });
}


$(".multiple").select2();
refreshDateTime();

