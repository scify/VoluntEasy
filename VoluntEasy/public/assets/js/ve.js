/*!
 * VoluntEasy front-end helpers (no jQuery).
 *
 * Needs: bootstrap.native (Bootstrap 3 components), Tom Select, flatpickr,
 * messages.js (the global "Lang"). Everything is in the global "VE".
 *
 *   VE.ready(fn)                      run fn when the DOM is ready
 *   VE.$(sel, ctx) / VE.$$(sel, ctx)  querySelector / querySelectorAll (array)
 *   VE.on(root, event, selector, fn)  delegated event; fn(event, matchedElement)
 *   VE.esc(value)                     escape a value for HTML (use it in all renderers!)
 *   VE.url('/api/x')                  absolute URL of the application
 *   VE.http.get/post/postForm         fetch with the CSRF token; JSON or text
 *   VE.table(el, options)             DataTables-like table (see VE.Table)
 *   VE.modal(el)                      Bootstrap 3 modal: .show() / .hide()
 *   VE.select(el, options)            Tom Select (replaces select2)
 *   VE.datepicker / VE.timepicker / VE.dateRange
 *   VE.stars(el, options)             star rating (replaces raty)
 *   VE.editable(el, options)          inline edit (replaces x-editable)
 *   VE.wizard(el, options)            tab wizard (replaces bootstrapWizard)
 *   VE.orgChart(list, target, opts)   org chart of a nested <ul> (replaces jOrgChart)
 *   VE.autocomplete(input, url)       suggestions from url?term=...
 *   VE.toast(message, type)           notification (replaces toastr)
 *   VE.block(el) / VE.unblock(el)     "loading" overlay (replaces blockUI)
 *   VE.tooltips(root)                 init Bootstrap tooltips in new content
 *   VE.confirm(message)               window.confirm
 */
