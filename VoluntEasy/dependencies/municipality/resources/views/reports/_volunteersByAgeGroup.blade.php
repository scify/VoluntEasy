<div class="row">
    <div class="col-md-12">
        <canvas id="volunteersByAgeGroup" height="150"></canvas>
    </div>
</div>
<div class="col-md-12">
    <div>
        <h4>Υπόμνημα</h4>

        <div class="ageChartLegend"></div>
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

        // a fixed color for each known value
        var colors = {
            '<18': 'turqoise',
            '18-24': 'purple',
            '25-34': 'green',
            '35-49': 'yellow',
            '50-64': 'pink',
            '>65': 'orange'
        };

        VE.http.get('/reports/volunteersByAgeGroup').then(function (result) {
            var data = [];
            var legend = [];
            (result || []).forEach(function (value) {
                var pair = pairs[colors[value.ageGroup] || randomPair()];
                data.push({
                    value: value.count,
                    color: pair[0],
                    highlight: pair[1],
                    label: value.ageGroup
                });
                legend.push('<i class="fa fa-square" style="color:' + pair[0] + ';"></i> ' + VE.esc(value.ageGroup));
            });
            document.querySelector('.ageChartLegend').insertAdjacentHTML('beforeend', legend.join(' | '));

            var ctx = document.getElementById('volunteersByAgeGroup').getContext('2d');
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
