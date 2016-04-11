<div class="form-group">
 @if (isset($volunteer))
                {!! Form::formInput('howYouLearned', trans('entities/volunteers.howYouLearned'), $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $howYouLearned, 'key' =>
                $volunteer->how_you_learned_id]) !!}
@else
                {!! Form::formInput('howYouLearned', trans('entities/volunteers.howYouLearned'), $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $howYouLearned]) !!}
@endif
</div>

<div class="form-group">
 @if (isset($volunteer))
                {!! Form::formInput('howYouLearned2', trans('entities/volunteers.howYouLearned2'), $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $howYouLearned2, 'key' =>
                $volunteer->how_you_learned2_id]) !!}
@else
                {!! Form::formInput('howYouLearned2', trans('entities/volunteers.howYouLearned2'), $errors, ['class' =>
                'form-control', 'type' => 'select', 'value' => $howYouLearned2]) !!}
@endif
</div>
