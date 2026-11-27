<div id='calendar'></div>


@section('footerScripts')
<script src="{{ asset('assets/vendor/fullcalendar/index.global.min.js') }}"></script>
@if (\Cookie::get('locale') === 'el')
<script src="{{ asset('assets/vendor/fullcalendar/locales/el.global.min.js') }}"></script>
@endif
<script>
    VE.ready(function () {
        var calendarEl = document.getElementById('calendar');

        function strong(label, value) {
            return '<p><strong>' + VE.esc(label) + '</strong> ' + VE.esc(value) + '</p>';
        }

        // the details of an action, shown in a popover
        function details(event) {
            var p = event.extendedProps;
            var html = strong(Lang.get('js-components.unit'), p.unit) +
                strong(Lang.get('js-components.actionDescr'), p.description) +
                strong(Lang.get('js-components.actionDuration'), p.start_date + ' - ' + p.end_date);

            if (p.name != null && p.name != '') {
                html += '<p><strong>' + VE.esc(Lang.get('js-components.actionExec')) + '</strong> ' + VE.esc(p.name) + '<br/>';
                if (p.email != null && p.email != '')
                    html += '<i class="fa fa-folder"></i> <a href="mailto:' + VE.esc(p.email) + '">' + VE.esc(p.email) + '</a>';
                if (p.phone_number != null && p.phone_number != '')
                    html += ' <i class="fa fa-phone"></i> ' + VE.esc(p.phone_number);
                html += '</p>';
            }
            html += strong(Lang.get('js-components.volNum'), p.volunteers);
            return html;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: '',
                center: 'title',
                right: 'prev,next today'
            },
            locale: @json(\Cookie::get('locale') === 'el' ? 'el' : 'en'),
            editable: false,
            dayMaxEvents: true, // allow "more" link when too many events
            events: {
                url: VE.url('/api/actions/calendar')
            },
            eventClick: function (info) {
                info.jsEvent.preventDefault();
                var el = info.el;
                if (el.Popover) return; // the popover toggles itself on click
                new Popover(el, {
                    trigger: 'click',
                    placement: 'bottom',
                    container: document.body,
                    title: VE.esc(Lang.get('js-components.action') + info.event.title),
                    content: details(info.event)
                });
                el.Popover.show();
            }
        });
        calendar.render();
    });
</script>
@append
