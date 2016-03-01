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

            //fill the workDates table
            //and the cta volunteers
            $.each(subTask.work_dates, function (i, date) {

                var clone = $("#editSubTask .workDates tr:last").clone().find("input, select, textarea").each(function () {

                    var name = $(this).attr('name');

                    if (name == "workDates[ids][]")
                        $(this).val(date.id);
                    else if (name == "workDates[dates][]")
                        $(this).val(date.from_date);
                    else if (name == "workDates[hourFrom][]")
                        $(this).val(date.from_hour);
                    else if (name == "workDates[hourTo][]")
                        $(this).val(date.to_hour);
                    else if (name == "workDates[volunteerSum][]")
                        $(this).val(date.volunteer_sum);
                    else if (name == "workDates[subtaskVolunteers][]")
                    //TODO: check this
                        $(this).val('aaaa');
                    else if (name == "workDates[comments][]")
                        $(this).val(date.comments);
                }).end();

                $(clone).find('.deleteWorkDate').append('<a href="javascript:void(0);" class="deleteWorkDate"><i class="fa fa-times"></i></a>');
                $(clone).addClass('toRemove').insertBefore("#editSubTask .workDates  tr:last");

                var html = '';
                //also display the interested volunteers
                $.each(date.cta_volunteers, function (i, cta) {
                    html = ''
                    //volunteers is in platform
                    if (cta.isVolunteer == 1) {
                        html += '<a href="' + $("body").attr('data-url') + '/volunteers/one/' + cta.volunteer.id + '" target="_blank">' + cta.first_name + ' ' + cta.last_name + '</a>';
                        //check if the volunteer is in the action's unit
                        var unitId = $("#actionId").attr('data-unit-id');
                        var isInUnit = false;
                        $.each(cta.volunteer.units, function (i, unit) {
                            if (unitId == unit.id) {
                                isInUnit = true;
                                return false;
                            }
                        });

                        if(isInUnit)
                            html += ' <i class="fa fa-heart" ></i> assign somehow';

                        else
                            html += ' <i class="fa fa-question-circle" title="Ο εθελοντής δεν ανήκει στη μονάδα της δράσης. Επικοινωνήστε με τον υπεύθυνο μονάδας."></i>';

                    }
                    else {
                        //volunteers isn't in platform
                        html += cta.first_name + ' ' + cta.last_name + ', <a href="mailto:' + cta.email + '">' + cta.email + '</a>';
                        html += ' <i class="fa fa-question-circle" title="Ο εθελοντής δεν υπάρχει στην πλατφόρμα. Δημιουργήστε το προφίλ του για να μπορέσετε να τον αναθέσετε στη δράση."></i>';
                    }
                    html += '<br/>';
                    $(clone).find('.ctaVolunteers').append(html);
                });
            });

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
                deleteToDoItem($(this).attr('data-id'))
                $(this).parent().remove();
            });

            refreshDateTime();

            //show modal
            $('#editSubTask .todos').show();
            $('#editSubTask').modal('show');
        });
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
                    html += '<p><strong>' + date.from_date + ', ' + date.from_hour + '-' + date.to_hour + '</strong><br/>';
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