(function (window, document) {
    'use strict';

    var VE = window.VE = {};

    /* ------------------------------------------------------------------ DOM */

    VE.ready = function (fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    };

    function element(target) {
        return typeof target === 'string' ? document.querySelector(target) : target;
    }
    VE.el = element;

    VE.$ = function (selector, context) {
        return (context || document).querySelector(selector);
    };

    VE.$$ = function (selector, context) {
        return Array.prototype.slice.call((context || document).querySelectorAll(selector));
    };

    /**
     * Delegated event: VE.on(document, 'click', '.delete', function (event, button) {...}).
     * Without a selector: VE.on(element, 'click', function (event, element) {...}).
     */
    VE.on = function (root, type, selector, handler) {
        root = element(root);
        if (!root) return;
        if (typeof selector === 'function') {
            handler = selector;
            selector = null;
        }
        type.split(' ').forEach(function (eventType) {
            root.addEventListener(eventType, function (event) {
                if (!selector) {
                    handler.call(root, event, root);
                    return;
                }
                var match = event.target.closest ? event.target.closest(selector) : null;
                if (match && root.contains(match)) {
                    handler.call(match, event, match);
                }
            });
        });
    };

    VE.esc = function (value) {
        return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function (c) {
            return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c];
        });
    };

    VE.show = function (target) { VE.each(target, function (el) { el.style.display = ''; if (getComputedStyle(el).display === 'none') el.style.display = 'block'; }); };
    VE.hide = function (target) { VE.each(target, function (el) { el.style.display = 'none'; }); };
    VE.toggle = function (target, visible) {
        VE.each(target, function (el) {
            var show = visible === undefined ? getComputedStyle(el).display === 'none' : visible;
            if (show) VE.show(el); else VE.hide(el);
        });
    };
    VE.each = function (target, fn) {
        if (!target) return;
        if (typeof target === 'string') target = VE.$$(target);
        if (target instanceof Element) target = [target];
        Array.prototype.forEach.call(target, fn);
    };

    /** Parse an HTML string into a DocumentFragment. */
    VE.html = function (html) {
        var template = document.createElement('template');
        template.innerHTML = html;
        return template.content;
    };

    VE.confirm = function (message) {
        return window.confirm(message);
    };

    /* ----------------------------------------------------------------- HTTP */

    VE.base = function () {
        return (document.body && document.body.getAttribute('data-url')) || '';
    };

    VE.url = function (path) {
        if (/^https?:\/\//.test(path)) return path;
        return VE.base().replace(/\/$/, '') + '/' + String(path).replace(/^\//, '');
    };

    VE.csrfToken = function () {
        var meta = document.querySelector('meta[name="_token"], meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    };

    /** The fields of a form as URLSearchParams (like jQuery serialize()). */
    VE.formData = function (form) {
        return new URLSearchParams(new FormData(element(form)));
    };

    function toBody(data) {
        if (data === undefined || data === null) return undefined;
        if (data instanceof FormData || data instanceof URLSearchParams) return data;
        if (data instanceof HTMLFormElement) return new FormData(data);
        var params = new URLSearchParams();
        Object.keys(data).forEach(function (key) {
            var value = data[key];
            if (Array.isArray(value)) {
                value.forEach(function (item) { params.append(key.slice(-2) === '[]' ? key : key + '[]', item); });
            } else if (value !== undefined && value !== null) {
                params.append(key, value);
            }
        });
        return params;
    }

    /**
     * Send a request. Resolves with the parsed JSON (or text). Rejects with an
     * Error that has .status and .data (for example the validation errors).
     */
    VE.http = {
        request: function (method, url, data) {
            var options = {
                method: method,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': VE.csrfToken(),
                    'Accept': 'application/json, text/html;q=0.9, */*;q=0.8'
                }
            };
            url = VE.url(url);
            if (method === 'GET') {
                var query = toBody(data);
                if (query) url += (url.indexOf('?') === -1 ? '?' : '&') + query.toString();
            } else {
                options.body = toBody(data);
            }
            return fetch(url, options).then(function (response) {
                var type = response.headers.get('Content-Type') || '';
                var parse = type.indexOf('json') !== -1 ? response.json() : response.text();
                return parse.then(function (body) {
                    if (!response.ok) {
                        var error = new Error('Request failed: ' + response.status);
                        error.status = response.status;
                        error.data = body;
                        throw error;
                    }
                    return body;
                });
            });
        },
        get: function (url, params) { return VE.http.request('GET', url, params); },
        post: function (url, data) { return VE.http.request('POST', url, data || {}); },
        /** Submit a form with fetch, to its action and method. */
        postForm: function (form) {
            form = element(form);
            return VE.http.request((form.getAttribute('method') || 'POST').toUpperCase(), form.getAttribute('action'), new FormData(form));
        }
    };

    /** Default handler for failed requests: show the message, log the details. */
    VE.fail = function (error) {
        console.error(error);
        var message = (error && error.data && error.data.message) || Lang.get('js-components.error') || 'Error';
        VE.toast(message, 'error');
    };

    /* ------------------------------------------------- Bootstrap components */

    VE.modal = function (target) {
        var el = element(target);
        if (!el) return null;
        if (!el.VEModal) {
            el.VEModal = el.Modal || new window.Modal(el, {});
        }
        return el.VEModal;
    };

    VE.tooltips = function (root) {
        VE.$$('[data-toggle~="tooltip"]', element(root) || document).forEach(function (el) {
            if (!el.Tooltip) {
                new window.Tooltip(el, {placement: el.getAttribute('data-placement') || 'top', container: document.body});
            }
        });
    };

    /** Init bootstrap.native components (tabs, dropdowns, collapse, ...) in new content. */
    VE.initComponents = function (root) {
        if (window.BSN && window.BSN.initCallback) window.BSN.initCallback(element(root));
        VE.tooltips(root);
    };

    /* --------------------------------------------------- toast and blocking */

    VE.toast = function (message, type) {
        var container = document.getElementById('ve-toasts');
        if (!container) {
            container = document.createElement('div');
            container.id = 've-toasts';
            container.className = 've-toasts';
            container.setAttribute('role', 'status');
            container.setAttribute('aria-live', 'polite');
            document.body.appendChild(container);
        }
        var toast = document.createElement('div');
        toast.className = 've-toast ve-toast-' + (type || 'success');
        toast.textContent = message;
        container.appendChild(toast);
        setTimeout(function () { toast.classList.add('ve-toast-hide'); }, 3500);
        setTimeout(function () { toast.remove(); }, 4000);
    };

    VE.block = function (target) {
        VE.each(target, function (el) {
            if (el.querySelector(':scope > .ve-block')) return;
            if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
            var overlay = document.createElement('div');
            overlay.className = 've-block';
            overlay.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            el.appendChild(overlay);
        });
    };

    VE.unblock = function (target) {
        VE.each(target, function (el) {
            var overlay = el.querySelector(':scope > .ve-block');
            if (overlay) overlay.remove();
        });
    };

    /* ------------------------------------------------------------- inputs */

    function isGreek() {
        return window.Lang && Lang.getLocale && Lang.getLocale() === 'el';
    }

    /** Tom Select on a <select> (replaces select2). Returns the TomSelect instance. */
    VE.select = function (target, options) {
        var el = element(target);
        if (!el) return null;
        if (el.tomselect) return el.tomselect;
        return new window.TomSelect(el, Object.assign({
            allowEmptyOption: true,
            maxOptions: null,
            plugins: el.multiple ? ['remove_button'] : []
        }, options || {}));
    };

    /** Date input with the format dd/mm/yyyy (the format the server expects). */
    VE.datepicker = function (target, options) {
        var result = [];
        VE.each(target, function (el) {
            result.push(el._flatpickr || window.flatpickr(el, Object.assign({
                dateFormat: 'd/m/Y',
                allowInput: true,
                locale: isGreek() && window.flatpickr.l10ns.gr ? window.flatpickr.l10ns.gr : 'default'
            }, options || {})));
        });
        return result.length === 1 ? result[0] : result;
    };

    /** Time input with the format HH:mm. */
    VE.timepicker = function (target, options) {
        var result = [];
        VE.each(target, function (el) {
            result.push(el._flatpickr || window.flatpickr(el, Object.assign({
                enableTime: true,
                noCalendar: true,
                dateFormat: 'H:i',
                time_24hr: true,
                allowInput: true
            }, options || {})));
        });
        return result.length === 1 ? result[0] : result;
    };

    /** Two date inputs where the end date cannot be before the start date. */
    VE.dateRange = function (startTarget, endTarget) {
        VE.each(startTarget, function (startEl, index) {
            var endEl = VE.$$(typeof endTarget === 'string' ? endTarget : '')[index] || element(endTarget);
            var start = VE.datepicker(startEl);
            var end = endEl ? VE.datepicker(endEl) : null;
            if (!end) return;
            start.set('onChange', function (dates) { end.set('minDate', dates[0] || null); });
            end.set('onChange', function (dates) { start.set('maxDate', dates[0] || null); });
            if (start.selectedDates[0]) end.set('minDate', start.selectedDates[0]);
            if (end.selectedDates[0]) start.set('maxDate', end.selectedDates[0]);
        });
    };

    /**
     * Star rating (replaces jquery.raty).
     * options: score, number (5), readOnly, scoreName ("score": name of the
     * hidden input), hints (titles), click(score, event).
     * Returns {score(), setScore(n), readOnly(bool)}.
     */
    VE.stars = function (target, options) {
        var el = element(target);
        if (!el) return null;
        options = Object.assign({number: 5, score: 0, readOnly: false, scoreName: 'score', hints: []}, options || {});
        if (typeof options.score === 'function') options.score = options.score.call(el);
        if (options.score === undefined || options.score === null || options.score === '') {
            options.score = el.getAttribute('data-score') || 0;
        }
        var score = Number(options.score) || 0;
        var readOnly = !!options.readOnly;

        el.innerHTML = '';
        el.classList.add('ve-stars');
        var stars = [];
        for (var i = 1; i <= options.number; i++) {
            var star = document.createElement('i');
            star.setAttribute('data-score', i);
            star.title = options.hints[i - 1] || String(i);
            el.appendChild(star);
            stars.push(star);
        }
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = options.scoreName;
        el.appendChild(input);

        function paint(value) {
            stars.forEach(function (star, index) {
                var n = index + 1;
                star.className = 'fa ' + (value >= n ? 'fa-star' : (value >= n - 0.5 ? 'fa-star-half-o' : 'fa-star-o'));
            });
        }

        function set(value) {
            score = Number(value) || 0;
            input.value = score ? String(score) : '';
            el.setAttribute('data-score', score);
            paint(score);
        }

        stars.forEach(function (star) {
            star.addEventListener('mouseenter', function () { if (!readOnly) paint(Number(star.getAttribute('data-score'))); });
            star.addEventListener('click', function (event) {
                if (readOnly) return;
                set(star.getAttribute('data-score'));
                if (options.click) options.click.call(el, score, event);
            });
        });
        el.addEventListener('mouseleave', function () { paint(score); });

        set(score);
        el.classList.toggle('ve-stars-readonly', readOnly);
        var api = {
            score: function () { return score; },
            setScore: set,
            readOnly: function (value) { readOnly = !!value; el.classList.toggle('ve-stars-readonly', readOnly); }
        };
        el.VEStars = api;
        return api;
    };

    /**
     * Suggestions while typing (replaces jQuery UI autocomplete with a url source).
     * options.minLength: characters before the first request (1).
     */
    VE.autocomplete = function (target, url, options) {
        var minLength = (options && options.minLength) || 1;
        VE.each(target, function (input) {
            var list = document.createElement('datalist');
            list.id = 've-autocomplete-' + Math.random().toString(36).slice(2);
            input.setAttribute('list', list.id);
            input.setAttribute('autocomplete', 'off');
            input.parentNode.insertBefore(list, input.nextSibling);
            var timer;
            input.addEventListener('input', function () {
                clearTimeout(timer);
                var term = input.value.trim();
                if (term.length < minLength) return;
                timer = setTimeout(function () {
                    VE.http.get(url, {term: term}).then(function (items) {
                        list.innerHTML = '';
                        (items || []).forEach(function (item) {
                            var option = document.createElement('option');
                            option.value = typeof item === 'object' ? (item.value || item.label) : item;
                            list.appendChild(option);
                        });
                    }).catch(function () { /* suggestions are optional */ });
                }, 250);
            });
        });
    };

    /* -------------------------------------------------------- inline edit */

    /**
     * Inline edit (replaces x-editable). Click on the element to edit its value.
     * options: type (text|textarea|select|date|time|number), url, pk, name,
     * value, source ([{value, text}] for select), params(data) -> data,
     * validate(value) -> error message or nothing, display(value, text) -> html,
     * success(response, value), emptytext.
     * The request sends {pk, name, value} with POST, like x-editable.
     */
    VE.editable = function (target, options) {
        VE.each(target, function (el) {
            if (el.VEEditable) return;
            var o = Object.assign({
                type: el.getAttribute('data-type') || 'text',
                pk: el.getAttribute('data-pk'),
                name: el.getAttribute('data-name'),
                url: el.getAttribute('data-url'),
                value: el.getAttribute('data-value'),
                emptytext: (window.Lang && Lang.get('js-components.empty')) || '-'
            }, options || {});
            if (o.value === null || o.value === undefined || o.value === 'null') o.value = '';
            el.classList.add('ve-editable');
            el.setAttribute('tabindex', '0');

            function optionText(value) {
                var found = (o.source || []).filter(function (item) { return String(item.value) === String(value); })[0];
                return found ? found.text : value;
            }

            function render() {
                var text = o.type === 'select' ? optionText(o.value) : o.value;
                if (o.display) {
                    el.innerHTML = o.display(o.value, text) || '';
                } else {
                    el.textContent = text === '' || text === null || text === undefined ? o.emptytext : text;
                }
                el.classList.toggle('ve-editable-empty', !o.value);
            }

            function open() {
                if (el.classList.contains('ve-editing')) return;
                el.classList.add('ve-editing');
                var form = document.createElement('form');
                form.className = 've-editable-form form-inline';
                var field;
                if (o.type === 'select') {
                    field = document.createElement('select');
                    (o.source || []).forEach(function (item) {
                        var option = new Option(item.text, item.value, false, String(item.value) === String(o.value));
                        field.appendChild(option);
                    });
                } else if (o.type === 'textarea') {
                    field = document.createElement('textarea');
                    field.value = o.value;
                } else {
                    field = document.createElement('input');
                    field.type = o.type === 'number' ? 'number' : 'text';
                    field.value = o.value;
                }
                field.className = 'form-control input-sm';
                var save = VE.html('<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>' +
                    '<button type="button" class="btn btn-default btn-sm ve-cancel"><i class="fa fa-times"></i></button>' +
                    '<div class="ve-editable-error text-danger"></div>');
                form.appendChild(field);
                form.appendChild(save);
                var original = Array.prototype.slice.call(el.childNodes);
                el.innerHTML = '';
                el.appendChild(form);
                if (o.type === 'date') VE.datepicker(field);
                if (o.type === 'time') VE.timepicker(field);
                field.focus();

                function close() {
                    el.classList.remove('ve-editing');
                    el.innerHTML = '';
                    original.forEach(function (node) { el.appendChild(node); });
                }

                form.querySelector('.ve-cancel').addEventListener('click', function (event) { event.stopPropagation(); close(); });
                form.addEventListener('click', function (event) { event.stopPropagation(); });
                form.addEventListener('keydown', function (event) { if (event.key === 'Escape') close(); });
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    var value = field.value;
                    var error = o.validate ? o.validate.call(el, value) : null;
                    if (error) {
                        form.querySelector('.ve-editable-error').textContent = error;
                        return;
                    }
                    var done = function (response) {
                        o.value = value;
                        el.setAttribute('data-value', value);
                        el.classList.remove('ve-editing');
                        render();
                        if (o.success) o.success.call(el, response, value);
                    };
                    if (!o.url) { done(null); return; }
                    var data = {pk: o.pk, name: o.name, value: value};
                    if (o.params) data = o.params.call(el, data);
                    VE.http.post(o.url, data).then(done).catch(function (err) {
                        form.querySelector('.ve-editable-error').textContent =
                            (err.data && (err.data.message || err.data)) || 'Error';
                    });
                });
            }

            el.addEventListener('click', function (event) { event.preventDefault(); open(); });
            el.addEventListener('keydown', function (event) { if (event.key === 'Enter' && event.target === el) open(); });
            render();
            el.VEEditable = {
                option: function (name, value) { o[name] = value; render(); },
                value: function () { return o.value; }
            };
        });
    };

    /* --------------------------------------------------------------- wizard */

    /**
     * Tab wizard (replaces bootstrapWizard). The element contains a
     * ul.nav (tabs with href="#pane") and .tab-pane elements; buttons with
     * the classes "next" / "previous" (or li.next / li.previous) move between
     * tabs. options.onNext(index) / onTabShow(index) may return false to stop.
     */
    VE.wizard = function (target, options) {
        var root = element(target);
        if (!root) return null;
        options = options || {};
        var links = VE.$$('ul.nav a[href^="#"], ul.nav a[data-target]', root).filter(function (a) {
            return !a.closest('.pager');
        });
        var current = 0;

        function pane(index) {
            var link = links[index];
            return link ? document.querySelector(link.getAttribute('data-target') || link.getAttribute('href')) : null;
        }

        function go(index) {
            if (index < 0 || index >= links.length) return;
            if (options.onTabShow && options.onTabShow(index, links[index]) === false) return;
            links.forEach(function (link, i) {
                var li = link.parentNode;
                li.classList.toggle('active', i === index);
                li.classList.toggle('done', i < index);
                var p = pane(i);
                if (p) p.classList.toggle('active', i === index);
                if (p) p.classList.toggle('in', i === index);
            });
            current = index;
            VE.$$('.previous', root).forEach(function (b) { b.classList.toggle('disabled', index === 0); });
            VE.$$('.next', root).forEach(function (b) { b.classList.toggle('disabled', index === links.length - 1); });
            VE.$$('.finish', root).forEach(function (b) { VE.toggle(b, index === links.length - 1); });
            var bar = root.querySelector('.progress-bar');
            if (bar) bar.style.width = ((index + 1) / links.length * 100) + '%';
            if (options.onTabChanged) options.onTabChanged(index);
        }

        links.forEach(function (link, index) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                if (options.tabClick === false) return;
                if (index > current && options.onNext && options.onNext(current) === false) return;
                go(index);
            });
        });
        VE.on(root, 'click', '.next, .next a', function (event) {
            event.preventDefault();
            if (options.onNext && options.onNext(current) === false) return;
            go(current + 1);
        });
        VE.on(root, 'click', '.previous, .previous a', function (event) {
            event.preventDefault();
            go(current - 1);
        });
        go(0);
        return {go: go, current: function () { return current; }, count: function () { return links.length; }};
    };

    /* ------------------------------------------------------------ org chart */

    /**
     * Draw a nested <ul> as an organisation chart (replaces jOrgChart).
     * The <li> elements become nodes; the classes of each <li> are copied to
     * its node (for example "disabled", "active"). Uses jOrgChart.css.
     * options: chartClass ("jOrgChart"), nodeClick(node, li).
     */
    VE.orgChart = function (list, target, options) {
        list = element(list);
        target = element(target);
        if (!list || !target) return;
        options = Object.assign({chartClass: 'jOrgChart'}, options || {});
        var root = list.querySelector(':scope > li');
        target.innerHTML = '';
        var container = document.createElement('div');
        container.className = options.chartClass;
        if (root) container.appendChild(buildNode(root, options));
        target.appendChild(container);
        VE.tooltips(container);
    };

    function buildNode(li, options) {
        var table = document.createElement('table');
        table.setAttribute('cellpadding', '0');
        table.setAttribute('cellspacing', '0');
        table.setAttribute('border', '0');
        var tbody = document.createElement('tbody');
        table.appendChild(tbody);

        var children = VE.$$(':scope > ul > li', li);
        var nodeRow = document.createElement('tr');
        nodeRow.className = 'node-cells';
        var nodeCell = document.createElement('td');
        nodeCell.className = 'node-cell';
        nodeCell.setAttribute('colspan', String(Math.max(children.length, 1) * 2));

        var node = document.createElement('div');
        node.className = ('node ' + li.className).trim();
        Array.prototype.forEach.call(li.attributes, function (attribute) {
            if (attribute.name !== 'class') node.setAttribute(attribute.name, attribute.value);
        });
        Array.prototype.forEach.call(li.childNodes, function (child) {
            if (!(child.nodeType === 1 && child.tagName === 'UL')) node.appendChild(child.cloneNode(true));
        });
        if (options.nodeClick) {
            node.addEventListener('click', function (event) { options.nodeClick(node, li, event); });
        }
        nodeCell.appendChild(node);
        nodeRow.appendChild(nodeCell);
        tbody.appendChild(nodeRow);

        if (children.length) {
            var downRow = document.createElement('tr');
            var down = document.createElement('td');
            down.setAttribute('colspan', String(children.length * 2));
            down.innerHTML = '<div class="line down"></div>';
            downRow.appendChild(down);
            tbody.appendChild(downRow);

            var linesRow = document.createElement('tr');
            children.forEach(function () {
                var left = document.createElement('td');
                left.innerHTML = '&nbsp;';
                left.className = 'line left top';
                var right = document.createElement('td');
                right.innerHTML = '&nbsp;';
                right.className = 'line right top';
                linesRow.appendChild(left);
                linesRow.appendChild(right);
            });
            linesRow.firstChild.className = 'line left';
            linesRow.lastChild.className = 'line right';
            tbody.appendChild(linesRow);

            var childRow = document.createElement('tr');
            children.forEach(function (child) {
                var cell = document.createElement('td');
                cell.className = 'node-container';
                cell.setAttribute('colspan', '2');
                cell.appendChild(buildNode(child, options));
                childRow.appendChild(cell);
            });
            tbody.appendChild(childRow);
        }
        return table;
    }

    /* ---------------------------------------------------------------- table */

    /**
     * A table with sorting, paging, page length, info and print/CSV buttons,
     * with the same CSS classes as DataTables, so the existing styles apply.
     *
     * options:
     *   url / data      load rows from a URL (JSON {data: [...]} or [...]) or an array
     *   dataSrc         property of the response with the rows ("data")
     *   columns         [{data: 'field', render: fn(value, type, row), orderable, className}]
     *                   "data: 'field'" without render is escaped text. A render
     *                   function returns HTML: escape the values with VE.esc!
     *   order           [[columnIndex, 'asc'|'desc']] or [] (no initial sort)
     *   paging, lengthChange (true: the page length menu), pageLength (10),
 *   lengthMenu ([10, 25, 50, 100]), info, searching
     *   buttons         ['print', 'csv', 'copy'] (labels from js-components)
     *   language        {lengthMenu, zeroRecords, info, infoEmpty, search,
     *                    paginate: {first, last, next, previous}} (DataTables keys)
     *   rowCallback(tr, row), drawCallback(table), createdRow(tr, row)
     *
     * Returns a VE.Table: setData(rows), reload(url), rows(), draw(), page(n).
     */
    function Table(target, options) {
        this.table = element(target);
        this.o = Object.assign({
            dataSrc: 'data', columns: [], order: [], paging: true, lengthChange: true, pageLength: 10,
            lengthMenu: [10, 25, 50, 100], info: true, searching: false, buttons: [], language: {}
        }, options || {});
        this.data = [];
        this.view = [];
        this.pageIndex = 0;
        this.pageLength = this.o.pageLength;
        this.search = '';
        this.sort = (this.o.order && this.o.order.length) ? {column: this.o.order[0][0], dir: this.o.order[0][1]} : null;
        this.table.VETable = this;
        this.build();
        if (this.o.url) this.reload(this.o.url); else this.setData(this.o.data || []);
    }

    Table.prototype.text = function (key, fallback) {
        var language = this.o.language || {};
        return language[key] !== undefined ? language[key] : fallback;
    };

    Table.prototype.build = function () {
        var self = this;
        var table = this.table;
        table.classList.add('dataTable');
        var wrapper = document.createElement('div');
        wrapper.className = 'dataTables_wrapper';
        table.parentNode.insertBefore(wrapper, table);

        if (this.o.buttons.length) {
            var tools = document.createElement('div');
            tools.className = 'DTTT_container';
            this.o.buttons.forEach(function (button) {
                var name = typeof button === 'string' ? button : button.extend;
                var label = (typeof button === 'object' && button.text) || Lang.get('js-components.' + name);
                var b = document.createElement('a');
                b.className = 'DTTT_button DTTT_button_' + name;
                b.href = '#';
                b.textContent = label;
                b.addEventListener('click', function (event) { event.preventDefault(); self[name](); });
                tools.appendChild(b);
            });
            wrapper.appendChild(tools);
            var clear = document.createElement('div');
            clear.className = 'clear';
            wrapper.appendChild(clear);
        }

        if (this.o.paging && this.o.lengthChange) {
            var length = document.createElement('div');
            length.className = 'dataTables_length';
            var select = '<select class="form-control input-sm">' + this.o.lengthMenu.map(function (n) {
                return '<option value="' + n + '"' + (n === self.pageLength ? ' selected' : '') + '>' + n + '</option>';
            }).join('') + '</select>';
            var menu = this.text('lengthMenu', 'Show _MENU_ entries');
            length.innerHTML = '<label>' + VE.esc(menu).replace('_MENU_', select) + '</label>';
            length.querySelector('select').addEventListener('change', function () {
                self.pageLength = Number(this.value);
                self.pageIndex = 0;
                self.draw();
            });
            wrapper.appendChild(length);
        }

        if (this.o.searching) {
            var filter = document.createElement('div');
            filter.className = 'dataTables_filter';
            filter.innerHTML = '<label>' + VE.esc(this.text('search', 'Search:')) + ' <input type="search" class="form-control input-sm"></label>';
            filter.querySelector('input').addEventListener('input', function () {
                self.search = this.value.toLowerCase();
                self.pageIndex = 0;
                self.applyView();
                self.draw();
            });
            wrapper.appendChild(filter);
        }

        wrapper.appendChild(table);
        if (!table.tBodies.length) table.appendChild(document.createElement('tbody'));

        var headers = table.tHead ? VE.$$('tr:last-child > th', table.tHead) : [];
        headers.forEach(function (th, index) {
            var column = self.o.columns[index] || {};
            if (column.orderable === false) {
                th.classList.add('sorting_disabled');
                return;
            }
            th.classList.add('sorting');
            th.setAttribute('tabindex', '0');
            th.setAttribute('role', 'button');
            var toggle = function () {
                var dir = self.sort && self.sort.column === index && self.sort.dir === 'asc' ? 'desc' : 'asc';
                self.sort = {column: index, dir: dir};
                self.applyView();
                self.draw();
            };
            th.addEventListener('click', toggle);
            th.addEventListener('keydown', function (event) { if (event.key === 'Enter') toggle(); });
        });
        this.headers = headers;

        if (this.o.info) {
            this.infoEl = document.createElement('div');
            this.infoEl.className = 'dataTables_info';
            this.infoEl.setAttribute('role', 'status');
            wrapper.appendChild(this.infoEl);
        }
        if (this.o.paging) {
            this.pagerEl = document.createElement('div');
            this.pagerEl.className = 'dataTables_paginate paging_simple_numbers';
            this.pagerEl.addEventListener('click', function (event) {
                var button = event.target.closest('.paginate_button');
                if (!button || button.classList.contains('disabled')) return;
                event.preventDefault();
                self.page(Number(button.getAttribute('data-page')));
            });
            wrapper.appendChild(this.pagerEl);
        }
        this.wrapper = wrapper;
    };

    Table.prototype.cellValue = function (row, column) {
        if (column.data === null || column.data === undefined) return row;
        return String(column.data).split('.').reduce(function (value, key) {
            return value === null || value === undefined ? value : value[key];
        }, row);
    };

    Table.prototype.cellHtml = function (row, column) {
        var value = this.cellValue(row, column);
        if (column.render) return column.render(value, 'display', row);
        return VE.esc(value);
    };

    Table.prototype.sortValue = function (row, index) {
        var column = this.o.columns[index] || {};
        var value;
        if (column.render) {
            value = column.render(this.cellValue(row, column), 'sort', row);
            if (typeof value === 'string') {
                var div = document.createElement('div');
                div.innerHTML = value;
                value = div.textContent;
            }
        } else {
            value = this.cellValue(row, column);
        }
        if (value === null || value === undefined) return '';
        var number = Number(value);
        if (value !== '' && !isNaN(number)) return number;
        var date = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/.exec(String(value).trim());
        if (date) return Number(date[3] + date[2].padStart(2, '0') + date[1].padStart(2, '0'));
        return String(value).toLowerCase();
    };

    Table.prototype.applyView = function () {
        var self = this;
        var rows = this.data.slice();
        if (this.search) {
            rows = rows.filter(function (row) {
                return self.o.columns.some(function (column, index) {
                    return String(self.sortValue(row, index)).toLowerCase().indexOf(self.search) !== -1;
                });
            });
        }
        if (this.sort) {
            var index = this.sort.column;
            var factor = this.sort.dir === 'desc' ? -1 : 1;
            var keyed = rows.map(function (row, i) { return {row: row, key: self.sortValue(row, index), i: i}; });
            keyed.sort(function (a, b) {
                if (a.key < b.key) return -factor;
                if (a.key > b.key) return factor;
                return a.i - b.i;
            });
            rows = keyed.map(function (k) { return k.row; });
        }
        this.view = rows;
    };

    Table.prototype.setData = function (rows) {
        this.data = Array.isArray(rows) ? rows : [];
        this.pageIndex = 0;
        this.applyView();
        this.draw();
        return this;
    };

    Table.prototype.rows = function () {
        return this.data;
    };

    /** Load the rows again (from the first URL, or a new one). */
    Table.prototype.reload = function (url) {
        var self = this;
        if (url) this.o.url = url;
        VE.block(this.wrapper);
        return VE.http.get(this.o.url).then(function (response) {
            VE.unblock(self.wrapper);
            var rows = Array.isArray(response) ? response : (response ? response[self.o.dataSrc] : []);
            self.setData(rows || []);
            return self;
        }).catch(function (error) {
            VE.unblock(self.wrapper);
            VE.fail(error);
        });
    };

    Table.prototype.page = function (index) {
        var pages = Math.max(1, Math.ceil(this.view.length / this.pageLength));
        this.pageIndex = Math.min(Math.max(0, index), pages - 1);
        this.draw();
    };

    Table.prototype.draw = function () {
        var self = this;
        var tbody = this.table.tBodies[0];
        var total = this.view.length;
        var start = this.o.paging ? this.pageIndex * this.pageLength : 0;
        var end = this.o.paging ? Math.min(start + this.pageLength, total) : total;

        this.headers.forEach(function (th, index) {
            th.classList.remove('sorting_asc', 'sorting_desc');
            th.removeAttribute('aria-sort');
            if (self.sort && self.sort.column === index) {
                th.classList.add(self.sort.dir === 'desc' ? 'sorting_desc' : 'sorting_asc');
                th.setAttribute('aria-sort', self.sort.dir === 'desc' ? 'descending' : 'ascending');
            }
        });

        var html = '';
        if (total === 0) {
            html = '<tr class="odd"><td valign="top" colspan="' + Math.max(this.o.columns.length, 1) + '" class="dataTables_empty">' +
                VE.esc(this.text('zeroRecords', this.text('emptyTable', 'No data'))) + '</td></tr>';
            tbody.innerHTML = html;
        } else {
            tbody.innerHTML = '';
            for (var i = start; i < end; i++) {
                var row = this.view[i];
                var tr = document.createElement('tr');
                tr.className = (i - start) % 2 === 0 ? 'odd' : 'even';
                tr.innerHTML = this.o.columns.map(function (column) {
                    var cls = column.className ? ' class="' + VE.esc(column.className) + '"' : '';
                    return '<td' + cls + '>' + self.cellHtml(row, column) + '</td>';
                }).join('');
                if (this.o.createdRow) this.o.createdRow(tr, row, i);
                if (this.o.rowCallback) this.o.rowCallback(tr, row, i);
                tbody.appendChild(tr);
            }
        }

        if (this.infoEl) {
            var info = total === 0 ? this.text('infoEmpty', '') : this.text('info', 'Showing _START_ to _END_ of _TOTAL_ entries');
            this.infoEl.textContent = info.replace('_START_', total ? start + 1 : 0).replace('_END_', end)
                .replace('_TOTAL_', total).replace('_MAX_', this.data.length)
                .replace('_PAGE_', this.pageIndex + 1).replace('_PAGES_', Math.max(1, Math.ceil(total / this.pageLength)));
        }
        if (this.pagerEl) this.drawPager(total);
        VE.tooltips(tbody);
        if (this.o.drawCallback) this.o.drawCallback(this);
    };

    Table.prototype.drawPager = function (total) {
        var pages = Math.max(1, Math.ceil(total / this.pageLength));
        var current = this.pageIndex;
        var paginate = this.text('paginate', {}) || {};
        var button = function (label, page, cls, disabled) {
            return '<a href="#" class="paginate_button ' + cls + (disabled ? ' disabled' : '') + '" data-page="' + page + '"' +
                (disabled ? ' aria-disabled="true"' : '') + '>' + VE.esc(label) + '</a>';
        };
        var numbers = [];
        for (var p = 0; p < pages; p++) {
            if (pages > 7 && p > 0 && p < pages - 1 && Math.abs(p - current) > 2) {
                if (numbers[numbers.length - 1] !== '…') numbers.push('…');
                continue;
            }
            numbers.push(p);
        }
        this.pagerEl.innerHTML =
            button(paginate.previous || '<', current - 1, 'previous', current === 0) +
            '<span>' + numbers.map(function (p) {
                return p === '…' ? '<span class="ellipsis">…</span>' : button(String(p + 1), p, p === current ? 'current' : '', false);
            }).join('') + '</span>' +
            button(paginate.next || '>', current + 1, 'next', current >= pages - 1);
    };

    /** All rows as text: [[header, ...], [cell, ...], ...] */
    Table.prototype.matrix = function () {
        var self = this;
        var heads = this.headers.map(function (th) { return th.textContent.trim(); });
        var columns = this.o.columns.map(function (column, index) { return {column: column, index: index}; })
            .filter(function (c) { return c.column.orderable !== false || c.column.data; });
        var div = document.createElement('div');
        var body = this.view.map(function (row) {
            return columns.map(function (c) {
                div.innerHTML = self.cellHtml(row, c.column);
                return div.textContent.trim().replace(/\s+/g, ' ');
            });
        });
        return [columns.map(function (c) { return heads[c.index] || ''; })].concat(body);
    };

    Table.prototype.print = function () {
        var rows = this.matrix();
        var win = window.open('', '_blank');
        if (!win) return;
        var html = '<table border="1" cellspacing="0" cellpadding="4"><thead><tr>' +
            rows[0].map(function (h) { return '<th>' + VE.esc(h) + '</th>'; }).join('') + '</tr></thead><tbody>' +
            rows.slice(1).map(function (r) { return '<tr>' + r.map(function (c) { return '<td>' + VE.esc(c) + '</td>'; }).join('') + '</tr>'; }).join('') +
            '</tbody></table>';
        win.document.write('<!doctype html><html><head><meta charset="utf-8"><title>' + VE.esc(document.title) +
            '</title><style>body{font:12px sans-serif}table{border-collapse:collapse;width:100%}th{text-align:left}</style></head><body>' +
            html + '</body></html>');
        win.document.close();
        win.focus();
        win.print();
    };

    Table.prototype.csv = function () {
        var csv = this.matrix().map(function (row) {
            return row.map(function (cell) { return '"' + String(cell).replace(/"/g, '""') + '"'; }).join(',');
        }).join('\r\n');
        var blob = new Blob(['﻿' + csv], {type: 'text/csv;charset=utf-8'});
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = (this.table.id || 'table') + '.csv';
        document.body.appendChild(link);
        link.click();
        link.remove();
    };

    Table.prototype.copy = function () {
        var text = this.matrix().map(function (row) { return row.join('\t'); }).join('\n');
        if (navigator.clipboard) navigator.clipboard.writeText(text).then(function () { VE.toast(Lang.get('js-components.copied') || 'OK'); });
    };

    VE.Table = Table;
    VE.table = function (target, options) {
        return new Table(target, options);
    };

    /** Common DataTables "language" texts of the application, with a "zero records" text. */
    VE.tableLanguage = function (zeroKey) {
        var zero = Lang.get(zeroKey || 'js-components.zeroRecords');
        return {
            lengthMenu: Lang.get('js-components.lengthMenu'),
            zeroRecords: zero,
            info: Lang.get('js-components.info'),
            infoEmpty: zero,
            search: Lang.get('js-components.search'),
            paginate: {first: Lang.get('js-components.first'), last: Lang.get('js-components.last'), next: '>', previous: '<'}
        };
    };

    /* -------------------------------------------------------------- search */

    /**
     * The search forms (#searchForm): submit with fetch and show the result in
     * the table. Dropdowns with the classes "searchDropDown getValue" send the
     * text of the selected option (for example the city), "0" sends nothing.
     */
    VE.searchForm = function (form, table) {
        form = element(form);
        if (!form) return;
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var data = new URLSearchParams(new FormData(form));
            VE.$$('.searchDropDown.getValue', form).forEach(function (select) {
                var name = select.getAttribute('data-name') || select.name;
                var option = select.options[select.selectedIndex];
                if (!name || !option) return;
                data.set(name, option.value !== '0' ? option.text : '');
            });
            VE.block(table.wrapper);
            VE.http.request((form.getAttribute('method') || 'POST').toUpperCase(), form.getAttribute('action'), data)
                .then(function (response) {
                    VE.unblock(table.wrapper);
                    table.setData((response && response.data) || []);
                })
                .catch(function (error) {
                    VE.unblock(table.wrapper);
                    VE.fail(error);
                });
        });
        var clear = form.querySelector('#clear') || document.getElementById('clear');
        if (clear) {
            clear.addEventListener('click', function () {
                VE.$$('.search', form).forEach(function (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') input.checked = false;
                    else input.value = '';
                });
                VE.$$('.searchDropDown', form).forEach(function (select) {
                    if (select.tomselect) select.tomselect.setValue('0'); else select.value = '0';
                });
            });
        }
    };

    /** Read a query string parameter of the current page. */
    VE.param = function (name) {
        return new URLSearchParams(window.location.search).get(name);
    };
    window.getParameterByName = VE.param;
})(window, document);
