/**
 * Draws the unit tree (units and their actions) from /api/tree with VE.orgChart.
 *
 *   new Treewrapper({
 *       url: VE.url('/api/tree'),        // where to get the tree (JSON)
 *       container: '#treewrapper',       // where to put the hidden <ul>
 *       active: {type: 'unit'|'action', id: 1},   // node to show as active
 *       withActions: true,               // show the actions of the leaf units
 *       disabled: false,                 // true: the nodes cannot be selected
 *       create: 'unit'|'action',         // selection when creating a unit/action
 *       edit: 'user'                     // the tree of the units of a user
 *   }).init();
 *
 * When create is 'unit', a click on a node sets #parent_unit_id (and #parent_unit).
 * When create is 'action', a click on a leaf unit sets #unit_id.
 */
(function (window) {
    'use strict';

    function Treewrapper(options) {
        this.json = null;
        this.ul = null;
        this.options = Object.assign({
            url: VE.url('/api/tree'),
            container: '#treewrapper',
            chartElement: '#unitsTree',
            active: {type: null, id: null},
            withActions: true,
            disabled: false
        }, options || {});
        this.options.active = this.options.active || {type: null, id: null};
    }

    Treewrapper.prototype.init = function () {
        var self = this;
        return VE.http.get(this.options.url).then(function (data) {
            self.json = data;
            self.build();
            VE.orgChart(self.ul, self.options.chartElement, {
                chartClass: 'jOrgChart',
                nodeClick: function (node) { self.nodeClick(node); }
            });
            self.tooltips();
            return self;
        }).catch(VE.fail);
    };

    /** Select a node (only one active node), like the old jOrgChart plugin. */
    Treewrapper.prototype.nodeClick = function (node) {
        var o = this.options;
        if (o.disabled || node.classList.contains('disabled')) return;

        var chart = VE.el(o.chartElement);
        Array.prototype.forEach.call(chart.querySelectorAll('.active-node'), function (el) { el.classList.remove('active-node'); });
        node.classList.add('active-node');

        if (o.create === 'unit') {
            var description = node.querySelector('.description');
            var parentUnit = document.getElementById('parent_unit');
            var parentUnitId = document.getElementById('parent_unit_id');
            if (parentUnit) parentUnit.value = description ? description.textContent : '';
            if (parentUnitId) parentUnitId.value = node.getAttribute('data-id');
        } else if (o.create === 'action' && node.classList.contains('leaf')) {
            var unitId = document.getElementById('unit_id');
            if (unitId) unitId.value = node.getAttribute('data-id');
        }
    };

    /** Tooltips that explain why a node cannot be selected. */
    Treewrapper.prototype.tooltips = function () {
        var chart = VE.el(this.options.chartElement);
        [['.node.tooltips.notAssigned.disabled', 'js-components.notUserUnit'],
            ['.node.tooltips.parent.hasUnits.disabled', 'js-components.hasUnits'],
            ['.node.tooltips.leaf.hasActions.disabled', 'js-components.hasActions']].forEach(function (pair) {
            Array.prototype.forEach.call(chart.querySelectorAll(pair[0]), function (node) {
                node.setAttribute('title', Lang.get(pair[1]));
                node.setAttribute('data-toggle', 'tooltip');
                node.setAttribute('data-placement', 'bottom');
            });
        });
        VE.tooltips(chart);
    };

    /** Build the hidden nested <ul> of the tree. */
    Treewrapper.prototype.build = function () {
        this.ul = document.createElement('ul');
        this.ul.id = 'tree';
        this.ul.style.display = 'none';

        var rootLi = this.item(this.json.description, this.defineClasses(this.json, 'unit'), this.json.id);
        rootLi.appendChild(this.drawBranch(this.json));
        this.ul.appendChild(rootLi);

        var container = VE.el(this.options.container);
        if (container) container.appendChild(this.ul);
    };

    Treewrapper.prototype.item = function (text, classes, id) {
        var li = document.createElement('li');
        li.textContent = text;
        classes = classes.trim();
        if (classes) li.className = classes;
        li.setAttribute('data-id', id);
        return li;
    };

    /** The recursive function that draws all the lis needed. */
    Treewrapper.prototype.drawBranch = function (parent) {
        var self = this;
        var ul = document.createElement('ul');

        (parent.all_children || []).forEach(function (child) {
            var li = self.item(child.description, self.defineClasses(child, 'unit'), child.id);

            if (child.all_children.length > 0) {
                li.appendChild(self.drawBranch(child));
            } else {
                li.classList.add('leaf');
                if (child.actions.length > 0 && self.options.withActions) {
                    var actionUl = document.createElement('ul');
                    child.actions.forEach(function (action) {
                        actionUl.appendChild(self.item(action.description, 'action ' + self.defineClasses(action, 'action'), child.id));
                    });
                    li.appendChild(actionUl);
                }
            }
            ul.appendChild(li);
        });
        return ul;
    };

    /**
     * Define the classes that the li should have.
     * For example, when creating a unit,
     * we should show only the units that the user has permission to edit
     * and do not have actions.
     */
    Treewrapper.prototype.defineClasses = function (node, type) {
        var o = this.options;
        var classString = '';

        if (o.create === 'unit') {
            // disable the not permitted units and the units that have actions
            classString += 'tooltips ';
            if (!node.permitted)
                classString += 'disabled notPermitted ';
            else if (node.all_actions && node.all_actions.length > 0)
                classString += 'disabled hasActions ';
        } else if (o.create === 'action') {
            // disable the not permitted units and the units that have subunits
            classString += 'tooltips ';
            if (!node.permitted)
                classString += 'disabled notPermitted ';
            else if (node.all_children && node.all_children.length > 0)
                classString += 'disabled hasUnits ';
        } else if (o.edit === 'user') {
            // disable the not permitted units and show as active
            // the units that the user is assigned to
            classString += 'tooltips ';
            if (!node.permitted && !o.disabled)
                classString += 'disabled notPermitted ';
            if (node.active != null && node.active)
                classString += 'active-node assignTo ';
            if (node.disabled != null && node.disabled)
                classString += 'active-node disabled ';
        }

        // the current unit/action is active
        if (o.active.type && o.active.type === type && String(node.id) === String(o.active.id))
            classString += 'active-node ';

        return classString;
    };

    window.Treewrapper = Treewrapper;
})(window);
