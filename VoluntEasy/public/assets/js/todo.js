var todo = function () {
    $('.todo-list .todo-item input').click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().parent().toggleClass('complete');
        } else {
            $(this).parent().parent().parent().toggleClass('complete');
        }

        var mode = $(this).attr('data-id');
        var item = updateToDoItem(mode, $(this).attr('data-id'), $(this).is(':checked'));
        $('.created_updated[data-id=' + item.id + '][data-mode=' + mode + ']').html();

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
        deleteToDoItem($(this).attr('data-mode'), $(this).attr('data-id'))
        $(this).parent().remove();
    });
};

todo();

//add new item to the checklist
$(".add-task").keypress(function (e) {
    if ((e.which == 13) && (!$(this).val().length == 0)) {

        var mode = $(this).attr('data-mode');
        var modeId = $(this).attr('data-mode-id');

        var html = '';
        var comments = $(this).val();
        $(this).val('');
console.log(mode);
        $.when(storeToDoItem(mode, modeId, comments)).then(function (item, textStatus, jqXHR) {

            html = '<div class="todo-item added ' + (item.isComplete == 1 ? 'complete' : '') + '"><input type="checkbox"' + (item.isComplete == 1 ? 'checked=checked' : '') + ' data-id="' + item.id + '" data-mode="' + mode + '">';

            html += '<span class="todo-description">' + item.comments + '</span>';
            html += '<span class="helper-wrapper"  data-id="' + item.id + '" data-mode="' + mode + '">'
            html += addHelper(item);
            html += '</span>';

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
function storeToDoItem(mode, modeId, comments) {

    return $.ajax({
        url: getUrl(mode) + '/store',
        method: 'GET',
        data: {
            comments: comments,
            mode_id: modeId
        }
    });
}

//update the status of a checklist item
function updateToDoItem(mode, id, isComplete) {
    return $.ajax({
        url: getUrl(mode) + '/update',
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
function deleteToDoItem(mode, id) {
    $.ajax({
        url: getUrl(mode) + '/delete',
        method: 'GET',
        data: {
            id: id
        }
    });
}

function getUrl(mode) {
    var url = '';
    if (mode == 'task')
        url = $("body").attr("data-url") + '/actions/tasks/checklist';
    else
        url = $("body").attr("data-url") + '/actions/tasks/subtasks/checklist';

    return url;
}
