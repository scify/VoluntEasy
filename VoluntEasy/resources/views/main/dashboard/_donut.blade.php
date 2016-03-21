<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <div>
            <canvas id="chart4" height="150"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div>
            <h4>{{ trans('default.legend') }}</h4>
           <i class="fa fa-square" style="color:#12AFCB"></i> <span id="newVolunteers" data-volunteers="{{ $new }}">{{ trans('entities/volunteers.new') }}</span><br/>
           <i class="fa fa-square" style="color:#E26E27"></i> <span id="pendingVolunteers" data-volunteers="{{ $pending }}">{{ trans('entities/volunteers.pending') }}</span><br/>
           <i class="fa fa-square" style="color:#22BAA0"></i> <span id="availableVolunteers" data-volunteers="{{ $available }}">{{ trans('entities/volunteers.available') }}</span><br/>
           <i class="fa fa-square" style="color:#7a6fbe"></i> <span id="activeVolunteers" data-volunteers="{{ $active }}">{{ trans('entities/volunteers.active') }}</span><br/>
           <i class="fa fa-square" style="color:#f25656"></i> <span id="blacklistedVolunteers" data-volunteers="{{ $blacklisted }}">{{ trans('entities/volunteers.blacklisted') }}</span><br/>
           <p><strong>{{ trans('entities/volunteers.volunteerSum') }}: {{ $new + $pending + $available + $active + $blacklisted}}</strong></p>
        </div>
    </div>
</div>



@section('footerScripts')
<script>

    var ctx4 = document.getElementById("chart4").getContext("2d");
    var data4 = [
        {
            value: parseInt($("#newVolunteers").attr('data-volunteers')),
            color:"#12AFCB",
            highlight: "#30E0FF",
            label: Lang.get('js-components.new', 10)
        },
        {
            value: parseInt($("#pendingVolunteers").attr('data-volunteers')),
            color: "#E26E27",
            highlight: "#FFE04E",
            label: Lang.get('js-components.pending', 10)
        },
        {
            value: parseInt($("#availableVolunteers").attr('data-volunteers')),
            color: "#22BAA0",
            highlight: "#48FFE0",
            label: Lang.get('js-components.available', 10)
        },
        {
            value: parseInt($("#activeVolunteers").attr('data-volunteers')),
            color: "#7a6fbe",
            highlight: "#BAAEFF",
            label: Lang.get('js-components.active', 10)
        },
        {
            value: parseInt($("#blacklistedVolunteers").attr('data-volunteers')),
            color: "#f25656",
            highlight: "#FF7474",
            label: Lang.get('js-components.blacklisted', 10)
        }
    ];

    var myDoughnutChart = new Chart(ctx4).Doughnut(data4,{
        segmentShowStroke : true,
        segmentStrokeColor : "#fff",
        segmentStrokeWidth : 2,
        animationSteps : 100,
        animationEasing : "linear",
        animateRotate : true,
        animateScale : false,
        responsive: true
    });


</script>
@append
