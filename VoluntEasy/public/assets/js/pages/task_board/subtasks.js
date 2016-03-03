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
                reloadToTab('task_board');
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
                reloadToTab('task_board');
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


//delete a subtask
$(".deleteSubTask").click(function () {
    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το subtask;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/delete/" + $(this).attr('data-subtask-id'),
            success: function (result) {
                reloadToTab('task_board');
            }
        });
    }
});


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
            if (subTask.work_dates.length == 0) {
                html = '<p><em>Δεν έχει οριστεί χρονοδιάγραμμα</em></p>';
                $('.workDatesTable').hide();
            }
            else {
                $.each(subTask.work_dates, function (i, date) {

                    html += '<tr><td>' + date.comments + '</td>';
                    if (date.from_date != null)
                        html += '<td>' + date.from_date + '</td>';
                    else
                        html += '<td>-</td>';
                    if (date.from_hour != null && date.to_hour != null)
                        html += '<td>' + date.from_hour + '-' + date.to_hour + '</td>';
                    else if (date.from_hour != null)
                        html += '<td>date.from_hour</td>';
                    else
                        html += '<td>-</td>';
                    if (date.volunteer_sum != null)
                        html += '<td>' + date.volunteers.length + '/' + date.volunteer_sum + '</td>';
                    else
                        html += '<td>-</td>';

                    html += '<td><button class="btn btn-sm btn-success edit-btn" onclick="editWorkDate(' + date.id + ')"><i class="fa fa-edit"></i></button>';
                    html += '<button class="btn btn-sm btn-danger" onclick="deleteWorkDate(' + date.id + ')"><i class="fa fa-trash"></i></button></td>';
                    html += '</tr>';

                    $('.workDatesTable > tbody:last-child').html(html);
                    $('.workDatesTable').show();
                });
            }


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
