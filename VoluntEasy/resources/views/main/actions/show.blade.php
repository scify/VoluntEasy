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
                                                                                      class="details">{{ trans('entities/actions.info') }}</a></li>
                    <li role="presentation" class="tab task_board" data-tab="task_board"><a href="#tab2" role="tab"
                                                                                            data-toggle="tab"
                                                                                            aria-expanded="false"
                                                                                            class="task_board">{{ trans('entities/actions.taskBoard') }}</a></li>
                    <li role="presentation" class="tab public_page" data-tab="public_page"><a href="#tab3" role="tab"
                                                                                              data-toggle="tab"
                                                                                              aria-expanded="false"
                                                                                              class="public_page">{{ (isset($action->publicAction)) ?
                            trans('entities/actions.editPublicPage') :  trans('entities/actions.viewPublicPage') }}</a></li>
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
                                <p><strong>{{ trans('entities/actions.description') }}:</strong> {{ $action->comments==null || $action->comments=='' ? '-' :
                                $action->comments }}</p>

                                <p><strong>{{ trans('entities/actions.duration') }}:</strong> {{ $action->start_date }} - {{ $action->end_date }}</p>

                                <p><strong>{{ trans('entities/actions.volNum') }}: {{ $action->volunteerSum }} <i
                                                class="fa fa-question-circle"
                                                title="{{ trans('entities/actions.volNumExplDynamic') }}"></i></strong>
                                </p>

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
                                                <a href=" {{ url('users/one/'.$user->id) }}">{{$user->name}}</a>
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
                                    <button onclick="deleteAction({{ $action->id }})" class="btn btn-danger"><i
                                                class="fa fa-trash"></i> {{ trans('default.delete') }}
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(sizeof($action->ratings)>0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading clearfix">
                                            <h4 class="panel-title">{{ trans('default.totalRatings') }}</h4>

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
                                                    <p>{{ trans('default.viewRatings') }}  <a
                                                                href="http://volunteasy/actions/ratings/{{ $action->id }}">{{ trans('default.here') }}</a>.
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
@stop


@section('footerScripts')
    <script src="{{ asset('assets/plugins/highcharts-4.1.9/highcharts.js')}}"></script>
    <script src="{{ asset('assets/plugins/highcharts-4.1.9/module/exporting.js')}}"></script>
    <script src="{{ asset('assets/js/todo.js')}}"></script>

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
            if (confirm(Lang.get('js-components.deleteAction')) == true) {
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
                        text: Lang.get('js-components.totalRatings')
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
