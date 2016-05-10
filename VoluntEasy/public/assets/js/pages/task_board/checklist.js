//populate the viewSubtaskChecklist modal with data before displaying it
$(".viewSubtaskChecklist").click(function (e) {

    //add the checklist items
    html = '';
    $.each(subTask.checklist, function (i, item) {
        html += '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '" data-mode="subtask">';

        html += '<span class="todo-description">' + item.comments + '</span>';
        html += '<span class="helper-wrapper"  data-id="' + item.id + '" data-mode="subtask">'
        html += addHelper(item);
        html += '</span>';

        html += '<a href="javascript:void(0);" class="pull-right remove-todo-item" data-id="' + item.id + '"><i class="fa fa-times"></i></a></div>';
    });

    $("#subtaskChecklist .todo-list").html(html);
    $('#subtaskChecklist .todo-list .todo-item.added input').uniform();
    $('#subtaskChecklist .todo-list .todo-item.added input').click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().toggleClass('complete');
        } else {
            $(this).parent().parent().parent().toggleClass('complete');
        }

        var mode = $(this).attr('data-mode');
        $.when(updateToDoItem(mode, $(this).attr('data-id'), $(this).is(':checked')))
            .then(function (item, textStatus, jqXHR) {
                $('.helper-wrapper[data-id=' + item.id + '][data-mode=' + mode + ']').html(addHelper(item));
            });
    });

    $('#subtaskChecklist .todo-list .todo-item.added .remove-todo-item').click(function () {
        deleteToDoItem($(this).attr('data-id'));
        $(this).parent().remove();
    });

    $("#subtaskChecklist .add-task").attr('data-mode-id', subTask.id);

    //show modal
    $('#subtaskChecklist').modal('show');
});


//populate the area that will hold the checklist items
function viewTaskChecklist() {

//add the checklist items
    html = '';
    $.each(task.checklist, function (i, item) {
        html += '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '" data-mode="task">';

        html += '<span class="todo-description">' + item.comments + '</span>';
        html += '<span class="helper-wrapper"  data-id="' + item.id + '" data-mode="task">'
        html += addHelper(item);
        html += '</span>';

        html += '<a href="javascript:void(0);" class="pull-right remove-todo-item" data-mode="task" data-id="' + item.id + '"><i class="fa fa-times"></i></a></div>';
    });

    $("#taskChecklist .todo-list").html(html);
    $('#taskChecklist .todo-list .todo-item.added input').uniform();
    $('#taskChecklist .todo-list .todo-item.added input').click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().toggleClass('complete');
        } else {
            $(this).parent().parent().parent().toggleClass('complete');
        }

        var mode = $(this).attr('data-mode');
        $.when(updateToDoItem(mode, $(this).attr('data-id'), $(this).is(':checked')))
            .then(function (item, textStatus, jqXHR) {
                $('.helper-wrapper[data-id=' + item.id + '][data-mode=' + mode + ']').html(addHelper(item));
            });

    });

    $('#taskChecklist .todo-list .todo-item.added .remove-todo-item').click(function () {
        deleteToDoItem($(this).attr('data-mode'), $(this).attr('data-id'));
        $(this).parent().remove();
    });
}


$(".closeAndRefresh").click(function () {
    location.reload();
});


//add helper text next to the to-do
//ie edited by user at date
function addHelper(item) {
    html = '';
    if (item.created_at === item.updated_at)
        html += '<span class="created_updated"><small>' + Lang.get('js-components.todoCreated', {
            user: item.updated_by.name,
            date: item.updated_at
        })
        + '</small></span>';
    else
        html += '<span class="created_updated"><small>' + Lang.get('js-components.todoEdited', {
            user: item.updated_by.name,
            date: item.updated_at
        })
        + '</small></span>';

    return html;
}

/*
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
 */
