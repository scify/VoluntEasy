@extends('default')

@section('title')
    {{ trans('entities/actions.viewOne') }}
@stop

@section('pageTitle')
    {{ trans('entities/actions.viewOne') }}
@stop


@section('bodyContent')
    <div class="panel panel-white tree">
        <div class="panel-heading clearfix">
            <h2 class="panel-title">{{ trans('entities/actions.info') }}</h2>

            <div class="panel-control">
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"
                   data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="tab details" data-tab="details"><a href="#tab1" role="tab"
                                                                                      data-toggle="tab"
                                                                                      aria-expanded="false"
                                                                                      class="details">{{
                        trans('entities/actions.info') }}</a></li>


                    @if($configuration->hasTasks())
                        <li role="presentation" class="tab task_board" data-tab="task_board"><a href="#tab2" role="tab"
                                                                                                data-toggle="tab"
                                                                                                aria-expanded="false"
                                                                                                class="task_board">{{
                        trans('entities/actions.taskBoard') }}</a></li>
                        <li role="presentation" class="tab public_page" data-tab="public_page"><a href="#tab3"
                                                                                                  role="tab"
                                                                                                  data-toggle="tab"
                                                                                                  aria-expanded="false"
                                                                                                  class="public_page">{{
                        (isset($action->publicAction)) ?
                        trans('entities/actions.editPublicPage') : trans('entities/actions.viewPublicPage') }}</a></li>
                    @endif
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane details" id="tab1">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>{{ trans('entities/actions.action') }} <span data-action-id="{{ $action->id }}"
                                                                                 id="actionId"
                                                                                 data-unit-id="{{$action->unit_id}}"
                                                                                 data-is-permitted="{{$isPermitted ? 'true' :'false'}}">{{ $action->description }}</span>
                                </h3>

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
                                <p><strong>{{ trans('entities/actions.description') }}:</strong> {{ $action->comments==null
                                || $action->comments=='' ? '-' :
                                $action->comments }}</p>

                                <p><strong>{{ trans('entities/actions.duration') }}:</strong> {{ $action->start_date }}
                                    - {{
                                $action->end_date }}</p>

                                @if($configuration->hasTasks())
                                    <p><strong>{{ trans('entities/actions.volNum') }}:</strong> {{ $action->volunteerTaskSum }} <i
                                                    class="fa fa-question-circle"
                                                    title="{{ trans('entities/actions.volNumExplDynamic') }}"></i>
                                    </p>
                                @else<p><strong>{{ trans('entities/actions.volNum') }}:</strong> {{ $action->volunteer_sum==null || $action->volunteer_sum=="" ? '-' : $action->volunteer_sum }}
                                </p>
                                @endif

                                @if((isset($action->publicAction)))
                                    <p><strong>{{ trans('entities/actions.publicPageUrl') }}:</strong> <a
                                                href="{{ url('participate/'.$action->publicAction->public_url) }}"
                                                target="_blank">{{ url('participate/'.$action->publicAction->public_url) }}</a>
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h3>{{ trans('entities/actions.execInfo') }}</h3>
                                @if(sizeof($action->users)>0)
                                    <ul class="list-unstyled">
                                        @foreach($action->users as $user)
                                            <li class="user-list">
                                                <a href=" {{ url('users/one/'.$user->id) }}">{{$user->name}} {{ $user->last_name
                                        }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ trans('entities/actions.noExec') }}</p>
                                @endif


                                <h3>{{ trans('entities/actions.commExecInfo') }}</h3>
                                @if($action->email!=null && $action->email!='')
                                    <ul class="list-unstyled">
                                        <li class="user-list">
                                            <p>{{$action->name}} | <i class="fa fa-envelope"></i> <a
                                                        href="mail:to{{ $action->email }}">{{
                                            $action->email }}</a>
                                                @if($action->phone_number!=null || $action->phone_number!='')
                                                    |<i class="fa fa-phone"></i> {{ $action->phone_number }}</p>
                                            @endif
                                        </li>
                                    </ul>
                                @else
                                    <p>{{ trans('entities/actions.noCommExec') }}</p>
                                @endif
                            </div>
                        </div>
                        @if($isPermitted)
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ url('actions/edit/'.$action->id) }}" class="btn btn-success"><i
                                                class="fa fa-edit"></i> {{ trans('default.edit') }}</a>
                                    <button type="button" data-delete-action="{{ $action->id }}" class="btn btn-danger"><i
                                                class="fa fa-trash"></i> {{ trans('default.delete') }}
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{--
                        @if(sizeof($action->ratings)>0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading clearfix">
                                        <h4 class="panel-title">{{ trans('entities/actions.totalRatings') }}</h4>

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
                                                <p>{{ trans('entities/actions.viewRatings') }} <a
                                                        href="http://volunteasy/actions/ratings/{{ $action->id }}">{{
                                                        trans('entities/actions.here') }}</a>.
                                                </p>

                                                <canvas id="ratingsChart" width="800" height="500"
                                                        style="max-width:100%;"></canvas>
                                                <div id="ratingsChartLegend"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        --}}
                    </div>
                    <div role="tabpanel" class="tab-pane task_board" id="tab2">
                        @include('main.tasks._board')
                    </div>
                    <div role="tabpanel" class="tab-pane public_page" id="tab3">
                        @if(isset($action->publicAction))
                            @include('main.cta._edit_cta')
                        @else
                            @include('main.cta._create_cta')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$configuration->hasTasks())
        <div class="panel panel-white tree">
            <div class="panel-heading clearfix">
                <h2 class="panel-title">{{ trans('entities/volunteers.volunteers') }}</h2>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse"
                       data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @include('main.actions.partials._volunteers')
            </div>
        </div>
    @endif
