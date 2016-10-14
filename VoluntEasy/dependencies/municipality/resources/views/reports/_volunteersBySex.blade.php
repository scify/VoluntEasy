<div class="row">
    <div class="col-md-12">
        <canvas id="volunteersBySex" height="150"></canvas>
    </div>
</div>
<div class="col-md-12">
    <div>
        <h4>@lang('default.legend')</h4>
        <i class="fa fa-square" style="color:#12AFCB"></i> @lang('default.men') |
        <i class="fa fa-square" style="color:#7a6fbe"></i> @lang('default.women')
        <input type="hidden" name="men" value="@lang('default.men')">
        <input type="hidden" name="women" value="@lang('default.women')">
    </div>
</div>

@section('footerScripts')
<script>


    //when page loads -> ajax call to retrieve volunteers
    //create the appropriate obj, then init the chart

    $.ajax({
        url: $("body").attr('data-url') + "/reports/volunteersBySex",
        method: 'GET',
        success: function (result) {


            var ctx = document.getElementById("volunteersBySex").getContext("2d");
            var data = [
                {
                    value: result.men,
                    color:"#12AFCB",
                    highlight: "#30E0FF",
                    label: $("input[name='men']").val()
                },
                {
                    value: result.women,
                    color: "#7a6fbe",
                    highlight: "#BAAEFF",
                    label: $("input[name='women']").val()
                }
            ]

            var myPieChart = new Chart(ctx).Pie(data,{
                segmentShowStroke : true,
                segmentStrokeColor : "#fff",
                segmentStrokeWidth : 2,
                animationSteps : 100,
                animationEasing : "linear",
                animateRotate : true,
                animateScale : false,
                responsive: true
            });

        }
    });
</script>
@append
