<div class="row">
    <div class="col-md-12">
        <canvas id="volunteersByCity" height="150"></canvas>
    </div>
</div>
<div class="col-md-12">
    <div>
        <h4>Υπόμνημα</h4>
        <div class="cityChartLegend"></div>
    </div>
</div>

@section('footerScripts')
<script>
    // load the data, then draw the pie chart and its legend
    VE.ready(function () {
        var pairs = {
            turqoise: ['#12AFCB', '#30E0FF'],
            yellow: ['#E26E27', '#FFE04E'],
            green: ['#22BAA0', '#48FFE0'],
            purple: ['#7a6fbe', '#BAAEFF'],
            red: ['#f25656', '#FF7474'],
            orange: ['#D95232', '#E0745B'],
            lightblue: ['#4BF', '#69C8FF'],
            pink: ['#D97AA5', '#E094B7'],
            grey: ['#666', '#848484'],
            darkred: ['#AE181F', '#BE464B'],
            orange2: ['#EE802F', '#F19958'],
            moodygrey: ['#5D83AA', '#7D9BBB']
        };

        // a random color pair (we do not know how many values the db has)
        function randomPair() {
            var names = Object.keys(pairs);
            return names[Math.floor(Math.random() * names.length)];
        }

        VE.http.get('/reports/volunteersByCity').then(function (result) {
            var data = [];
            var legend = [];
            (result || []).forEach(function (value) {
                var pair = pairs[randomPair()];
                data.push({
                    value: value.count,
                    color: pair[0],
                    highlight: pair[1],
                    label: value.city
                });
                legend.push('<i class="fa fa-square" style="color:' + pair[0] + ';"></i> ' + VE.esc(value.city));
            });
            document.querySelector('.cityChartLegend').insertAdjacentHTML('beforeend', legend.join(' | '));

            var ctx = document.getElementById('volunteersByCity').getContext('2d');
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
