var todo = function () {
    $('.todo-list .todo-item input').click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().toggleClass('complete');
        } else {
            $(this).parent().parent().parent().toggleClass('complete');
        }

        updateToDoItem($(this).attr('data-id'), $(this).is(':checked'));
    });

    $('.todo-nav .all-task').click(function () {
        $('.todo-list').removeClass('only-active');
        $('.todo-list').removeClass('only-complete');
        $('.todo-nav li.active').removeClass('active');
        $(this).addClass('active');
    });

    $('.todo-nav .active-task').click(function () {
        $('.todo-list').removeClass('only-complete');
        $('.todo-list').addClass('only-active');
        $('.todo-nav li.active').removeClass('active');
        $(this).addClass('active');
    });

    $('.todo-nav .completed-task').click(function () {
        $('.todo-list').removeClass('only-active');
        $('.todo-list').addClass('only-complete');
        $('.todo-nav li.active').removeClass('active');
        $(this).addClass('active');
    });

    $('#uniform-all-complete input').click(function () {
        if ($(this).is(':checked')) {
            $('.todo-item .checker span:not(.checked) input').click();
        } else {
            $('.todo-item .checker span.checked input').click();
        }
    });

    $('.remove-todo-item').click(function () {
        deleteToDoItem($(this).attr('data-id'))
        $(this).parent().remove();
    });
};

todo();

//add new item to the checklist
$(".add-task").keypress(function (e) {
    if ((e.which == 13) && (!$(this).val().length == 0)) {

        var html = '';
        var comments = $(this).val();
        $(this).val('');

        $.when(storeToDoItem(comments)).then(function (item, textStatus, jqXHR) {

            html = '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '">';
            html += '<span class="todo-description">' + item.comments + '</span>';
            html += '<span class="created_updated"><small>Δημιουργήθηκε από ' + item.created_by.name + ' στις ' + item.created_at;
            html += ', τροποποιήθηκε από ' + item.updated_by.name + ' στις ' + item.updated_at + '</small></span>';
            html += '<a href="javascript:void(0);" class="pull-right remove-todo-item" data-id="' + item.id + '"><i class="fa fa-times"></i></a></div>';

            if ($('.todo-list').is(':empty'))
                $(html).appendTo('.todo-list');
            else
                $(html).insertAfter('.todo-list .todo-item:last-child');

            $('.todo-list .todo-item.added input').uniform();
            $('.todo-list .todo-item.added input').click(function () {
                if ($(this).is(':checked')) {
                    $(this).parent().parent().parent().toggleClass('complete');
                } else {
                    $(this).parent().parent().parent().toggleClass('complete');
                }
            });
        });

    } else if (e.which == 13) {
        alert('Please enter new task');
    }

    $('.todo-list .todo-item.added input').uniform();
    $('.todo-list .todo-item.added input').click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().toggleClass('complete');
        } else {
            $(this).parent().parent().parent().toggleClass('complete');
        }
    });

    $('.todo-list .todo-item.added .remove-todo-item').click(function () {
        $(this).parent().remove();
    });
});


//store a new checklist item
function storeToDoItem(comments) {
    return $.ajax({
        url: $("body").attr('data-url') + "/checklist/store",
        method: 'GET',
        data: {
            comments: comments,
            subtask_id: $("#editSubTask .subTaskId").val()
        }
    });
}

//update the status of a checklist item
function updateToDoItem(id, isComplete) {

    $.ajax({
        url: $("body").attr('data-url') + "/checklist/update",
        method: 'GET',
        data: {
            id: id,
            isComplete: isComplete
        },
        success: function (data) {
            return data;
        }
    });
}

//delete an item
function deleteToDoItem(id) {
    $.ajax({
        url: $("body").attr('data-url') + "/checklist/delete",
        method: 'GET',
        data: {
            id: id
        }
    });
}