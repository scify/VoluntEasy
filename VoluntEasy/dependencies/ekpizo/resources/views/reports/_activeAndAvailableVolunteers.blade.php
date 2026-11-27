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
    // load the active and available volunteers of each unit and draw the bar chart
    VE.ready(function () {
        function bars(label, color, data) {
            return {label: label, fillColor: color, strokeColor: color, highlightFill: color, highlightStroke: color, data: data};
        }

        VE.http.get('/reports/activeAndAvailableVolunteersByUnit').then(function (result) {
            var units = (result && result.units) || [];
            var ctx = document.getElementById('activeAndAvailable').getContext('2d');
            new Chart(ctx).Bar({
                labels: (result && result.unitNames) || [],
                datasets: [
                    bars(Lang.get('js-components.available'), '#22BAA0', units.map(function (unit) { return unit.availableVolunteers; })),
                    bars(Lang.get('js-components.active'), '#7a6fbe', units.map(function (unit) { return unit.activeVolunteers; }))
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
