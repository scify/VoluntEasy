/* Subtasks of the task board: create, view, edit, delete. Needs task_board.js. */
(function () {
    'use strict';

    var TB = window.TaskBoard;

    //get a subtask by its id
    TB.getSubtask = function (id) {
        return VE.http.get('/actions/tasks/subtasks/one/' + id).then(function (result) {
            TB.subTask = result;
            return result;
        });
    };

    //prefill the subtask fields at the edit form
    function fillSubtaskFields(subTask) {
        var form = document.getElementById('editSubTaskForm');
        TB.q('.taskId', form).value = subTask.task_id;
        TB.q('.subTaskId', form).value = subTask.id;
        TB.q('.name', form).value = subTask.name;
        TB.q('.description', form).value = subTask.description || '';
        TB.setDate(TB.q('.due_date', form), subTask.due_date);
        TB.q('.subtask-priorities', form).value = subTask.priority;
        TB.q('.deleteSubtask', form).setAttribute('data-subtask-id', subTask.id);
        TB.fillAssign(form, 'subtask', subTask);
    }

    VE.ready(function () {
        //set the task id in the "add subtask" modal
        VE.on(document, 'click', '.addSubTask', function (event, link) {
            var modal = document.getElementById('addSubTask');
            TB.qa('.taskId', modal).forEach(function (input) { input.value = link.getAttribute('data-task-id'); });
            TB.q('.subtask-priorities', modal).value = '2';
        });

        //save a subtask
        VE.on(document, 'click', '#storeSubTask', function (event) {
            event.preventDefault();
            if (!TB.checkName(document.getElementById('addSubTask'), '.subtask-name_err')) return;
            TB.post('/actions/tasks/subtasks/store', VE.formData('#createSubTask'));
        });

        //update a subtask
        VE.on(document, 'click', '#updateSubTask', function (event) {
            event.preventDefault();
            var form = document.getElementById('editSubTaskForm');
            if (!TB.checkName(form, '.subtask-name_err')) return;
            TB.post('/actions/tasks/subtasks/update', VE.formData(form));
        });

        //delete a subtask
        VE.on(document, 'click', '.deleteSubtask', function (event, button) {
            event.preventDefault();
            if (!VE.confirm(Lang.get('js-components.deleteSubtask'))) return;
            TB.post('/actions/tasks/subtasks/delete/' + button.getAttribute('data-subtask-id'));
        });

        //enable the user select or the volunteer select, depending on the radio button
        VE.on(document, 'change', '.assignToSubtask', function (event, radio) {
            TB.setAssign('subtask', radio.classList.contains('edit') ? 'edit' : 'store', radio.value);
        });

        //display all the subtask details, shifts and checklist
        VE.on(document, 'click', '.viewSubtask', function (event, card) {
            if (TB.dragging) return;
            TB.getSubtask(card.getAttribute('data-subtask')).then(function (subTask) {
                fillSubtaskFields(subTask);
                TB.drawShiftsTable('#subtaskShifts', subTask, 'subtask');
                TB.drawChecklist('subtask');
                TB.q('#viewSubtask .add-task').setAttribute('data-mode-id', subTask.id);
                VE.modal('#viewSubtask').show();
            }).catch(VE.fail);
        });
    });
})();
