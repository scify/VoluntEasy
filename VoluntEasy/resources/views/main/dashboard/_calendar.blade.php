<div id='calendar'></div>

@section('footerScripts')
<script>
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title'
        },
        lang: 'el',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: {
            url: $("body").attr('data-url') + '/api/actions/calendar'
        },
        eventClick: function (calEvent, jsEvent, view) {
            var html = '';
            html += '<h3>Δράση ' + calEvent.title + '</h3>';
            html += '<p><strong>Μονάδα:</strong> ' + calEvent.unit + '</p>';
            html += '<p><strong>Περιγραφή Δράσης:</strong> ' + calEvent.description + '</p>';
            html += '<p><strong>Διάρκεια:</strong> ' + calEvent.start_date + ' - ' + calEvent.end_date + '</p>';

            if (calEvent.name != null && calEvent.name != '') {
                html += '<p><strong>Στοιχεία Υπευθύνου:</strong> ' + calEvent.name + '<br/>';

                if (calEvent.email != null && calEvent.email != '')
                    html += '<i class="fa fa-folder"></i> <a href="mailto:' + calEvent.email + '">' + calEvent.email + '</a>';

                if (calEvent.phone_number != null && calEvent.phone_number != '')
                    html += ' <i class="fa fa-phone"></i> ' + calEvent.phone_number + '</p>';

            }
            html += '<p><strong>Αριθμός Εθελοντών:</strong> ' + calEvent.volunteers + '</p>';

            $("#actionDetails").html(html);
        }
    });
</script>
@append
