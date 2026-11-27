/* Shifts (days and hours) of a task or subtask, with inline edit. Needs task_board.js. */
(function () {
    'use strict';

    var TB = window.TaskBoard;

    // the hours of the hour selects: 07:00, 07:30, ... 06:30
    var hours = [];
    for (var i = 0; i < 48; i++) {
        var minutes = (7 * 60 + i * 30) % (24 * 60);
        var text = String(Math.floor(minutes / 60)).padStart(2, '0') + ':' + String(minutes % 60).padStart(2, '0');
        hours.push({value: text, text: text});
    }

    //return the url for storing/updating a task shift or a subtask shift
    function shiftUrl(mode) {
        return mode === 'task' ? '/actions/tasks/shifts/' : '/actions/tasks/subtasks/shifts/';
    }

    function required(value) {
        if (String(value || '').trim() === '') return Lang.get('js-components.requiredField');
    }

    function editable(cls, type, name, value, shiftId) {
        return '<span class="' + cls + ' myeditable" data-type="' + type + '" data-name="' + name + '" data-value="' +
            VE.esc(value === null || value === undefined ? '' : value) + '" data-pk="' + VE.esc(shiftId) + '"></span>';
    }

    function drawShiftRow(shift, mode) {
        if (shift === null) {
            shift = {id: 0, comments: null, from_date: null, from_hour: null, to_hour: null, volunteer_sum: null};
        }
        var id = shift.id;
        var html = '<tr>' +
            '<td class="col-md-2">' + editable('comments', 'text', 'comments', shift.comments, id) + '</td>' +
            '<td class="col-md-2">' + editable('fromDate', 'date', 'fromDate', shift.from_date, id) + '</td>' +
            '<td class="col-md-1">' + editable('fromHour hours', 'select', 'fromHour', shift.from_hour, id) + '</td>' +
            '<td class="col-md-1">' + editable('toHour hours', 'select', 'toHour', shift.to_hour, id) + '</td>' +
            '<td class="col-md-1">' + editable('volunteerSum', 'text', 'volunteerSum', shift.volunteer_sum, id) + '</td>' +
            '<td class="col-md-3"><span class="availableVolunteers" data-pk="' + VE.esc(id) + '" data-mode="' + VE.esc(mode) + '"></span></td>';

        if (TB.isPermitted()) {
            //display the store or update button, and the delete button
            html += '<td class="col-md-2"><button type="button" class="btn btn-sm btn-success save-btn right-margin" ' +
                (id == 0 ? 'data-store-shift' : 'data-update-shift') + '="' + VE.esc(id) + '" data-mode="' + VE.esc(mode) + '">' +
                '<i class="fa fa-save"></i></button>';
            if (id != 0) {
                html += '<button type="button" class="btn btn-sm btn-danger save-btn" data-delete-shift="' + VE.esc(id) + '" ' +
                    'data-mode="' + VE.esc(mode) + '"><i class="fa fa-trash"></i></button>';
            }
            html += '</td>';
        }
        return html + '</tr>';
    }

    //the volunteers of an existing shift: a multiple select for the permitted users, else the names
    function initAvailableVolunteers(container, shift, type) {
        var cell = TB.q('.availableVolunteers[data-pk="' + shift.id + '"]', container);
        if (!cell) return;
        var assigned = (shift.volunteers || []).map(function (volunteer) {
            return {id: volunteer.id, text: volunteer.name + ' ' + volunteer.last_name};
        });

        if (!TB.isPermitted()) {
            cell.textContent = assigned.map(function (v) { return v.text; }).join(', ');
            return;
        }

        var options = (type.unitVolunteers || []).slice();
        assigned.forEach(function (volunteer) {
            if (!options.some(function (o) { return String(o.id) === String(volunteer.id); })) options.push(volunteer);
        });
        var select = document.createElement('select');
        select.multiple = true;
        select.className = 'selectAvailableVolunteers';
        var header = TB.qa('.shiftsTable th', container)[5];
        if (header) select.setAttribute('aria-label', header.textContent.trim());
        options.forEach(function (option) {
            var selected = assigned.some(function (v) { return String(v.id) === String(option.id); });
            select.appendChild(new Option(option.text, option.id, selected, selected));
        });
        cell.appendChild(select);
        VE.select(select, {placeholder: 'Select volunteers'});
    }

    function initEditables(container) {
        TB.qa('.myeditable', container).forEach(function (el) {
            var type = el.getAttribute('data-type');
            VE.editable(el, {
                type: type,
                source: type === 'select' ? hours : undefined,
                emptytext: Lang.get('js-components.empty'),
                validate: required
            });
        });
    }

    //draw the shifts table and add the inline edit fields
    TB.drawShiftsTable = function (parentId, type, mode) {
        var container = TB.q(parentId);
        var shifts = type.shifts || [];
        var html = '';

        if (shifts.length === 0) {
            html += drawShiftRow(null, mode);
        } else {
            shifts.forEach(function (shift) { html += drawShiftRow(shift, mode); });
            html += '<tr><td colspan="7" class="newShift"><strong>' + VE.esc(Lang.get('js-components.newShift')) + '</strong></td></tr>';
            html += drawShiftRow(null, mode);
        }

        TB.q('.shiftsTable > tbody:last-child', container).innerHTML = html;
        VE.hide(TB.q('#shiftError', container));
        shifts.forEach(function (shift) { initAvailableVolunteers(container, shift, type); });
        initEditables(container);
    };

    function value(container, cls, shiftId) {
        var el = TB.q('.' + cls + '[data-pk="' + shiftId + '"]', container);
        return el && el.VEEditable ? String(el.VEEditable.value() || '') : '';
    }

    //the data of a shift; the store and the update requests take the same fields
    function shiftData(container, mode, shiftId) {
        var data = {
            comments: value(container, 'comments', shiftId),
            dateFrom: value(container, 'fromDate', shiftId),
            hourFrom: value(container, 'fromHour', shiftId),
            hourTo: value(container, 'toHour', shiftId),
            volunteerSum: value(container, 'volunteerSum', shiftId)
        };
        if (mode === 'task') data.taskId = TB.task.id; else data.subtaskId = TB.subTask.id;

        if (shiftId != 0) {
            var select = TB.q('.availableVolunteers[data-pk="' + shiftId + '"] select', container);
            data.shiftId = shiftId;
            data.volunteers = select ? Array.prototype.filter.call(select.options, function (o) { return o.selected; })
                .map(function (o) { return o.value; }).join(',') : '';
            data.action_id = TB.actionId();
        }
        return data;
    }

    //store a new shift or update a shift
    function saveShift(button, shiftId, action) {
        var container = button.closest('.tab-pane');
        var mode = button.getAttribute('data-mode');
        var data = shiftData(container, mode, shiftId);
        var error = TB.q('#shiftError', container);

        if (!data.comments || !data.dateFrom || !data.volunteerSum) {
            VE.show(error);
            return;
        }
        VE.hide(error);
        TB.post(shiftUrl(mode) + action, data);
    }

    VE.ready(function () {
        VE.on(document, 'click', '[data-store-shift]', function (event, button) {
            saveShift(button, 0, 'store');
        });

        VE.on(document, 'click', '[data-update-shift]', function (event, button) {
            saveShift(button, button.getAttribute('data-update-shift'), 'update');
        });

        //delete a shift
        VE.on(document, 'click', '[data-delete-shift]', function (event, button) {
            if (!VE.confirm(Lang.get('js-components.deleteShift'))) return;
            TB.post(shiftUrl(button.getAttribute('data-mode')) + 'delete/' + button.getAttribute('data-delete-shift'),
                {action_id: TB.actionId()});
        });
    });
})();
