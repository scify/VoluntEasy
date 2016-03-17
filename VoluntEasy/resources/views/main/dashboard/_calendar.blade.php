<div id="popover-head" class="hide"></div>
<div id="popover-content" class="hide">
</div>

<div id='calendar'></div>


@section('footerScripts')
<script>
    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: 'prev,next today'
        },
        lang: 'el',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: {
            url: $("body").attr('data-url') + '/api/actions/calendar'
        },
        eventClick: function (calEvent, jsEvent, view) {


            $(this).popover({
                html: true,
                placement: 'bottom',
                container: '#calendar',
                title: function () {
                    $("#popover-head").html(Lang.get('js-components.action') + calEvent.title);
                    return $("#popover-head").html();
                },
                content: function () {
                    html = '';
                    html += '<p><strong>' + Lang.get('js-components.unit') + '</strong> ' + calEvent.unit + '</p>';
                    html += '<p><strong>' + Lang.get('js-components.actionDescr') + '</strong> ' + calEvent.description + '</p>';
                    html += '<p><strong>' + Lang.get('js-components.actionDuration') + '</strong> ' + calEvent.start_date + ' - ' + calEvent.end_date + '</p>';

                    if (calEvent.name != null && calEvent.name != '') {
                        html += '<p><strong>' + Lang.get('js-components.actionExec') + '</strong> ' + calEvent.name + '<br/>';

                        if (calEvent.email != null && calEvent.email != '')
                            html += '<i class="fa fa-folder"></i> <a href="mailto:' + calEvent.email + '">' + calEvent.email + '</a>';

                        if (calEvent.phone_number != null && calEvent.phone_number != '')
                            html += ' <i class="fa fa-phone"></i> ' + calEvent.phone_number + '</p>';

                    }
                    html += '<p><strong>' + Lang.get('js-components.volNum') + '</strong> ' + calEvent.volunteers + '</p>';

                    $("#popover-content").html(html);

                    return $("#popover-content").html();
                }
            });

            $(this).popover('toggle');


            /*  var html = '';
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
             */
        }

    });

</script>
@append
