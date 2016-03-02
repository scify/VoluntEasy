/* General js scripts about the task board*/

//global variables to keep the task and subtask
var task;
var subTask;


$(".board-card").draggable({
    containment: ".task-" + $(this).attr('data-task') + " .board-column ",
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
    $('#addSubTask .todos').hide();
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
                location.reload();
            }
        });
    }
});

//save a subtask
$("#storeWorkDate").click(function (e) {
    e.preventDefault();
    if ($("#addWorkDateForm .work_date_comments").val() == null || $("#addWorkDateForm .work_date_comments").val() == '')
        $("#addWorkDateForm .comments_err").show();
    else {
        $("#addWorkDateForm .comments_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/workdates/store",
            method: 'GET',
            data: $("#addWorkDateForm").serialize(),
            success: function (result) {
                console.log(result);
                // location.reload();
            }
        });
    }
});

//populate the edit task modal with data before displaying it
$(".editTask").click(function (e) {

    $.when(getTask($(this).attr('data-task-id')))
        .then(function () {
            $("#editTask .taskId").val($(this).attr('data-task-id'));
            $("#editTask .due_date").datepicker("update", task.due_date);
            $("#editTask .name").val(task.name);
            $("#editTask .description").val(task.description);
            $("#editTask .priorities option[value='" + task.priority + "']").prop('selected', true);

            //show modal
            $('#editTask').modal('show');
        });
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

            //add the checklist items
            html = '';
            $.each(subTask.checklist, function (i, item) {
                html += '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '">';
                html += '<span class="todo-description">' + item.comments + '</span>';
                html += '<span class="created_updated"><small>Δημιουργήθηκε από ' + item.created_by.name + ' στις ' + item.created_at;
                html += ', τροποποιήθηκε από ' + item.updated_by.name + ' στις ' + item.updated_at + '</small></span>';
                html += '<a href="javascript:void(0);" class="pull-right remove-todo-item" data-id="' + item.id + '"><i class="fa fa-times"></i></a></div>';
            });

            $("#editSubTask .todo-list").html(html);
            $('.todo-list .todo-item.added input').uniform();
            $('.todo-list .todo-item.added input').click(function () {
                if ($(this).is(':checked')) {
                    $(this).parent().parent().parent().toggleClass('complete');
                } else {
                    $(this).parent().parent().parent().toggleClass('complete');
                }
                updateToDoItem($(this).attr('data-id'), $(this).is(':checked'));
            });
            $('.todo-list .todo-item.added .remove-todo-item').click(function () {
                deleteToDoItem($(this).attr('data-id'));
                $(this).parent().remove();
            });

            //show modal
            $('#editSubTask .todos').show();
            $('#editSubTask').modal('show');
        });
});

//populate the addWorkDate modal with data before displaying it
$(".addWorkDate").click(function (e) {

    $("#addWorkDate .subtaskId").val(subTask.id);

    //start adding the volunteers to the multiselect
    //first add the immediately available volunteers
    //aka those that belong to the unit of the action
    var optgroup = $('<optgroup>');
    optgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');
    $.each(subTask.unitVolunteers, function (i, volunteer) {
        var option = $("<option></option>");
        option.val(volunteer.id);
        option.text(volunteer.name + ' ' + volunteer.last_name);

        optgroup.append(option);
        $('#sub_volunteers').append(optgroup);
    });

    //add the cta_volunteers
    var notInPlatformOptgroup = $('<optgroup>');
    var notInUnitOptgroup = $('<optgroup>');
    notInPlatformOptgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');
    notInUnitOptgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');

    $.each(subTask.work_dates, function (i, date) {
        $.each(date.cta_volunteers, function (i, volunteer) {
            var option = $("<option></option>");
            option.val(volunteer.id);
            option.text(volunteer.name + ' ' + volunteer.last_name);

            var isInUnit = false;
            $.each(cta.volunteer.units, function (i, unit) {
                if (unitId == unit.id) {
                    isInUnit = true;
                    return false;
                }
            });

            if (volunteer.isVolunteer)
                notInPlatformOptgroup.append(option);
            if (volunteer.isInUnit)
                notInUnitOptgroup.append(option);

            $('#sub_volunteers').append(optgroup);
        });
    });


    refreshDateTime();

    //show modal
    $('#addWorkDate').modal('show');
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

//delete a workDate row
$(document.body).on('click', 'a.deleteWorkDate', function () {
    $(this).parent().parent().remove();
});


//remove the extra rows that hold the work dates/hours info
//from the table, when the modal is closed
$('#editSubTask').on('hidden.bs.modal', function () {
    $("#editSubTask .workDates tr.toRemove").remove();
});


//add another editable fields to fill in work date and hours
function addWorkDate(parentId) {

    if (validateWorkTable(parentId)) {
        $(".workError").show();
    }
    else {
        $(".workError").hide();
        $(parentId + " .workDates tr:last").clone().find("input").each(function () {
            $(this).val('');
        }).end().appendTo(parentId + " .workDates");

        refreshDateTime();
    }
}

/* show the task info at the side div */
function showTaskInfo(taskId) {
    //fetch the task data to show in the sidebar
    $.when(getTask(taskId))
        .then(function () {

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

            $(".subTaskInfo").hide();
            $(".taskInfo").show();

        });
}


/* show the subtask info at the side div */
function showSubTaskInfo(subTaskId) {

    $.when(getSubtask(subTaskId))
        .then(function () {
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


            //add the work dates
            html = '';
            if (subTask.work_dates.length == 0)
                html = '<p><em>Δεν έχει οριστεί χρονοδιάγραμμα</em></p>';
            else {
                $.each(subTask.work_dates, function (i, date) {
                    html += '<p><strong>' + date.comments + '</strong><br/>';
                    if (date.from_date != null)
                        html += date.from_date + ', ' + date.from_hour + '-' + date.to_hour + '</strong><br/>';

                    if (date.from_hour != null)
                        html += ',' + date.from_hour;
                    if (date.to_hour != null)
                        html += ',' + date.to_hour;

                    html += (date.comments == null || date.comments == '' ? '' : date.comments + '<br/>');
                    html += (date.volunteer_sum == null ? '' : date.volunteers.length + '/' + date.volunteer_sum + '') + '<br/>';
                    html += '</p>';
                });
            }

            $(".workDatesInfo").html(html);

            //add the to-do list
            html = '';
            if (subTask.checklist.length == 0)
                html = '<p><em>Δεν υπάρχουν To-Dos</em></p>';
            else {
                $.each(subTask.checklist, function (i, item) {
                    if (item.isComplete == "1")
                        icon = '<i class="fa fa-check-square-o"></i> ';
                    else
                        icon = '<i class="fa fa-square-o"></i> ';

                    html += '<p>' + icon + item.comments;
                    /*  html += '<br/><small>Δημιουργήθηκε από ' + item.created_by.name + ' στις ' + item.created_at;
                     html += ', τροποποιήθηκε από ' + item.updated_by.name + ' στις ' + item.updated_at + '</small></p>';*/
                });
            }

            $(".todo-list").html(html);

            $(".taskInfo").hide();
            $(".subTaskInfo").show();
        });
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


/* validate the work date tables, check that no row is incomplete */
function validateWorkTable(parentId) {
    var lastTr = $(parentId + " .workDates tr:last");

    if (($(lastTr).find('.datetime').attr('data-date') == null || $(lastTr).find('.datetime').attr('data-date') == '' ||
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
        },
        'minTime': '07:00',
        'timeFormat': 'H:i'
    });
}


$(".multiple").select2();
refreshDateTime();

