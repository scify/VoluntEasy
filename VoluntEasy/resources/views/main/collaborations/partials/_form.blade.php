<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::formInput('name', trans('entities/collaborations.name') .':', $errors, ['class' => 'form-control', 'id' =>
                    'collabName', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    @if (isset($collaboration))
                    {!! Form::formInput('type_id', trans('entities/collaborations.type') .':', $errors, ['class' => 'form-control', 'type' =>
                    'select', 'value' => $collaborationTypes, 'key' => $collaboration->type_id, 'required' => 'true']) !!}
                    @else
                    {!! Form::formInput('type_id', trans('entities/collaborations.type') .':', $errors, ['class' => 'form-control', 'type' =>
                    'select', 'value' => $collaborationTypes, 'required' => 'true']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::formInput('comments', trans('entities/collaborations.description') .':', $errors, ['class' => 'form-control', 'type' =>
                    'textarea',
                    'size' =>
                    '5x5', 'id' => 'collabDescription']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('start_date', trans('entities/collaborations.startDate') .':', $errors, ['class' => 'form-control
                    startDate', 'id' => 'collabStartDate', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('end_date', trans('entities/collaborations.endDate') .':', $errors, ['class' => 'form-control endDate',
                    'id' => 'collabEndDate', 'required' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('address', trans('entities/collaborations.collabAddress') .':', $errors, ['class' => 'form-control', 'id' =>
                    'collabAddress']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::formInput('phone', trans('entities/collaborations.collabPhone') .':', $errors, ['class' => 'form-control', 'id' =>
                    'collabPhone'])
                    !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h5>{{trans('entities/collaborations.execInfo')}}</h5>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration) && sizeof($collaboration->executives)>0)
                    {!! Form::hidden('executive_id', $collaboration->executives[0]->id, ['id' => 'executive_id']) !!}
                    {!! Form::formInput('execName', trans('entities/collaborations.name') .':', $errors, ['class' => 'form-control', 'value' =>
                    $collaboration->executives[0]->name]) !!}
                    @else
                    {!! Form::formInput('execName', trans('entities/collaborations.name') .':', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration) && sizeof($collaboration->executives)>0)
                    {!! Form::formInput('execEmail', trans('entities/collaborations.email') .':', $errors, ['class' => 'form-control', 'value' =>
                    $collaboration->executives[0]->email]) !!}
                    @else
                    {!! Form::formInput('execEmail', trans('entities/collaborations.email') .':', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration) && sizeof($collaboration->executives)>0)
                    {!! Form::formInput('execAddress', trans('entities/collaborations.address') .':', $errors, ['class' => 'form-control', 'value' =>
                    $collaboration->executives[0]->address]) !!}
                    @else
                    {!! Form::formInput('execAddress', trans('entities/collaborations.address') .':', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if (isset($collaboration) && sizeof($collaboration->executives)>0)
                    {!! Form::formInput('execPhone', trans('entities/collaborations.phone') .':', $errors, ['class' => 'form-control', 'value' =>
                    $collaboration->executives[0]->phone]) !!}
                    @else
                    {!! Form::formInput('execPhone', trans('entities/collaborations.phone') .':', $errors, ['class' => 'form-control']) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::formInput('files[]', trans('entities/collaborations.uploadFiles') .':', $errors, ['class' => 'form-control', 'type' =>
                    'file', 'multiple' => 'true'])
                    !!}
                    <small class="help-blocκ">{{ trans('entities/collaborations.moreThanOneFile') }}</small>
                    <br/>
                    <small class="help-blocκ">{{ trans('entities/collaborations.lessThan10gb') }}</small>
                </div>
                @if(isset($collaboration))
                <div class="form-group">
                    @if(sizeof($collaboration->files)>0)
                    <p>{{ trans('entities/collaborations.uploadedFiles') }}:</p>

                    <table class="table table-condensed table-bordered">

                        @foreach($collaboration->files as $file)
                        <tr>
                            <td><i class="fa fa-file-o"></i> <a
                                    href="{{ asset('assets/uploads/collaborations/'.$file->filename) }}" target="_blank">{{
                                    $file->filename }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success', 'id' => 'saveCollaboration']) !!}
    </div>
</div>
