/* Add a new item to the checklist of a task or subtask (actions/show). Needs task_board/checklist.js. */
VE.ready(function () {
    'use strict';

    var TB = window.TaskBoard;
    if (!TB || !TB.storeToDoItem) return;

    VE.on(document, 'keydown', '.add-task', function (event, input) {
        if (event.key !== 'Enter') return;
        event.preventDefault();

        if (input.value.length === 0) {
            alert('Please enter new task');
            return;
        }

        var mode = input.getAttribute('data-mode');
        var comments = input.value;
        var list = input.closest('.tab-pane').querySelector('.todo-list');
        input.value = '';

        TB.storeToDoItem(mode, input.getAttribute('data-mode-id'), comments).then(function (item) {
            list.insertAdjacentHTML('beforeend', TB.checklistItem(item, mode));
        }).catch(VE.fail);
    });
});
