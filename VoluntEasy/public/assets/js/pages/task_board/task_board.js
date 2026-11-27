/* General scripts of the task board (actions/show). Shared state and helpers are in window.TaskBoard. */
(function () {
    'use strict';

    var TB = window.TaskBoard = window.TaskBoard || {};

    // querySelector / querySelectorAll (array) in a context
    TB.q = function (selector, context) { return (context || document).querySelector(selector); };
    TB.qa = function (selector, context) { return Array.prototype.slice.call((context || document).querySelectorAll(selector)); };

    // the task and subtask that are open in the modals
    TB.task = null;
    TB.subTask = null;

    TB.actionId = function () {
        var el = document.getElementById('actionId');
        return el ? el.getAttribute('data-action-id') : null;
    };

    TB.isPermitted = function () {
        var el = document.getElementById('actionId');
        return !!el && el.getAttribute('data-is-permitted') === 'true';
    };

    // localStorage can be blocked: the page must work without it
    TB.storage = {
        get: function (key) {
            try { return window.localStorage.getItem(key); } catch (e) { return null; }
        },
        set: function (key, value) {
            try { window.localStorage.setItem(key, value); } catch (e) { /* ignore */ }
        }
    };

    TB.priorityText = function (priority) {
        return {
            1: Lang.get('js-components.low'),
            2: Lang.get('js-components.medium'),
            3: Lang.get('js-components.high'),
            4: Lang.get('js-components.urgent')
        }[priority] || '';
    };

    // date inputs (dd/mm/yyyy) limited to the dates of the action
    TB.initDates = function (root) {
        TB.qa('input.date', root || document).forEach(function (input) {
            VE.datepicker(input, {
                minDate: input.getAttribute('data-date-start-date') || null,
                maxDate: input.getAttribute('data-date-end-date') || null
            });
        });
    };

    TB.setDate = function (input, value) {
        if (!input) return;
        if (input._flatpickr) {
            input._flatpickr.setDate(value || null, false, 'd/m/Y');
        } else {
            input.value = value || '';
        }
    };

    /**
     * The radio buttons "assign to user / volunteer" enable one of the two selects.
     * prefix: "task" or "subtask"; mode: "store" or "edit".
     */
    TB.setAssign = function (prefix, mode, value) {
        TB.qa('.' + prefix + 'UserSelect.' + mode).forEach(function (select) { select.disabled = value !== 'user'; });
        TB.qa('.' + prefix + 'VolunteerSelect.' + mode).forEach(function (select) { select.disabled = value !== 'volunteer'; });
    };

    /** Prefill the assignment fields of an edit form with the user or volunteer of the item. */
    TB.fillAssign = function (form, prefix, item) {
        var radioName = prefix === 'task' ? 'assignToTask' : 'assignToSubtask';
        var userRadio = TB.q('input[type=radio][name=' + radioName + '][value=user]', form);
        var volunteerRadio = TB.q('input[type=radio][name=' + radioName + '][value=volunteer]', form);
        var userSelect = TB.q('.' + prefix + 'UserSelect', form);
        var volunteerSelect = TB.q('.' + prefix + 'VolunteerSelect', form);
        var hasUser = item.users && item.users.length > 0;
        var hasVolunteer = item.volunteers && item.volunteers.length > 0;

        if (userRadio) userRadio.checked = hasUser;
        if (volunteerRadio) volunteerRadio.checked = hasVolunteer;
        if (userSelect) {
            userSelect.disabled = !hasUser || hasVolunteer;
            userSelect.value = hasUser ? item.users[0].id : (userSelect.options[0] ? userSelect.options[0].value : '');
        }
        if (volunteerSelect) {
            volunteerSelect.disabled = !hasVolunteer;
            volunteerSelect.value = hasVolunteer ? item.volunteers[0].id : (volunteerSelect.options[0] ? volunteerSelect.options[0].value : '');
        }
    };

    /** Show the error text when the name field is empty. Returns true when the name is filled. */
    TB.checkName = function (form, errorSelector) {
        var name = TB.q('.name', form);
        var error = TB.q(errorSelector, form);
        var ok = !!(name && name.value);
        if (error) VE.toggle(error, !ok);
        return ok;
    };

    TB.post = function (url, data) {
        return VE.http.post(url, data).then(function () { location.reload(); }).catch(VE.fail);
    };

    var statusTexts = {todo: 'TO DO', doing: 'DOING', done: 'DONE'};

    // drag and drop of the subtask cards between the status columns of a task
    function initBoard() {
        if (!TB.isPermitted()) {
            TB.qa('.board-card').forEach(function (card) { card.style.cursor = 'not-allowed'; });
            return;
        }

        TB.qa('.board-row').forEach(function (row, index) {
            TB.qa('.board-column', row).forEach(function (column) {
                new Sortable(column, {
                    group: 'board-' + index,
                    animation: 150,
                    ghostClass: 'ui-state-highlight',
                    onStart: function () { TB.dragging = true; },
                    onEnd: function (event) {
                        setTimeout(function () { TB.dragging = false; }, 50);
                        if (event.from === event.to) return;

                        var card = event.item;
                        var taskId = card.getAttribute('data-task');
                        var status = event.to.classList.contains('todo') ? 'To Do' :
                            (event.to.classList.contains('doing') ? 'Doing' : 'Done');

                        VE.http.post('/actions/tasks/subtasks/updateStatus', {
                            action_id: TB.actionId(),
                            task_id: taskId,
                            subTaskId: card.getAttribute('data-subtask'),
                            status: status
                        }).then(function (result) {
                            result = String(result).trim();
                            TB.qa('span.status.task-' + taskId).forEach(function (span) {
                                span.className = 'status task-' + taskId + ' ' + result;
                                span.textContent = statusTexts[result] || statusTexts.done;
                            });
                        }).catch(VE.fail);
                    }
                });
            });
        });
    }

    // bootstrap.native needs an active tab to switch from: the first time, set it directly
    function showTab(link) {
        var nav = link.closest('.nav');
        if (nav && nav.querySelector('li.active')) {
            link.click();
            return;
        }
        var pane = document.querySelector(link.getAttribute('href'));
        link.parentNode.classList.add('active');
        link.setAttribute('aria-expanded', 'true');
        if (pane) pane.classList.add('active', 'in');
    }

    VE.ready(function () {
        initBoard();
        TB.initDates(document);

        // remember the open task. Capture phase: read the state before the collapse changes it.
        document.addEventListener('click', function (event) {
            var title = event.target.closest ? event.target.closest('.task-title') : null;
            if (!title) return;
            var panel = document.querySelector(title.getAttribute('href'));
            var isOpen = panel && panel.classList.contains('in');
            TB.storage.set('openTask', isOpen ? null : title.getAttribute('data-task-id'));
        }, true);

        // remember the open tab
        VE.on(document, 'click', 'li.tab', function (event, li) {
            TB.storage.set('openTab', li.getAttribute('data-tab'));
        });

        // open the last opened tab and task again
        var tabId = TB.storage.get('openTab');
        var tabLink = (tabId && document.querySelector('.tab a.' + CSS.escape(tabId))) || document.querySelector('.tab a.details');
        if (tabLink) showTab(tabLink);

        var taskId = TB.storage.get('openTask');
        var taskLink = taskId && taskId !== 'null' ? document.querySelector('.task-title.task-' + CSS.escape(taskId)) : null;
        if (taskLink) taskLink.click();
    });
})();
