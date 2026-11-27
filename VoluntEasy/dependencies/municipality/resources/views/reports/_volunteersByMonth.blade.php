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
            <i class="fa fa-square" style="color:#22BAA0;"></i> Διαθέσιμοι |
            <i class="fa fa-square" style="color:#E26E27;"></i> Υπό ένταξη|
            <i class="fa fa-square" style="color:#6a5fac;"></i> Ενεργοί |
            <i class="fa fa-square" style="color:#12AFCB;"></i> Νέοι
        </div>
    </div>
</div>

@section('footerScripts')
<script>
    // load the volunteers by month, then show a year dropdown and the bar chart
    VE.ready(function () {
        var volunteersByMonth = {};
        var byMonthChart = null;
        var yearsDropDown = document.getElementById('yearsDropDown');

        function dataset(year) {
            var value = volunteersByMonth[year];
            if (!value) return [];
            return [
                bars('Νέοι', '#12AFCB', value.new),
                bars('Υπό Ένταξη', '#E26E27', value.pending),
                bars('Διαθέσιμοι', '#22BAA0', value.available),
                bars('Ενεργοί', '#7a6fbe', value.active)
            ];
        }

        function bars(label, color, data) {
            return {label: label, fillColor: color, strokeColor: color, highlightFill: color, highlightStroke: color, data: data};
        }

        function initChart(datasets) {
            var ctx = document.getElementById('volunteersByMonth').getContext('2d');
            byMonthChart = new Chart(ctx).Bar({
                labels: ["Ιανουάριος", "Φεβρουάριος", "Μάρτιος", "Απρίλιος", "Μάιος", "Ιούνιος", "Ιούλιος", "Αύγουστος", "Σεπτέμβριος", "Οκτώβριος", "Νοέμβριος", "Δεκέμβριος"],
                datasets: datasets
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
        }

        VE.http.get('/reports/volunteersByMonth').then(function (result) {
            volunteersByMonth = result || {};

            // the dropdown to filter the report by year, with the current year selected
            var currentYear = String(new Date().getFullYear());
            yearsDropDown.insertAdjacentHTML('beforeend', '<label>' + VE.esc('Έτος') + '</label><select class="form-control">' +
                Object.keys(volunteersByMonth).map(function (year) {
                    return '<option value="' + VE.esc(year) + '"' + (year === currentYear ? ' selected' : '') + '>' + VE.esc(year) + '</option>';
                }).join('') + '</select>');

            initChart(dataset(currentYear));
        }).catch(VE.fail);

        // when the user selects a different year, show the data of that year
        yearsDropDown.addEventListener('change', function (event) {
            if (byMonthChart) byMonthChart.destroy();
            initChart(dataset(event.target.value));
        });
    });
</script>
@append
