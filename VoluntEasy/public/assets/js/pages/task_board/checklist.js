/* Checklist (to-do items) of a task or subtask. Needs task_board.js. */
(function () {
    'use strict';

    var TB = window.TaskBoard;

    function checklistUrl(mode) {
        return mode === 'task' ? '/actions/tasks/checklist' : '/actions/tasks/subtasks/checklist';
    }

    TB.storeToDoItem = function (mode, modeId, comments) {
        return VE.http.post(checklistUrl(mode) + '/store', {comments: comments, mode_id: modeId});
    };

    TB.updateToDoItem = function (mode, id, isComplete) {
        return VE.http.post(checklistUrl(mode) + '/update', {id: id, isComplete: isComplete ? 'true' : 'false'});
    };

    TB.deleteToDoItem = function (mode, id) {
        return VE.http.post(checklistUrl(mode) + '/delete', {id: id});
    };

    //helper text next to the to-do, ie edited by user at date
    TB.addHelper = function (item) {
        var key = item.created_at === item.updated_at ? 'js-components.todoCreated' : 'js-components.todoEdited';
        var text = Lang.get(key, {
            user: item.updated_by ? item.updated_by.name : '',
            date: item.updated_at
        });
        return '<span class="created_updated"><small>' + VE.esc(text) + '</small></span>';
    };

    //the html of one checklist item
    TB.checklistItem = function (item, mode) {
        var complete = item.isComplete == 1;
        return '<div class="todo-item added' + (complete ? ' complete' : '') + '">' +
            '<input type="checkbox"' + (complete ? ' checked' : '') + ' data-id="' + VE.esc(item.id) + '" data-mode="' + VE.esc(mode) + '"> ' +
            '<span class="todo-description">' + VE.esc(item.comments) + '</span>' +
            '<span class="helper-wrapper" data-id="' + VE.esc(item.id) + '" data-mode="' + VE.esc(mode) + '">' + TB.addHelper(item) + '</span>' +
            '<a href="javascript:void(0);" class="pull-right remove-todo-item" data-mode="' + VE.esc(mode) + '" data-id="' + VE.esc(item.id) + '">' +
            '<i class="fa fa-times"></i></a></div>';
    };

    //populate the area that holds the checklist items
    TB.drawChecklist = function (mode) {
        var parentId = mode === 'task' ? '#taskChecklist' : '#subtaskChecklist';
        var type = mode === 'task' ? TB.task : TB.subTask;
        TB.q(parentId + ' .todo-list').innerHTML = (type.checklist || []).map(function (item) {
            return TB.checklistItem(item, mode);
        }).join('');
    };

    VE.ready(function () {
        //mark an item as complete or not
        VE.on(document, 'change', '.todo-list .todo-item input[type=checkbox]', function (event, input) {
            var mode = input.getAttribute('data-mode');
            input.closest('.todo-item').classList.toggle('complete', input.checked);
            TB.updateToDoItem(mode, input.getAttribute('data-id'), input.checked).then(function (item) {
                TB.qa('.helper-wrapper[data-mode="' + mode + '"]').forEach(function (wrapper) {
                    if (wrapper.getAttribute('data-id') == item.id) wrapper.innerHTML = TB.addHelper(item);
                });
            }).catch(VE.fail);
        });

        //delete an item
        VE.on(document, 'click', '.todo-list .todo-item .remove-todo-item', function (event, link) {
            event.preventDefault();
            TB.deleteToDoItem(link.getAttribute('data-mode'), link.getAttribute('data-id')).catch(VE.fail);
            link.closest('.todo-item').remove();
        });
    });
})();
