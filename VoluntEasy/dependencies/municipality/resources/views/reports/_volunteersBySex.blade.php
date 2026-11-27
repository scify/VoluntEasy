<div class="row">
    <div class="col-md-12">
        <canvas id="volunteersBySex" height="150"></canvas>
    </div>
</div>
<div class="col-md-12">
    <div>
        <h4>Υπόμνημα</h4>
        <i class="fa fa-square" style="color:#12AFCB"></i> Άνδρες |
        <i class="fa fa-square" style="color:#7a6fbe"></i> Γυναίκες
    </div>
</div>

@section('footerScripts')
<script>
    // load the volunteers by sex and draw the pie chart
    VE.ready(function () {
        VE.http.get('/reports/volunteersBySex').then(function (result) {
            var ctx = document.getElementById('volunteersBySex').getContext('2d');
            var data = [
                {
                    value: result.men,
                    color: '#12AFCB',
                    highlight: '#30E0FF',
                    label: 'Άνδρες'
                },
                {
                    value: result.women,
                    color: '#7a6fbe',
                    highlight: '#BAAEFF',
                    label: 'Γυναίκες'
                }
            ];

            new Chart(ctx).Pie(data, {
                segmentShowStroke: true,
                segmentStrokeColor: '#fff',
                segmentStrokeWidth: 2,
                animationSteps: 100,
                animationEasing: 'linear',
                animateRotate: true,
                animateScale: false,
                responsive: true
            });
        }).catch(VE.fail);
    });
</script>
@append
