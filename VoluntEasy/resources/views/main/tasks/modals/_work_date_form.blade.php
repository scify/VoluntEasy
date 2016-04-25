<div class="row">
    <div class="col-md-6 comments">
        <div class="form-group">
            <input type="hidden" name="subtaskId" class="subtaskId" value="">
            {!! Form::formInput('comments', trans('entities/subtasks.description').':', $errors, ['class' => 'form-control shift_comments', 'required' => 'true']) !!}
            <p class="comments_err text-danger" style="display:none;">{{ trans('entities/subtasks.fillField') }}</p>
        </div>
    </div>
    <div class="col-md-6 volunteers">
        <div class="form-group">
            {!! Form::formInput('volunteerSum', trans('entities/subtasks.volunteersNeeded').':', $errors, ['class'
                        =>
                        'form-control volunteerSum']) !!}
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 shift">
        <div class="form-group">
            <input type="hidden" name="dateId" class="dateId" value="">
            {!! Form::formInput('dateFrom', trans('entities/subtasks.date').':', $errors, ['class' =>
            'form-control date datetime dateFrom',
            'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date,
            'data-date-format' => 'dd/mm/yyyy']) !!}
        </div>
    </div>
    <div class="col-md-4 workTime">
        <div class="form-group">
            {!! Form::formInput('hourFrom', trans('entities/subtasks.hourFrom').':', $errors, ['class' =>
                        'form-control
                        time datetime hourFrom']) !!}
        </div>
    </div>
    <div class="col-md-4 workTime">
        <div class="form-group">
            {!! Form::formInput('hourTo', trans('entities/subtasks.hourTo').':', $errors, ['class' => 'form-control time datetime hourTo']) !!}
        </div>
    </div>
</div>


@if(isset($showVolunteers) && $showVolunteers)
<div class="row">
    <div class="col-sm-5">
        <p>{{ trans('entities/subtasks.availableVolunteers') }}:</p>
        <select name="from" class="form-control sub_volunteers" id="sub_volunteers" size="8" multiple="multiple">
        </select>
    </div>

    <div class="col-sm-2" style="padding-top:35px;">
        <button type="button" id="sub_volunteers_rightAll" class="btn btn-block"><i
                    class="glyphicon glyphicon-forward"></i>
        </button>
        <button type="button" id="sub_volunteers_rightSelected" class="btn btn-block"><i
                    class="glyphicon glyphicon-chevron-right"></i></button>
        <button type="button" id="sub_volunteers_leftSelected" class="btn btn-block"><i
                    class="glyphicon glyphicon-chevron-left"></i></button>
        <button type="button" id="sub_volunteers_leftAll" class="btn btn-block"><i
                    class="glyphicon glyphicon-backward"></i>
        </button>
    </div>

    <div class="col-sm-5">
        <p>{{ trans('entities/subtasks.assignedVolunteers') }}:</p>
        <select name="to" id="sub_volunteers_to" class="form-control" size="8" multiple="multiple">
        </select>
    </div>
</div>

<div class="row top-margin ctaVolunteers">
    <div class="col-md-12">
        <p>{{ trans('entities/subtasks.interestedVolunteers') }}:</p>
        <table class="table table-condensed table-bordered ">
            <thead>
            <th>{{ trans('entities/subtasks.volunteer') }}</th>
            <th>{{ trans('entities/subtasks.info') }}</th>
            <th>{{ trans('entities/subtasks.comments') }}</th>
            <th>{{ trans('entities/subtasks.actions') }}</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


@section('footerScripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#editWorkDate #sub_volunteers").multiselect();
        });
    </script>
@append

@endif
