@extends('default')

@section('title')
    Προβολή Δράσης
@stop

@section('pageTitle')
    Προβολή Δράσης
@stop


@section('bodyContent')
    <div class="panel panel-white tree">
        <div class="panel-heading clearfix">
            <h2 class="panel-title">Στοιχεία Δράσης</h2>

            <div class="panel-control">
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"
                   data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab"
                                                              aria-expanded="false">Στοιχεία Δράσης</a></li>
                    <li role="presentation" class="active"><a href="#tab2" role="tab" data-toggle="tab" aria-expanded="true">Task
                            Board</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="tab1">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Δράση <span data-action-id="{{ $action->id }}"
                                                id="actionId">{{ $action->description }}</span></h3>

                                <p>
                                    <small>
                                        @foreach($branch as $key => $unit)
                                            @if($key < sizeof($branch)-1)
                                                <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
                                                <i
                                                        class="fa fa-angle-right"></i>
                                            @else
                                                <a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
                                            @endif
                                        @endforeach
                                    </small>
                                </p>
                                <p><strong>Περιγραφή:</strong> {{ $action->comments==null || $action->comments=='' ? '-' :
                                $action->comments }}</p>

                                <p><strong>Διάρκεια:</strong> {{ $action->start_date }} - {{ $action->end_date }}</p>

                                <p><strong>Αριθμός εθελοντών: {{ $action->volunteerSum  }} <i class="fa fa-question-circle" title="Υπολογίζεται δυναμικά ανάλογα με τον αριθμό εθελοντών που έχει δηλωθεί στα χρονοδιαγράμματα εργασίας των subtasks"></i></strong></p>
                            </div>
                            <div class="col-md-4">
                                <h3>Στοιχεία Υπευθύνου Δράσης</h3>
                                @if($action->email!=null && $action->email!='')
                                    <ul class="list-unstyled">
                                        <li class="user-list">
                                            <p class="msg-name">{{$action->name}}</p>

                                            <p class="msg-text"><i class="fa fa-envelope"></i> <a
                                                        href="mail:to{{ $action->email }}">{{
                                            $action->email }}</a>
                                                @if($action->phone_number!=null || $action->phone_number!='')
                                                    |<i class="fa fa-phone"></i> {{ $action->phone_number }}</p>
                                            @endif
                                        </li>
                                    </ul>
                                @else
                                    <p>Δεν έχει οριστεί υπεύθυνος δράσης</p>
                                @endif
                            </div>
                        </div>
                        @if(in_array($action->unit->id, $userUnits))
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ url('actions/edit/'.$action->id) }}" class="btn btn-success"><i
                                                class="fa fa-edit"></i> Επεξεργασία</a>
                                    <button onclick="deleteAction({{ $action->id }})" class="btn btn-danger"><i
                                                class="fa fa-trash"></i> Διαγραφή
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(sizeof($action->ratings)>0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading clearfix">
                                            <h4 class="panel-title">Συνολικές αξιολογήσεις για τη δράση</h4>

                                            <div class="panel-control">
                                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                                   title=""
                                                   class="panel-collapse" data-original-title="Expand/Collapse"><i
                                                            class="icon-arrow-down"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Για να δείτε τα αποτελέσματα πιο αναλυτικά, πατήστε <a
                                                                href="http://volunteasy/actions/ratings/{{ $action->id }}">εδώ</a>.
                                                    </p>

                                                    <div id="container"
                                                         style="min-width: 400px; height: 500px; margin:0 auto;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab2">
                        @include('main.tasks._board')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('footerScripts')
    <script src="{{ asset('assets/plugins/highcharts-4.1.9/highcharts.js')}}"></script>
    <script src="{{ asset('assets/plugins/highcharts-4.1.9/module/exporting.js')}}"></script>

    <script>
        $("#tree").jOrgChart({
            chartElement: '#unitsTree',
            chartClass: "jOrgChart actions",
            actions: true
        });


        //initialize user select
        $('#volunteerList').select2();

        // get the array of volunteers selected and save them
        $("#saveVolunteers").click(function () {
            //array of volunteers
            var volunteers = [];
            $('#volunteerList :selected').each(function (i, selected) {
                volunteers[i] = $(selected).val();
            });

            var volunteersUnits = {
                id: $("#saveVolunteers").attr('data-id'),
                volunteers: volunteers
            };

            $.ajax({
                url: $("body").attr('data-url') + '/actions/volunteers',
                method: 'POST',
                data: volunteersUnits,
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/actions/one/" + data;
                }
            });
        });


        //delete action and redirect to action list
        function deleteAction(id) {
            if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε τη δράση;") == true) {
                $.ajax({
                    url: $("body").attr('data-url') + '/actions/delete/' + id,
                    method: 'GET',
                    headers: {
                        'X-CSRF-Token': $('#token').val()
                    },
                    success: function () {
                        window.location = $("body").attr('data-url') + '/actions';
                    }
                });
            }
        }
        1

        //initialize rating chart
        $(function () {
            var id = $("#actionId").attr('data-action-id');

            $.ajax({
                url: $("body").attr('data-url') + '/api/actions/rating/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    initChart(data);
                }
            });
        });


        function initChart(data) {

            var series = [];
            $.each(data.series, function (key, value) {
                series.push(value);
            });

            $('#container').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                colors: ['#CA0020', '#F4A582', '#ccc', '#92C5DE', '#0571B0'],
                xAxis: {
                    categories: data.questions
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Συνολικές αξιολογήσεις'
                    }
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                series: series
            });
        }
    </script>
@append
