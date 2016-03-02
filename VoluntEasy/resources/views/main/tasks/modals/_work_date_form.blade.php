<div class="row">
    <div class="col-md-6 comments">
        <div class="form-group">
            <input type="hidden" name="subtaskId" class="subtaskId" value="">
            {!! Form::formInput('comments', 'Περιγραφή:', $errors, ['class' => 'form-control work_date_comments', 'required' => 'true']) !!}
            <p class="comments_err text-danger" style="display:none;">Συμπληρώστε το πεδίο.</p>
        </div>
    </div>
    <div class="col-md-3 volunteers">
        <div class="form-group">
            {!! Form::formInput('volunteerSum', 'Αριθμός απαιτούμενων εθελοντών:', $errors, ['class'
                        =>
                        'form-control volunteerSum']) !!}
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-2 workDate">
        <div class="form-group">
            <input type="hidden" name="dateId" class="dateId" value="">
            {!! Form::formInput('dateFrom', 'Ημερομηνία:', $errors, ['class' =>
            'form-control date datetime dateFrom',
            'data-date-start-date' => $action->start_date, 'data-date-end-date' => $action->end_date,
            'data-date-format' => 'dd/mm/yyyy']) !!}
        </div>
    </div>
    <div class="col-md-2 workTime">
        <div class="form-group">
            {!! Form::formInput('hourFrom', 'Ώρα από:', $errors, ['class' =>
                        'form-control
                        time datetime hourFrom']) !!}
        </div>
    </div>
    <div class="col-md-2 workTime">
        <div class="form-group">
            {!! Form::formInput('hourTo', 'Ώρα έως:', $errors, ['class' => 'form-control time datetime hourTo']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <p>Διαθέσιμοι εθελοντές</p>
        <select name="from"  class="form-control sub_volunteers" size="8" multiple="multiple">
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
        <p>Ανατεθειμένοι εθελοντές</p>
        <select name="to" id="sub_volunteers_to" class="form-control" size="8" multiple="multiple">
            <option value="1">C++</option>
        </select>
    </div>
</div>



@section('footerScripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".sub_volunteers").multiselect();
        });
    </script>
@append