<div class="row">
    <div class="col-md-2 pull-right">
        <div id="yearsDropDown"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <canvas id="activeAndAvailable" height="50"></canvas>
    </div>
</div>
<div class="row top-margin">
    <div class="col-md-12">
        <div class="pull-right">
            <i class="fa fa-square" style="color:#22BAA0;"></i> {{ trans('entities/volunteers.available') }} |
            <i class="fa fa-square" style="color:#6a5fac;"></i> {{ trans('entities/volunteers.active') }}
        </div>
    </div>
</div>

@section('footerScripts')
<script>

    //when page loads -> ajax call to retrieve volunteers
    //create the appropriate obj, then init the chart

    var activeAndAvailable;
    var activeAndAvailableChart;

    $.ajax({
        url: $("body").attr('data-url') + "/reports/activeAndAvailableVolunteersByUnit",
        method: 'GET',
        success: function (result) {

            activeAndAvailable = result;
            //First we need to initialize the dropdown from where the user can filter the report by year
         /*   var currentYear = (new Date).getFullYear();
            var yearsDropDown = '<label>'+Lang.get('js-components.year')+'</label><select class="form-control">';

            //Add the years options and set the current year as selected
            $.each(result, function (key, value) {
                if (key == currentYear)
                    yearsDropDown += '<option value=' + key + ' selected>' + key + '</option>';
                else
                    yearsDropDown += '<option value=' + key + '>' + key + '</option>';
            });

            $("#yearsDropDown").append(yearsDropDown);
*/
            var dataset = initActiveAndAvailableDataset(result/*, currentYear*/);
            initActiveAndAvailableChart(result.unitNames, dataset);
        }
    });

/*
    //when the user selected a different year,
    //we must show the year's data
    $("#yearsDropDown").change(function() {

        year = $( "#yearsDropDown option:selected" ).val();

        var dataset = initDataset(activeAndAvailable, year);

        activeAndAvailableChart.destroy();
        initActiveAndAvailableChart(dataset);

    });
*/

    function initActiveAndAvailableChart(labels, dataset){
        var ctx = document.getElementById("activeAndAvailable").getContext("2d");

        console.log(dataset);
        var data = {
            labels: labels,
            datasets: dataset
        };

        activeAndAvailableChart = new Chart(ctx).Bar(data, {
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

    function initActiveAndAvailableDataset(volunteers, year){

        var dataset = [];
        $.each(volunteers, function (key, value) {
console.log(value);
            //if (key == year) {
                dataset.push({
                    label: Lang.get('js-components.available'),
                    fillColor: "#22BAA0",
                    strokeColor: "#22BAA0",
                    highlightFill: "#22BAA0",
                    highlightStroke: "#22BAA0",
                    data: value.activeVolunteers
                });

                dataset.push({
                    label: Lang.get('js-components.active'),
                    fillColor: "#7a6fbe",
                    strokeColor: "#7a6fbe",
                    highlightFill: "#7a6fbe",
                    highlightStroke: "#7a6fbe",
                    data: value.availableVolunteers
                });
                return false;
         //   }
        });

        return dataset;
    }

</script>
@append
