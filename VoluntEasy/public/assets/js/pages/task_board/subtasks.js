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

            //add the checklist items
            html = '';
            $.each(subTask.checklist, function (i, item) {
                html += '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '">';
                html += '<span class="todo-description">' + item.comments + '</span>';
                if (item.isComplete == 1)
                    html += '<span class="created_updated"><small>' + Lang.get('js-components.todoDone', {
                        user: item.updated_by.name,
                        date: item.updated_at
                    })
                +'</small></span>';
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
            $(".subTaskInfo .due_date").text(subTask.due_date == null ? '-' : subTask.due_date);
            $(".subTaskInfo .name").text(subTask.name);
            $(".subTaskInfo .description").text(subTask.description == null || subTask.description == '' ? '-' : subTask.description);

            $(".subTaskInfo .editSubTask").attr('data-subtask-id', subTask.id);
            $(".subTaskInfo .editSubTask").attr('data-task-id', subTask.task_id);
            $(".subTaskInfo .deleteSubTask").attr('data-subtask-id', subTask.id);

            if (subTask.priority == 1)
                $(".subTaskInfo .priority").text(Lang.get('js-components.low'));
            if (subTask.priority == 2)
                $(".subTaskInfo .priority").text(Lang.get('js-components.medium'));
            if (subTask.priority == 3)
                $(".subTaskInfo .priority").text(Lang.get('js-components.high'));
            if (subTask.priority == 4)
                $(".subTaskInfo .priority").text(Lang.get('js-components.urgent'));

            $(".subTaskInfo .priority").attr('data-priority', subTask.priority);

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


            //add the to-do list
            html = '';
            if (subTask.checklist.length == 0)
                html = '<p><em>' + Lang.get('js-components.noToDos') + '</em></p>';
            else {
                $.each(subTask.checklist, function (i, item) {
                    if (item.isComplete == "1")
                        icon = '<i class="fa fa-check-square-o"></i> ';
                    else
                        icon = '<i class="fa fa-square-o"></i> ';

                    html += '<p>' + icon + item.comments;
                    if (item.isComplete == 1)
                        html += '<span class="created_updated"><small>' + Lang.get('js-components.todoDone', {
                            user: item.updated_by.name,
                            date: item.updated_at
                        })
                    +'</small></span>';
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
