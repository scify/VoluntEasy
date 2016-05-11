//populate the area that will hold the checklist items
function drawChecklist(mode) {

    var parentId = '';
    var type;

    if (mode == 'task') {
        parentId = '#taskChecklist';
        type = task;
    }
    else {
        parentId = '#subtaskChecklist';
        type = subTask;
    }

//add the checklist items
    var html = '';
    $.each(type.checklist, function (i, item) {
        html += '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '" data-mode="' + mode + '">';

        html += '<span class="todo-description">' + item.comments + '</span>';
        html += '<span class="helper-wrapper"  data-id="' + item.id + '" data-mode="' + mode + '">'
        html += addHelper(item);
        html += '</span>';

        html += '<a href="javascript:void(0);" class="pull-right remove-todo-item" data-mode="' + mode + '" data-id="' + item.id + '"><i class="fa fa-times"></i></a></div>';
    });

    $(parentId + ' .todo-list').html(html);
    $(parentId + ' .todo-list .todo-item.added input').uniform();
    $(parentId + ' .todo-list .todo-item.added input').click(function () {
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

    $(parentId + ' .todo-list .todo-item.added .remove-todo-item').click(function () {
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

