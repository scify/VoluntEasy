<div id='calendar'></div>

@section('footerScripts')
<script>
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title'
        },
        lang: 'el',
        //defaultDate: '2015-02-12',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: {
            url: $("body").attr('data-url') + '/api/actions/calendar'
        }
    });
</script>
@append
