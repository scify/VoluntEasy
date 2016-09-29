<div class="row">
    <div class="col-md-4">
        <p><strong>{{ trans('entities/volunteers.fathersName') }}:</strong> {{ $volunteer->fathers_name=='' ? '-' :
            $volunteer->fathers_name }}</p>

        <p><strong>{{ trans('entities/volunteers.birthDate') }}:</strong>
            @if($volunteer->age>0)
            {{ $volunteer->birth_date }}
            @else
            -
            @endif</p>

        <p><strong>{{ trans('entities/volunteers.workTel') }}:</strong> {{ $volunteer->work_tel=='' ? '-' :
            $volunteer->work_tel
            }} @if ($volunteer->comm_method_id==3) <i class="fa fa-star" data-toggle="tooltip"
                                                      title="{{ trans('entities/volunteers.preferredContactWay') }}"></i>
            @endif</p>

        <p><strong>{{ trans('entities/volunteers.homeTel') }}:</strong> {{ $volunteer->home_tel=='' ? '-' :
            $volunteer->home_tel }} @if ($volunteer->comm_method_id==2) <i class="fa fa-star" data-toggle="tooltip"
                                                                           title="{{ trans('entities/volunteers.preferredContactWay') }}"></i>
            @endif</p>

        @if(env('MODE') !== 'municipality')
        <p><strong>{{ trans('entities/volunteers.fax') }}:</strong> {{ $volunteer->fax=='' ? '-' : $volunteer->fax }}
        </p>
        @endif

    </div>
    <div class="col-md-4">
        <p><strong>{{ trans('entities/volunteers.address') }}:</strong> {{ $volunteer->address=='' ? '-' :
            $volunteer->address }}{{
            $volunteer->city=='' ? '' : ', '.$volunteer->city }}{{ $volunteer->post_box==''
            ? '' : ', '.$volunteer->post_box }}{{ $volunteer->country=='' ? '' : ',
            '.$volunteer->country }}
        </p>

        @if(env('MODE') !== 'municipality')
        <p><strong>{{ trans('entities/volunteers.livesInCurrCountry') }}:</strong> {{
            $volunteer->live_in_curr_country==0 ? trans('default.no') : trans('default.yes') }}</p>
        @endif

        <p><strong>{{ trans('entities/volunteers.idType') }}:</strong> {{
            $volunteer->identification_type_id=='' || $volunteer->identification_type_id==null ? '-' :
            $volunteer->identificationType->description }}

            <strong>{{ trans('entities/volunteers.idNumber') }}:</strong> {{
            $volunteer->identification_num=='' || $volunteer->identification_num==null ? '-' :
            $volunteer->identification_num }}</p>

        @if(env('MODE') !== 'municipality')
        <p><strong>{{ trans('entities/volunteers.afm') }}:</strong> {{
            $volunteer->afm=='' || $volunteer->afm==null ? '-' : $volunteer->afm }}</p>
        @else
        <p><strong>{{ trans('entities/volunteers.amka') }}:</strong> {{
            $volunteer->amka=='' || $volunteer->amka==null ? '-' : $volunteer->amka }}</p>
        @endif

        <p><strong>{{ trans('entities/volunteers.contractDate') }}:</strong> {{
            $volunteer->contract_date=='' || $volunteer->contract_date==null ? '-' : $volunteer->contract_date }}</p>
    </div>
    <div class="col-md-4">
        @if(env('MODE') !== 'municipality')
        <p><strong>{{ trans('entities/volunteers.maritalStatus') }}:</strong> {{
            $volunteer->marital_status_id=='' || $volunteer->marital_status_id==null ? '-' :
            $volunteer->maritalStatus->description }}</p>

            <p><strong>{{ trans('entities/volunteers.childNum') }}:</strong> {{$volunteer->children}}</p>
        @endif
    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class="panel-group small" id="accordion" role="tablist"
     aria-multiselectable="true">
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
               href="#collapseOne"
               aria-expanded="false" aria-controls="collapseOne"> <i
                    class="fa fa-university m-r-xs"></i>
                {{ trans('entities/volunteers.educationAndSkills') }}
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
         aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>{{ trans('entities/volunteers.educationLevel') }}:</strong> {{
                        $volunteer->education_level_id=='' || $volunteer->education_level_id==null ? '-' :
                        $volunteer->educationLevel->description }}</p>

                    <p><strong>{{ trans('entities/volunteers.specialty') }}:</strong> {{ $volunteer->specialty=='' ? '-'
                        :
                        $volunteer->specialty }}</p>

                    <p><strong>{{ trans('entities/volunteers.department') }}:</strong> {{ $volunteer->department=='' ?
                        '-' :
                        $volunteer->department }}</p>

                    <p><strong>{{ trans('entities/volunteers.driverLicenceType') }}:</strong> {{
                        $volunteer->driver_license_type_id==null || $volunteer->driver_license_type_id=='' ? '' :
                        $volunteer->driverLicenceType->description }}</p>

                    <p><strong>{{ trans('entities/volunteers.computerUsage') }}:</strong> {{
                        $volunteer->computer_usage=='' ? trans('default.no') : trans('default.yes') }}</p>

                    {{-- Extras--}}
                    @if(in_array('knows_office', $extras))
                    @include($extrasPath.'._knows_office_view')
                    @endif

                    <p><strong>{{ trans('entities/volunteers.computerUsageComments') }}:</strong>
                        {{$volunteer->computer_usage_comments }}</p>
                </div>
                <div class="col-md-4">
                    <h4>{{ trans('entities/volunteers.foreignLanguages') }}</h4>
                    @if($volunteer->languages==null ||
                    sizeof($volunteer->languages)==0)
                    <p><em>{{ trans('entities/volunteers.noForeignLanguage') }}</em></p>
                    @else
                    @foreach($volunteer->languages as $language)
                    <p>
                        {{ $language->language->description }}:
                        <em>{{ trans('entities/volunteers.level') }} {{ $language->level->description }}</em>
                    </p>
                    @endforeach
                    @endif
                    @if($volunteer->extra_lang!=null || $volunteer->extra_lang!='')
                    <p><strong>{{ trans('entities/volunteers.extraLanguages') }}:</strong> {{ $volunteer->extra_lang }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
               href="#collapseTwo"
               aria-expanded="false" aria-controls="collapseTwo"><i
                    class="fa fa-cog m-r-xs"></i>{{ trans('entities/volunteers.workAndVolunteeringExp') }}
            </a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
         aria-labelledby="headingTwo">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {{-- Extras--}}
                    @if(in_array('knows_office', $extras))
                    @include($extrasPath.'._work_and_volunteering_view')
                    @else
                    <p><strong>{{ trans('entities/volunteers.workStatus') }}:</strong> {{
                        $volunteer->work_status_id==null || $volunteer->work_status_id=='' ? '' :
                        $volunteer->workStatus->description }}</p>

                    <p><strong>{{ trans('entities/volunteers.workDescription') }}:</strong> {{
                        $volunteer->work_description=='' ? '-' :
                        $volunteer->work_description }}</p>

                    <p><strong>{{ trans('entities/volunteers.volunteeringOrg') }}:</strong> {{
                        $volunteer->participation_actions=='' ?
                        '-' :
                        $volunteer->participation_actions }}</p>

                    <p><strong>{{ trans('entities/volunteers.volunteeringPrev') }}:</strong> {{
                        $volunteer->participation_previous=='' ?
                        '-' :
                        $volunteer->participation_previous }}</p>

                    <p><strong>{{ trans('entities/volunteers.participationReason') }}:</strong> {{
                        $volunteer->participation_reason=='' ? '-' :
                        $volunteer->participation_reason }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
               href="#collapseThree" aria-expanded="false"
               aria-controls="collapseThree">
                <i class="fa fa-clock-o m-r-xs"></i>{{ trans('entities/volunteers.availabilityAndInterests') }}
            </a>
        </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
         aria-labelledby="headingThree">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    {{-- Extras--}}
                    @if(in_array('availability', $extras))
                    @include($extrasPath.'._availability_view')
                    @else
                    <p><strong>{{ trans('entities/volunteers.contributionRate') }}:</strong> {{
                        $volunteer->availability_freqs_id==null || $volunteer->availability_freqs_id=='' ? '' :
                        $volunteer->availabilityFrequencies->description }}</p>

                    <p><strong>{{ trans('entities/volunteers.availabilityTimes') }}:</strong>
                        @if($volunteer->availabilityTimes!=null ||
                        sizeof($volunteer->availabilityTimes)!=0)
                        @foreach($volunteer->availabilityTimes as $availabilityTime)
                        {{ \Lang::get('entities/volunteers.' . $availabilityTime->description) }}
                        @endforeach
                        @endif

                        @endif

                        @if(sizeof($volunteer->unitsExcludes)>0)

                    <p><strong>{{ trans('entities/volunteers.unitsExcludes') }}:</strong>
                        @foreach($volunteer->unitsExcludes as $i => $unit)
                        @if($i>0)
                        , {{ $unit->description }}
                        @else
                        {{ $unit->description }}
                        @endif
                        @endforeach
                    </p>
                    @endif

                    {{-- Extras--}}
                    @if(in_array('knows_office', $extras))
                    @include($extrasPath.'._how_you_learned_view')
                    @endif
                </div>
                <div class="col-md-8">
                    <h4>{{ trans('entities/volunteers.interests') }}</h4>
                    @if($volunteer->interests==null ||
                    sizeof($volunteer->interests)==0)
                    <p><em>{{ trans('entities/volunteers.noInterest') }}</em></p>
                    @else
                    <p>
                        @foreach($volunteer->interests as $i => $interest)
                        @if($i==0)
                        {{ $interest->description }}
                        @else
                        , {{ $interest->description }}
                        @endif
                        @endforeach
                    </p>
                    @endif
                    @if($volunteer->additional_skills!=null ||
                    $volunteer->additional_skills!='')
                    <p>{{ trans('entities/volunteers.additionalSkills') }}: {{
                        $volunteer->additional_skills }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if($volunteer->permitted)
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
               href="#collapseFour" aria-expanded="false"
               aria-controls="collapseFour">
                <i class="fa fa-file-o m-r-xs"></i>{{ trans('entities/volunteers.files') }}
            </a>
        </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
         aria-labelledby="headingFour">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    @if(sizeof($volunteer->files)>0)

                    <table class="table table-condensed table-bordered">

                        @foreach($volunteer->files as $file)
                        <tr>
                            <td><p><i class="fa fa-file-o"></i> <a
                                        href="{{ asset('assets/uploads/volunteers/'.$file->filename) }}"
                                        target="_blank">{{
                                        $file->filename }}</a></p>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-xs deleteFile" data-id="{{ $file->id }}"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="{{ trans('default.delete') }}"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</div>
</div>
</div>

<div class="row">
    <div class="col-md-12">
        <h3>{{ trans('entities/volunteers.commentsAboutVolunteer') }}</h3>
        @if($volunteer->comments=='')
        <p>{{ trans('entities/volunteers.noComment') }}</p>
        @else
        <p>{{ $volunteer->comments }}</p>
        @endif
        @if(!$customRatings)
        <h3>{{ trans('entities/volunteers.totalVolunteerRating') }}</h3>
        @foreach($totalRatings as $rating)
        @if($rating['count']!=0)
        <span id="attr1" class="attribute rating" data-score="{{ $rating['totalRating'] / $rating['count'] }}"></span>
        <small><span> {{ $rating['description'] }}</span></small>
        <br/>
        @else
        <span id="attr1" class="attribute rating" data-score="0"></span>
        <small><span> {{ $rating['description'] }}</span></small>
        <br/>
        @endif
        @endforeach
        @endif
        @if($volunteer->permitted)
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ url('volunteers/edit/'.$volunteer->id) }}" class="btn btn-success"><i
                        class="fa fa-edit"></i> {{ trans('default.edit') }}</a>
                <button class="btn btn-danger" onclick="deleteVolunteer({{$volunteer->id}})"><i
                        class="fa fa-trash"></i> {{ trans('default.delete') }}
                </button>
            </div>
        </div>
        @endif
        @if(!$volunteer->blacklisted && !$volunteer->not_available && $volunteer->permitted)
        <div class="row">
            <div class="col-md-12 text-right">
                <small><a href="#" class="text-danger" data-toggle="modal" data-target="#notAvailable">{{
                        trans('entities/volunteers.markAsNotAvailable') }}</a></small>
            </div>
        </div>
        @endif
        @if(!$volunteer->blacklisted && $volunteer->permitted)
        <div class="row">
            <div class="col-md-12 text-right">
                <small><a href="#" class="text-danger" data-toggle="modal" data-target="#blacklisted">{{
                        trans('entities/volunteers.markAsBlacklisted') }}</a></small>
            </div>
        </div>
        @endif
    </div>
</div>


@if(!$volunteer->blacklisted && !$volunteer->not_available && $volunteer->permitted)
<!-- Select unit modal -->
<div class="modal fade" id="notAvailable">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/volunteers.markAsNotAvailable') }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ trans('entities/volunteers.markAsNotAvailableExpl') }}</p>

                <div class="row">
                    <div class="col-md-6">
                        {!! Form::formInput('not_available_from', trans('entities/volunteers.from').':', $errors,
                        ['class' => 'form-control
                        startDate', 'id' => 'not_available_from', 'required' => 'true']) !!}
                        <small class="help-block text-danger" id="fillDateFrom" style="display:none;">{{
                            trans('entities/volunteers.fillField') }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        {!! Form::formInput('not_available_to', trans('entities/volunteers.to').':', $errors, ['class'
                        => 'form-control
                        endDate', 'id' => 'not_available_to', 'required' => 'true']) !!}
                        <small class="help-block text-danger" id="fillDateTo" style="display:none;">{{
                            trans('entities/volunteers.fillField') }}
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::formInput('not_available_comments', trans('entities/volunteers.comments').':',
                        $errors, ['class' => 'form-control', 'type' =>
                        'textarea']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                <button type="button" class="btn btn-danger notAvailable" data-volunteer-id="{{ $volunteer->id }}">{{
                    trans('default.save') }}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif

@if(!$volunteer->blacklisted && $volunteer->permitted)
<!-- Select unit modal -->
<div class="modal fade" id="blacklisted">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('entities/volunteers.markAsBlacklisted') }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ trans('entities/volunteers.markAsBlacklistedExpl') }}</p>
                {!! Form::formInput('comments', trans('entities/volunteers.comments').':', $errors, ['class' =>
                'form-control', 'type' =>
                'textarea', 'placeholder' => trans('entities/volunteers.commentsAboutVolunteer'), 'value' =>
                $volunteer->comments, 'id' => 'blacklistedComments']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('default.close') }}</button>
                <button type="button" class="btn btn-danger blacklisted" data-volunteer-id="{{ $volunteer->id }}">{{
                    trans('default.save') }}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif


@section('footerScripts')
<script>

    $('.attribute.rating').raty({
        starOff: '{{ asset("assets/plugins/raty/lib/images/star-off.png")}}',
        starOn: '{{ asset("assets/plugins/raty/lib/images/star-on.png")}}',
        starHalf: '{{ asset("assets/plugins/raty/lib/images/star-half.png")}}',
        readOnly: true,
        score: function () {
            return $(this).attr('data-score');
        }
    });

    //change volunteer status to blacklisted
    $(".blacklisted").click(function () {
        $.ajax({
            url: $("body").attr('data-url') + '/volunteers/blacklisted',
            method: 'POST',
            data: {
                'id': $(this).attr('data-volunteer-id'),
                'comments': $("#blacklistedComments").val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
            }
        });
    });

    //change volunteer status to not available
    $(".notAvailable").click(function () {
        var from = $("#not_available_from").val(),
            to = $("#not_available_to").val(),
            flag = true;

        if (from == null || from == '') {
            $("#fillDateFrom").show();
            flag = false;
        }
        else
            $("#fillDateFrom").hide();

        if (to == null || to == '') {
            $("#fillDateTo").show();
            flag = false;
        }
        else
            $("#fillDateTo").hide();

        if (flag) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/notAvailable',
                method: 'POST',
                data: {
                    'id': $(this).attr('data-volunteer-id'),
                    'from': from,
                    'to': to,
                    'comments': $("#not_available_comments").val()
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/volunteers/one/" + data;
                }
            });
        }
    });


    //delete a file
    $(".deleteFile").click(function () {
        console.log("clicky");
        if (confirm(Lang.get('js-components.deleteFile'))) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/deleteFile',
                method: 'POST',
                data: {
                    'id': $(this).attr('data-id')
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    document.location.reload();
                }
            });
        }
    });

</script>
@append
