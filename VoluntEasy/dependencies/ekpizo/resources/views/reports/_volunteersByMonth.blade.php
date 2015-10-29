<div class="row">
    <div class="col-md-2 pull-right">
        <div id="yearsDropDown"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <canvas id="volunteersByMonth" height="50"></canvas>
    </div>
</div>
<div class="row top-margin">
    <div class="col-md-12">
        <div class="pull-right">
            <i class="fa fa-square" style="color:#22BAA0;"></i> Διαθέσιμοι |
            <i class="fa fa-square" style="color:#E26E27;"></i> Υπό ένταξη|
            <i class="fa fa-square" style="color:#6a5fac;"></i> Ενεργοί |
            <i class="fa fa-square" style="color:#12AFCB;"></i> Νέοι
        </div>
    </div>
</div>

@section('footerScripts')
<script>

    //when page loads -> ajax call to retrieve volunteers
    //create the appropriate obj, then init the chart

    var volunteersByMonth;
    var byMonthChart;

    $.ajax({
        url: $("body").attr('data-url') + "/reports/volunteersByMonth",
        method: 'GET',
        success: function (result) {

            volunteersByMonth = result;
            //First we need to initialize the dropdown from where the user can filter the report by year
            var currentYear = (new Date).getFullYear();
            var yearsDropDown = '<label>Έτος</label><select class="form-control">';

            //Add the years options and set the current year as selected
            $.each(result, function (key, value) {
                if (key == currentYear)
                    yearsDropDown += '<option value=' + key + ' selected>' + key + '</option>';
                else
                    yearsDropDown += '<option value=' + key + '>' + key + '</option>';
            });

            $("#yearsDropDown").append(yearsDropDown);

            var dataset = initDataset(result, currentYear);

            initChart(dataset);
        }
    });


    //when the user selected a different year,
    //we must show the year's data
    $("#yearsDropDown").change(function() {

        year = $( "#yearsDropDown option:selected" ).val();

        var dataset = initDataset(volunteersByMonth, year);

        byMonthChart.destroy();
        initChart(dataset);

    });


    function initChart(dataset){
        var ctx = document.getElementById("volunteersByMonth").getContext("2d");

        var data = {
            labels: ["Ιανουάριος", "Φεβρουάριος", "Μάρτιος", "Απρίλιος", "Μάιος", "Ιούνιος", "Ιούλιος", "Αύγουστος", "Σεπτέμβριος", "Οκτώβριος", "Νοέμβριος", "Δεκέμβριος"],
            datasets: dataset
        };

        byMonthChart = new Chart(ctx).Bar(data, {
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

    function initDataset(volunteers, year){

        var dataset = [];
        $.each(volunteers, function (key, value) {

            if (key == year) {
                dataset.push({
                    label: "Νέοι",
                    fillColor: "#12AFCB",
                    strokeColor: "#12AFCB",
                    highlightFill: "#12AFCB",
                    highlightStroke: "#12AFCB",
                    data: value.new
                });

                dataset.push({
                    label: "Υπό Ένταξη",
                    fillColor: "#E26E27",
                    strokeColor: "#E26E27",
                    highlightFill: "#E26E27",
                    highlightStroke: "#E26E27",
                    data: value.pending
                });

                dataset.push({
                    label: "Διαθέσιμοι",
                    fillColor: "#22BAA0",
                    strokeColor: "#22BAA0",
                    highlightFill: "#22BAA0",
                    highlightStroke: "#22BAA0",
                    data: value.available
                });

                dataset.push({
                    label: "Ενεργοί",
                    fillColor: "#7a6fbe",
                    strokeColor: "#7a6fbe",
                    highlightFill: "#7a6fbe",
                    highlightStroke: "#7a6fbe",
                    data: value.active
                });
                return false;
            }
        });

        return dataset;
    }

</script>
@append