@stop


@section('footerScripts')
    <script src="{{ asset('assets/js/todo.js')}}"></script>

    <script>
        VE.ready(function () {
            //delete action and redirect to action list
            VE.on(document, 'click', '[data-delete-action]', function (event, el) {
                if (!VE.confirm(Lang.get('js-components.deleteAction'))) return;
                VE.http.post('/actions/delete/' + el.getAttribute('data-delete-action'))
                    .then(function () { window.location = VE.url('/actions'); })
                    .catch(VE.fail);
            });

            //rating chart (only when the ratings panel is shown)
            var canvas = document.getElementById('ratingsChart');
            if (canvas) {
                VE.http.get('/api/actions/rating/' + document.getElementById('actionId').getAttribute('data-action-id'))
                    .then(initChart)
                    .catch(VE.fail);
            }

            function initChart(data) {
                var colors = ['#CA0020', '#F4A582', '#cccccc', '#92C5DE', '#0571B0'];
                var series = Object.keys(data.series).map(function (key) { return data.series[key]; });
                var chartData = {
                    labels: data.questions,
                    datasets: series.map(function (serie, i) {
                        return {
                            label: serie.name,
                            fillColor: colors[i % colors.length],
                            strokeColor: colors[i % colors.length],
                            highlightFill: colors[i % colors.length],
                            highlightStroke: colors[i % colors.length],
                            data: serie.data
                        };
                    })
                };
                var chart = new Chart(canvas.getContext('2d')).Bar(chartData, {
                    responsive: true,
                    scaleBeginAtZero: true,
                    multiTooltipTemplate: '<%= datasetLabel %>: <%= value %>',
                    legendTemplate: '<ul class="list-inline"><% for (var i = 0; i < datasets.length; i++) { %>' +
                        '<li><span style="display:inline-block;width:12px;height:12px;background-color:<%= datasets[i].fillColor %>"></span> ' +
                        '<%= datasets[i].label %></li><% } %></ul>'
                });
                document.getElementById('ratingsChartLegend').innerHTML = chart.generateLegend();
            }
        });
    </script>
@append