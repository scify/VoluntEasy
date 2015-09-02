
<canvas id="chart2" height="150"></canvas>


@section('footerScripts')
<script>

    //when page loads -> ajax call to retrieve volunteers
    //create the appropriate obj, then init the chart


    var ctx2 = document.getElementById("chart2").getContext("2d");
    var data2 = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "Νέοι",
                fillColor: "#12AFCB",
                strokeColor: "#12AFCB",
                highlightFill: "#12AFCB",
                highlightStroke: "#12AFCB",
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "Υπό Ένταξη",
                fillColor: "#f6d433",
                strokeColor: "#f6d433",
                highlightFill: "#f6d433",
                highlightStroke: "#f6d433",
                data: [28, 48, 40, 19, 86, 27, 90]
            },
            {
                label: "Διαθέσιμοι",
                fillColor: "#22BAA0",
                strokeColor: "#22BAA0",
                highlightFill: "#22BAA0",
                highlightStroke: "#22BAA0",
                data: [28, 48, 40, 19, 86, 27, 90]
            },
            {
                label: "Ενεργοί",
                fillColor: "#7a6fbe",
                strokeColor: "#7a6fbe",
                highlightFill: "#7a6fbe",
                highlightStroke: "#7a6fbe",
                data: [28, 48, 40, 19, 86, 27, 90]
            }
        ]
    };

    var chart2 = new Chart(ctx2).Bar(data2, {
        scaleBeginAtZero : true,
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.05)",
        scaleGridLineWidth : 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke : true,
        barStrokeWidth : 2,
        barDatasetSpacing : 1,
        responsive: true
    });




</script>
@append
