/* Tasks of the task board: create, view, edit, delete. Needs task_board.js. */
(function () {
    'use strict';

    var TB = window.TaskBoard;

    //get a task by its id
    TB.getTask = function (id) {
        return VE.http.get('/actions/tasks/one/' + id).then(function (result) {
            TB.task = result;
            return result;
        });
    };

    //prefill the task fields at the edit form
    function fillTaskFields(task) {
        var form = document.getElementById('editTaskForm');
        TB.qa('.taskId', form).forEach(function (input) { input.value = task.id; });
        TB.setDate(TB.q('.due_date', form), task.due_date);
        TB.q('.name', form).value = task.name;
        TB.q('.description', form).value = task.description || '';
        TB.q('.priorities', form).value = task.priority;
        TB.q('#updateTask', form).setAttribute('data-task-id', task.id);
        TB.q('.deleteTask', form).setAttribute('data-task-id', task.id);
        TB.fillAssign(form, 'task', task);
    }

    VE.ready(function () {
        //save a task
        VE.on(document, 'click', '#storeTask', function (event) {
            event.preventDefault();
            var form = document.getElementById('createTask');
            if (!TB.checkName(document.getElementById('addTask'), '.name_err')) return;
            TB.post('/actions/tasks/store', VE.formData(form));
        });

        //update a task
        VE.on(document, 'click', '#updateTask', function (event) {
            event.preventDefault();
            var form = document.getElementById('editTaskForm');
            if (!TB.checkName(form, '.name_err')) return;
            TB.post('/actions/tasks/update', VE.formData(form));
        });

        //delete a task
        VE.on(document, 'click', '.deleteTask', function (event, button) {
            event.preventDefault();
            if (!VE.confirm(Lang.get('js-components.deleteTask'))) return;
            TB.post('/actions/tasks/delete/' + button.getAttribute('data-task-id'));
        });

        //enable the user select or the volunteer select, depending on the radio button
        VE.on(document, 'change', '.assignToTask', function (event, radio) {
            TB.setAssign('task', radio.classList.contains('edit') ? 'edit' : 'store', radio.value);
        });

        //display all the task details, shifts and checklist
        VE.on(document, 'click', '.viewTask', function (event, link) {
            event.preventDefault();
            TB.getTask(link.getAttribute('data-task-id')).then(function (task) {
                fillTaskFields(task);
                TB.drawShiftsTable('#taskShifts', task, 'task');
                TB.drawChecklist('task');
                TB.q('#viewTask .add-task').setAttribute('data-mode-id', task.id);
                VE.modal('#viewTask').show();
            }).catch(VE.fail);
        });
    });
})();
