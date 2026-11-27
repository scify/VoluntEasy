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
    // load the volunteers by month and draw the bar chart
    VE.ready(function () {
        function bars(label, color, data) {
            return {label: label, fillColor: color, strokeColor: color, highlightFill: color, highlightStroke: color, data: data};
        }

        VE.http.get('/reports/volunteersByMonth').then(function (result) {
            var ctx = document.getElementById('chart2').getContext('2d');
            new Chart(ctx).Bar({
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
                    Lang.get('js-components.december')
                ],
                datasets: [
                    bars(Lang.get('js-components.new'), '#12AFCB', result.new),
                    bars(Lang.get('js-components.pending'), '#E26E27', result.pending),
                    bars(Lang.get('js-components.available'), '#22BAA0', result.available),
                    bars(Lang.get('js-components.active'), '#7a6fbe', result.active)
                ]
            }, {
                scaleBeginAtZero: true,
                scaleShowGridLines: true,
                scaleGridLineColor: 'rgba(0,0,0,.05)',
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                barShowStroke: true,
                barStrokeWidth: 2,
                barDatasetSpacing: 1,
                responsive: true
            });
        }).catch(VE.fail);
    });
</script>
@append
