/*!
 * Behaviour of the "modern" admin theme without jQuery (replaces modern.js):
 * sidebar menus, panel controls, push menu, page height, tooltips and the
 * shared form widgets (date pickers, default user image).
 */
VE.ready(function () {
    'use strict';

    // Tooltips
    VE.tooltips(document);

    // Panel controls
    VE.on(document, 'click', '.panel-collapse', function (event, button) {
        event.preventDefault();
        var body = button.closest('.panel').querySelector(':scope > .panel-body');
        if (body) VE.toggle(body);
    });
    VE.on(document, 'click', '.panel-reload', function (event, button) {
        event.preventDefault();
        var body = button.closest('.panel').querySelector(':scope > .panel-body');
        VE.block(body);
        setTimeout(function () { VE.unblock(body); }, 1000);
    });
    VE.on(document, 'click', '.panel-remove', function (event, button) {
        event.preventDefault();
        VE.hide(button.closest('.panel'));
    });

    // Push menu (small screens)
    VE.on(document, 'click', '.push-sidebar', function (event) {
        event.preventDefault();
        var sidebar = document.querySelector('.sidebar');
        var visible = sidebar.classList.toggle('visible');
        VE.$$('.page-inner').forEach(function (el) { el.classList.toggle('sidebar-visible', visible); });
    });

    // Sidebar accordion menu: one open sub menu at a time
    VE.$$('.sidebar .accordion-menu li .sub-menu').forEach(function (sub) {
        sub.style.display = sub.parentNode.classList.contains('open') && !document.body.classList.contains('small-sidebar') ? 'block' : 'none';
    });
    VE.on(document, 'click', '.sidebar .accordion-menu li.droplink > a', function (event, link) {
        var body = document.body.classList;
        if (body.contains('small-sidebar') || body.contains('page-horizontal-bar') || body.contains('hover-menu')) return;
        var sub = link.nextElementSibling;
        if (!sub || !sub.classList.contains('sub-menu')) return;
        event.preventDefault();
        var item = link.parentNode;
        var open = sub.style.display !== 'none';
        Array.prototype.forEach.call(item.parentNode.children, function (sibling) {
            sibling.classList.remove('open');
            var siblingSub = sibling.querySelector(':scope > .sub-menu');
            if (siblingSub) siblingSub.style.display = 'none';
        });
        if (!open) {
            item.classList.add('open');
            sub.style.display = 'block';
        }
        sidebarAndContentHeight();
    });

    // The content is at least as high as the sidebar
    function sidebarAndContentHeight() {
        var content = document.querySelector('.page-inner');
        var sidebar = document.querySelector('.page-sidebar');
        if (!content || !sidebar) return;
        var footer = document.querySelector('.page-footer');
        var height = sidebar.offsetHeight + (footer ? footer.offsetHeight : 0);
        if (!document.body.classList.contains('page-sidebar-fixed')) height = Math.max(height, window.innerHeight);
        content.style.setProperty('min-height', Math.max(height, sidebar.offsetHeight) + 'px', 'important');
    }
    sidebarAndContentHeight();
    window.addEventListener('resize', sidebarAndContentHeight);

    // Date fields: start date before end date
    VE.dateRange('.startDate', '.endDate');

    // Default user image
    VE.$$('img.userImage').forEach(function (img) {
        img.addEventListener('error', function () { img.src = VE.url('/assets/images/default.png'); }, {once: true});
    });

    // Tooltips of the unit tree
    [['.node.tooltips.notAssigned.disabled', 'js-components.notUserUnit'],
        ['.node.tooltips.parent.hasUnits.disabled', 'js-components.hasUnits'],
        ['.node.tooltips.leaf.hasActions.disabled', 'js-components.hasActions']].forEach(function (pair) {
        VE.$$(pair[0]).forEach(function (node) {
            node.setAttribute('title', Lang.get(pair[1]));
            node.setAttribute('data-placement', 'bottom');
            new window.Tooltip(node, {placement: 'bottom', container: document.body});
        });
    });
});
