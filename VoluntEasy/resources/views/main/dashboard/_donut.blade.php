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
    VE.ready(function () {
        function count(id) {
            return parseInt(document.getElementById(id).getAttribute('data-volunteers'), 10) || 0;
        }

        var data = [
            {value: count('newVolunteers'), color: '#12AFCB', highlight: '#30E0FF', label: Lang.get('js-components.new', 10)},
            {value: count('pendingVolunteers'), color: '#E26E27', highlight: '#FFE04E', label: Lang.get('js-components.pending', 10)},
            {value: count('availableVolunteers'), color: '#22BAA0', highlight: '#48FFE0', label: Lang.get('js-components.available', 10)},
            {value: count('activeVolunteers'), color: '#7a6fbe', highlight: '#BAAEFF', label: Lang.get('js-components.active', 10)},
            {value: count('blacklistedVolunteers'), color: '#f25656', highlight: '#FF7474', label: Lang.get('js-components.blacklisted', 10)}
        ];

        new Chart(document.getElementById('chart4').getContext('2d')).Doughnut(data, {
            segmentShowStroke: true,
            segmentStrokeColor: '#fff',
            segmentStrokeWidth: 2,
            animationSteps: 100,
            animationEasing: 'linear',
            animateRotate: true,
            animateScale: false,
            responsive: true
        });
    });
</script>
@append
