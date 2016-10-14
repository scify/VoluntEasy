<div class="row">
    <div class="col-md-12">
        <canvas id="volunteersByInterest" height="150"></canvas>
    </div>
</div>
<div class="col-md-12">
    <div>
        <h4>@lang('default.legend')</h4>
        <div class="interestChartLegend"></div>
    </div>
</div>

@section('footerScripts')
<script>

    //when page loads -> ajax call to retrieve volunteers
    //create the appropriate obj, then init the chart

    $.ajax({
        url: $("body").attr('data-url') + "/reports/volunteersByInterest",
        method: 'GET',
        success: function (result) {

            var data = [];
            $.each(result, function (key, value) {
                colorPair = Colors.random();
                data.push({
                    value: value.count,
                    color: Colors.pairs[colorPair][0],
                    highlight: Colors.pairs[colorPair][1],
                    label: value.description
                });

                //append the legend
                if(key>0)
                    $(".interestChartLegend").append(' | <i class="fa fa-square" style="color:' + Colors.pairs[colorPair][0] + ';"></i> ' + value.description);
                else
                    $(".interestChartLegend").append('<i class="fa fa-square" style="color:' + Colors.pairs[colorPair][0] + ';"></i> ' + value.description);
            });

            var ctx = document.getElementById("volunteersByInterest").getContext("2d");

            var myPieChart = new Chart(ctx).Pie(data, {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                animationSteps: 100,
                animationEasing: "linear",
                animateRotate: true,
                animateScale: false,
                responsive: true
            });

        }
    });


    /*
     * since we don't know how many cities the db will have,
     * we generate some random colors+hightlights in order to
     * make the chart pretty.
     * */
    Colors = {};
    Colors.pairs = {
        turqoise: ["#12AFCB", "#30E0FF"],
        yellow: ["#E26E27", "#FFE04E"],
        green: ["#22BAA0", "#48FFE0"],
        purple: ["#7a6fbe", "#BAAEFF"],
        red: ["#f25656", "#FF7474"],
        orange: ["#D95232", "#E0745B"],
        lightblue: ["#4BF", "#69C8FF"],
        pink: ["#D97AA5", "#E094B7"],
        grey: ["#666", "#848484"],
        darkred: ["#AE181F", "#BE464B"],
        orange2: ["#EE802F", "#F19958"],
        moodygrey: ["#5D83AA", "#7D9BBB"]
    };


    Colors.random = function () {
        var result;
        var count = 0;
        for (var prop in this.pairs)
            if (Math.random() < 1 / ++count)
                result = prop;
        return result;
    };
</script>
@append
