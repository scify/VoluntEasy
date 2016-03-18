<div class="row">
    <div class="col-md-12">
        <canvas id="chart2" height="150"></canvas>
    </div>
</div>
<div class="row top-margin">
    <div class="col-md-12">
        <div class="pull-right">
            <i class="fa fa-square" style="color:#22BAA0;"></i> {{ trans('entities/volunteers.available') }} |
            <i class="fa fa-square" style="color:#E26E27;"></i>{{ trans('entities/volunteers.pending') }} |
            <i class="fa fa-square" style="color:#6a5fac;"></i> {{ trans('entities/volunteers.active') }} |
            <i class="fa fa-square" style="color:#12AFCB;"></i> {{ trans('entities/volunteers.new') }}
        </div>
    </div>
</div>

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
                datasets: [
                    {
                        label: Lang.get('js-components.new'),
                        fillColor: "#12AFCB",
                        strokeColor: "#12AFCB",
                        highlightFill: "#12AFCB",
                        highlightStroke: "#12AFCB",
                        data: result.new
                    },
                    {
                        label: Lang.get('js-components.pending'),
                        fillColor: "#E26E27",
                        strokeColor: "#E26E27",
                        highlightFill: "#E26E27",
                        highlightStroke: "#E26E27",
                        data: result.pending
                    },
                    {
                        label: Lang.get('js-components.available'),
                        fillColor: "#22BAA0",
                        strokeColor: "#22BAA0",
                        highlightFill: "#22BAA0",
                        highlightStroke: "#22BAA0",
                        data: result.available
                    },
                    {
                        label: Lang.get('js-components.active'),
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
