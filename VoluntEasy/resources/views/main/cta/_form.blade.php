<input type="hidden" name="actionId" class="actionId" value="{{$action->id}}">
<input type="hidden" name="actionName" class="actionName" value="{{$action->description}}">

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            @if(isset($action->publicAction) && $action->publicAction->isActive==1)
                {!! Form::formInput('isActive', trans('entities/cta.activatePage'), $errors, ['class' => 'form-control', 'type' => 'checkbox', 'checked' => 'true']) !!}
            @else
                {!! Form::formInput('isActive', trans('entities/cta.activatePage'), $errors, ['class' => 'form-control','type' => 'checkbox', 'checked'=> 'false']) !!}
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            @if(isset($action->publicAction))
                {!! Form::formInput('public_description', trans('entities/cta.description').':', $errors, ['class' => 'form-control',
                'required' => 'true', 'type' => 'textarea', 'size'=> '2x5', 'value' => $action->publicAction->description]) !!}
            @else
                {!! Form::formInput('public_description', trans('entities/cta.description').':', $errors, ['class' => 'form-control',
                'required' => 'true', 'type' => 'textarea', 'size'=> '2x5']) !!}
            @endif
        </div>
    </div>
    <div class="col-md-6">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction ))
                        {!! Form::formInput('public_address', trans('entities/cta.address').':', $errors, ['class' =>
                        'form-control', 'required' => 'true', 'value' => $action->publicAction->address]) !!}
                    @else
                        {!! Form::formInput('public_address', trans('entities/cta.address').':', $errors, ['class' =>
                        'form-control', 'required' => 'true']) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                        {!! Form::formInput('public_map_url', trans('entities/cta.mapURL').':', $errors, ['class' => 'form-control', 'value' => $action->publicAction->map_url]) !!}
                    @else
                        {!! Form::formInput('public_map_url', trans('entities/cta.mapURL').':', $errors, ['class' => 'form-control', 'value' => 'http://']) !!}
                    @endif
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                        {!! Form::formInput('public_exec_name', trans('entities/cta.execName').':', $errors, ['class' =>
                        'form-control', 'value' => $action->publicAction->executive_name]) !!}
                    @else
                        {!! Form::formInput('public_exec_name', trans('entities/cta.execName').':', $errors, ['class' =>
                        'form-control']) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                        {!! Form::formInput('public_exec_email', trans('entities/cta.execEmail').':', $errors, ['class' =>
                        'form-control', 'value' => $action->publicAction->executive_email]) !!}
                    @else
                        {!! Form::formInput('public_exec_email', trans('entities/cta.execEmail').':', $errors, ['class' =>
                        'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                        {!! Form::formInput('public_exec_phone', trans('entities/cta.execPhone').':', $errors, ['class' =>
                        'form-control', 'value' => $action->publicAction->executive_phone]) !!}
                    @else
                        {!! Form::formInput('public_exec_phone', trans('entities/cta.execPhone').':', $errors, ['class' =>
                        'form-control']) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                        {!! Form::formInput('publicUrl', trans('entities/cta.pageURL').':', $errors, ['class' =>
                        'form-control', 'value' => $action->publicAction->public_url]) !!}
                    @else
                        {!! Form::formInput('publicUrl', trans('entities/cta.pageURL').':', $errors, ['class' =>
                        'form-control']) !!}
                    @endif
                    <small class="help-block">{{ trans('entities/cta.pageURLExpl') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>


@if(sizeof($action->tasks)>0)
    <div class="row">
        <div class="col-md-6">
            <h4>{{ trans('entities/cta.choosePublicSubtasks') }}<br/>
                <small>{{ trans('entities/cta.atLeastOneWorkDate') }}</small>
            </h4>
            <table class="ctaSubtasks">
                @foreach($action->tasks as $task)
                    @if((sizeof($task->todoSubtasks)+sizeof($task->doingSubtasks)+sizeof($task->doneSubtasks))>0)
                        <tr>
                            <td><h4>{{ trans('entities/tasks.task') }} {{ $task->name }}</h4></td>
                        </tr>
                        @foreach($task->todoSubtasks as $subtask)
                            <tr>
                                <td class="padding">
                                    @if(isset($publicSubtasks[$subtask->id]))
                                        {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                                        'form-control', 'type' => 'checkbox', 'checked' =>'true']) !!}
                                    @else
                                        {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                                        'form-control', 'type' => 'checkbox', 'checked' =>'false']) !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @foreach($task->doingSubtasks as $subtask)
                            <tr>
                                <td class="padding">
                                    @if(isset($publicSubtasks[$subtask->id]))
                                        {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                                        'form-control', 'type' => 'checkbox', 'checked' =>'true']) !!}
                                    @else
                                        {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                                        'form-control', 'type' => 'checkbox', 'checked' =>'false']) !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @foreach($task->doneSubtasks as $subtask)
                            <tr>
                                <td class="padding">
                                    @if(isset($publicSubtasks[$subtask->id]))
                                        {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                                        'form-control', 'type' => 'checkbox', 'checked' =>'true']) !!}
                                    @else
                                        {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                                        'form-control', 'type' => 'checkbox', 'checked' =>'false']) !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </table>
        </div>
    </div>
@endif
