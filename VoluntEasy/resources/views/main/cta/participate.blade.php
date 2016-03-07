<!DOCTYPE html>
<?php $lang = "/default."; ?> {{--  resource label path --}}
<html>
<head>
    <!-- Title -->
    <title>Call to action | {{trans($lang.'title')}}</title>

    @include('template.default.headerIncludes')
</head>
<body class="page-login cta" data-url="{!! URL::to('/') !!}">
<main class="page-content" style="background-color:#F1F4F9;">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-8 center">
                    <div class="panel panel-white">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/ekpizo.png') }}" style="width:100%;"/>
                                </div>
                            </div>
                            @if(isset($publicAction) && $publicAction!=null)
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Κάλεσμα εθελοντών στη δράση <strong>{{ $action->description }}</strong></h2>

                                    <p><i class="fa fa-calendar"></i> <strong>{{ $action->start_date }}</strong> έως
                                        <strong>{{ $action->end_date }}</strong>
                                        @if($publicAction->address!=null && $publicAction->address!='')
                                        @if($publicAction->map_url!=null && $publicAction->map_url!='')
                                        <i class="fa fa-map-marker" style="margin-left:10px;"></i> <a
                                            href="{{ $publicAction->map_url }}"
                                            target="_blank">{{ $publicAction->address}}</a></p>
                                    @else
                                    <i class="fa fa-map-marker" style="margin-left:10px;"></i> {{ $publicAction->address
                                    }}</p>
                                    @endif
                                    @endif

                                    <p>{{ $publicAction->description }}</p>

                                    @if($publicAction->executive_name!=null && $publicAction->executive_name!='')
                                    <p>Υπεύθυνος επικοινωνίας: {{ $publicAction->executive_name }}
                                        @if($publicAction->executive_phone!=null && $publicAction->executive_phone!='')
                                        , {{ $publicAction->executive_phone }}
                                        @endif
                                        @if($publicAction->executive_email!=null && $publicAction->executive_email!='')
                                        , <a href="mailto:{{ $publicAction->executive_email }}">{{
                                            $publicAction->executive_email }}</a>
                                        @endif
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    {{-- <img src="{{ asset('assets/images/volunteer_hands.png') }}"
                                              style="width:100%;"/> --}}
                                </div>
                            </div>

                            {!! Form::open(['id' => 'volunteerInterested', 'method' => 'POST', 'action' =>
                            ['CTAController@volunteerInterested']]) !!}
                            <input type="hidden" name="publicActionId" value="{{$publicAction->id}}">

                            @foreach($tasks as $task)
                            <table class="table tasks">
                                <tr>
                                    <td colspan="2">
                                        <div class="task-info">
                                            <h3>{{ $task->name }}</h3>

                                            <p>{{ $task->description }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($task->ctaSubtasks as $subtask)
                                @if(sizeof($subtask->workDates)>0)
                                <tr>
                                    <td class="task col-md-3">
                                        <div class="subtask-info">{{ $subtask->name }}</div>
                                        <div class="subtask-description">{{ $subtask->description }}</div>
                                    </td>
                                    <td class="taskDate">
                                        @foreach($subtask->workDates as $date)
                                        <div class="dateTime">
                                            <label {{ sizeof($date->volunteers)==$date->volunteer_sum ? 'class=disabled' : ''}} >
                                                @if($date->volunteer_sum==sizeof($date->volunteers))
                                                {!! Form::formInput('dates['.$date->id.']', '', $errors, ['class'
                                                =>'form-control checkbox', 'type' => 'checkbox', 'checked' =>'false',
                                                'disabled' => 'disabled', 'readonly']) !!}
                                                @else
                                                {!! Form::formInput('dates['.$date->id.']', '', $errors, ['class'
                                                =>'form-control checkbox', 'type' => 'checkbox', 'checked' =>'false'])
                                                !!}
                                                @endif
                                                <div class="dates"> {{$date->from_date}} <br/>  <span
                                                        class="hours">{{ $date->from_hour }}-{{ $date->to_hour }}
                                                    </span>
                                                    @if(sizeof($date->volunteers)==$date->volunteer_sum)
                                                    <br/><span class="text-success">{{ sizeof($date->volunteers) }}/{{ $date->volunteer_sum }}
                                                   εθελοντές</span>
                                                    @else
                                                    <br/>{{ sizeof($date->volunteers) }}/{{ $date->volunteer_sum }}
                                                    εθελοντές
                                                    @endif
                                                </div>
                                            </label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                            @endforeach

                            @if($errors->has('dates'))
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-danger">Παρακαλώ επιλέξτε τουλάχιστον μία θέση.</p>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Αφού επιλέξετε τις θέσεις που σας ενδιαφέρουν, συμπληρώστε τα στοιχεία σας για
                                        να επικοινωνήσουμε μαζί σας.</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::formInput('first_name', 'Όνομα:', $errors, ['class' => 'form-control',
                                        'id' =>
                                        'first_name', 'required' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::formInput('last_name', 'Επώνυμο:', $errors, ['class' =>
                                        'form-control', 'id' =>
                                        'last_name', 'required' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::formInput('email', 'Email:', $errors, ['class' => 'form-control',
                                        'required' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::formInput('phone_number', 'Τηλέφωνο επικοινωνίας:', $errors, ['class'
                                        => 'form-control',
                                        'required' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::formInput('comments', 'Σχόλια:', $errors, ['class' => 'form-control',
                                        'type' => 'textarea', 'size' =>'2x2']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    {!! Form::submit('Αποστολή', ['class' => 'btn btn-success width-130']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Η σελίδα δεν βρέθηκε</h3>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        </div>
        <!-- Main Wrapper -->
    </div>
    <!-- Page Inner -->

</main>
<!-- Page Content -->
<script src="{{ asset('assets/plugins/jquery/jquery-2.1.3.min.js')}}"></script>
<script>
    $('.checkbox').uniform();
</script>
</body>
</html>
