<canvas id="chart2" height="150"></canvas>


@section('footerScripts')
<script>


    //when page loads -> ajax call to retrieve volunteers
    //create the appropriate obj, then init the chart


    $.ajax({
        url: $("body").attr('data-url') + "/reports/volunteersByMonth",
        method: 'GET',
        success: function (result) {

            var ctx2 = document.getElementById("chart2").getContext("2d");
            var data2 = {
                labels: ["Ιανουάριος", "Φεβρουάριος", "Μάρτιος", "Απρίλιος", "Μάιος", "Ιούνιος", "Ιούλιος", "Αύγουστος", "Σεπτέμβριος", "Οκτώβριος", "Νοέμβριος", "Δεκέμβριος"],
                datasets: [
                    {
                        label: "Νέοι",
                        fillColor: "#12AFCB",
                        strokeColor: "#12AFCB",
                        highlightFill: "#12AFCB",
                        highlightStroke: "#12AFCB",
                        data: result.active
                    },
                    {
                        label: "Υπό Ένταξη",
                        fillColor: "#f6d433",
                        strokeColor: "#f6d433",
                        highlightFill: "#f6d433",
                        highlightStroke: "#f6d433",
                        data: result.pending
                    },
                    {
                        label: "Διαθέσιμοι",
                        fillColor: "#22BAA0",
                        strokeColor: "#22BAA0",
                        highlightFill: "#22BAA0",
                        highlightStroke: "#22BAA0",
                        data: result.available
                    },
                    {
                        label: "Ενεργοί",
                        fillColor: "#7a6fbe",
                        strokeColor: "#7a6fbe",
                        highlightFill: "#7a6fbe",
                        highlightStroke: "#7a6fbe",
                        data: result.active
                    }
                ]
            };

            var chart2 = new Chart(ctx2).Bar(data2, {
                scaleBeginAtZero: true,
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                barShowStroke: true,
                barStrokeWidth: 2,
                barDatasetSpacing: 1,
                responsive: true
            });
        }
    });


</script>
@append
