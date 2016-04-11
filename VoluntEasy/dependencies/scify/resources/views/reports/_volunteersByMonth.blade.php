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
            <i class="fa fa-square" style="color:#22BAA0;"></i> {{ trans('entities/volunteers.available') }} |
            <i class="fa fa-square" style="color:#E26E27;"></i> {{ trans('entities/volunteers.pending') }} |
            <i class="fa fa-square" style="color:#6a5fac;"></i> {{ trans('entities/volunteers.active') }} |
            <i class="fa fa-square" style="color:#12AFCB;"></i> {{ trans('entities/volunteers.new') }}
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
            var yearsDropDown = '<label>'+Lang.get('js-components.year')+'</label><select class="form-control">';

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
            labels: [
                Lang.get('js-components.january'),
                Lang.get('js-components.february'),
                Lang.get('js-components.march'),
                Lang.get('js-components.april'),
                Lang.get('js-components.may'),
                Lang.get('js-components.june'),
                Lang.get('js-components.july'),
                Lang.get('js-components.august'),
                Lang.get('js-components.september'),
                Lang.get('js-components.october'),
                Lang.get('js-components.november'),
                Lang.get('js-components.december'),
            ],
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
                    label: Lang.get('js-components.new'),
                    fillColor: "#12AFCB",
                    strokeColor: "#12AFCB",
                    highlightFill: "#12AFCB",
                    highlightStroke: "#12AFCB",
                    data: value.new
                });

                dataset.push({
                    label: Lang.get('js-components.pending'),
                    fillColor: "#E26E27",
                    strokeColor: "#E26E27",
                    highlightFill: "#E26E27",
                    highlightStroke: "#E26E27",
                    data: value.pending
                });

                dataset.push({
                    label: Lang.get('js-components.available'),
                    fillColor: "#22BAA0",
                    strokeColor: "#22BAA0",
                    highlightFill: "#22BAA0",
                    highlightStroke: "#22BAA0",
                    data: value.available
                });

                dataset.push({
                    label: Lang.get('js-components.active'),
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
