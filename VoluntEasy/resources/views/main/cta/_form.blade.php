<input type="hidden" name="actionId" class="actionId" value="{{$action->id}}">
<input type="hidden" name="actionName" class="actionName" value="{{$action->description}}">

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            @if(isset($action->publicAction))
            {!! Form::formInput('public_description', 'Περιγραφή:', $errors, ['class' => 'form-control',
            'required' => 'true', 'type' => 'textarea', 'size'=> '2x5', 'value' => $action->publicAction->description]) !!}
            @else
            {!! Form::formInput('public_description', 'Περιγραφή:', $errors, ['class' => 'form-control',
            'required' => 'true', 'type' => 'textarea', 'size'=> '2x5']) !!}
            @endif
        </div>
    </div>
    <div class="col-md-6">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction ))
                    {!! Form::formInput('public_address', 'Διεύθυνση/Χώρος διεξαγωγής:', $errors, ['class' =>
                    'form-control', 'required' => 'true', 'value' => $action->publicAction->address]) !!}
                    @else
                    {!! Form::formInput('public_address', 'Διεύθυνση/Χώρος διεξαγωγής:', $errors, ['class' =>
                    'form-control', 'required' => 'true']) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                    {!! Form::formInput('public_map_url', 'URL χάρτη:', $errors, ['class' => 'form-control', 'value' => $action->publicAction->map_url]) !!}
                    @else
                    {!! Form::formInput('public_map_url', 'URL χάρτη:', $errors, ['class' => 'form-control', 'value' => 'http://']) !!}
                    @endif
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                    {!! Form::formInput('public_exec_name', 'Όνομα υπεύθυνου επικοινωνίας:', $errors, ['class' =>
                    'form-control', 'value' => $action->publicAction->executive_name]) !!}
                    @else
                    {!! Form::formInput('public_exec_name', 'Όνομα υπεύθυνου επικοινωνίας:', $errors, ['class' =>
                    'form-control']) !!}
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                    {!! Form::formInput('public_exec_email', 'Email υπεύθυνου επικοινωνίας:', $errors, ['class' =>
                    'form-control', 'value' => $action->publicAction->executive_email]) !!}
                    @else
                    {!! Form::formInput('public_exec_email', 'Email υπεύθυνου επικοινωνίας:', $errors, ['class' =>
                    'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    @if(isset($action->publicAction))
                    {!! Form::formInput('public_exec_phone', 'Τηλέφωνο υπεύθυνου επικοινωνίας:', $errors, ['class' =>
                    'form-control', 'value' => $action->publicAction->executive_phone]) !!}
                    @else
                    {!! Form::formInput('public_exec_phone', 'Τηλέφωνο υπεύθυνου επικοινωνίας:', $errors, ['class' =>
                    'form-control']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@if(sizeof($action->tasks)>0)
<div class="row">
    <div class="col-md-6">
        <h4>Επιλέξτε ποια subtasks θέλετε να εμφανίζονται στη δημόσια σελίδα, και προσθέστε προαιρετικά μια
            περιγραφή.</h4>
        <table class="table table-condensed table-bordered">
            @foreach($action->tasks as $task)
            @if((sizeof($task->todoSubtasks)+sizeof($task->doingSubtasks)+sizeof($task->doneSubtasks))>0)
            <tr>
                <td colspan="2"><h4>Task {{ $task->name }}</h4></td>
            </tr>
            @foreach($task->todoSubtasks as $subtask)
            <tr>
                <td>
                    @if(isset($publicSubtasks[$subtask->id]))
                    {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'checked' =>'true']) !!}
                    @else
                    {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'checked' =>'false']) !!}
                    @endif
                </td>
                <td>
                    @if(isset($publicSubtasks[$subtask->id]))
                    {!! Form::formInput('subtasks['.$subtask->id.'][comments]', '', $errors, ['class' =>
                    'form-control', 'value' => $publicSubtasks[$subtask->id]]) !!}
                    @else
                    {!! Form::formInput('subtasks['.$subtask->id.'][comments]', '', $errors, ['class' =>
                    'form-control', 'placeholder' => 'Περιγραφή']) !!}
                    @endif
                </td>
            </tr>
            @endforeach
            @foreach($task->doingSubtasks as $subtask)
            <tr>
                <td>
                    @if(isset($publicSubtasks[$subtask->id]))
                    {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'checked' =>'true']) !!}
                    @else
                    {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'checked' =>'false']) !!}
                    @endif
                </td>
                <td>
                    @if(isset($publicSubtasks[$subtask->id]))
                    {!! Form::formInput('subtasks['.$subtask->id.'][comments]', '', $errors, ['class' =>
                    'form-control', 'value' => $publicSubtasks[$subtask->id]]) !!}
                    @else
                    {!! Form::formInput('subtasks['.$subtask->id.'][comments]', '', $errors, ['class' =>
                    'form-control', 'placeholder' => 'Περιγραφή']) !!}
                    @endif
                </td>
            </tr>
            @endforeach
            @foreach($task->doneSubtasks as $subtask)
            <tr>
                <td>
                    @if(isset($publicSubtasks[$subtask->id]))
                    {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'checked' =>'true']) !!}
                    @else
                    {!! Form::formInput('subtasks['.$subtask->id.'][name]', $subtask->name, $errors, ['class' =>
                    'form-control', 'type' => 'checkbox', 'checked' =>'false']) !!}
                    @endif
                </td>
                <td>
                    @if(isset($publicSubtasks[$subtask->id]))
                    {!! Form::formInput('subtasks['.$subtask->id.'][comments]', '', $errors, ['class' =>
                    'form-control', 'value' => $publicSubtasks[$subtask->id]]) !!}
                    @else
                    {!! Form::formInput('subtasks['.$subtask->id.'][comments]', '', $errors, ['class' =>
                    'form-control', 'placeholder' => 'Περιγραφή']) !!}
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