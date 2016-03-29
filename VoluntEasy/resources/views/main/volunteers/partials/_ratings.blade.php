@if(sizeof($volunteer->opaRatings)>0)
<div class="row">
    <div class="col-md-12">
        <div class="panel-group small" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($volunteer->opaRatings as $rating)
            <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse-{{ $rating->id }}"
                           aria-expanded="false" aria-controls="collapseOne"> {{ trans('entities/actions.action') }}
                            <strong>{{
                                $rating->action->description }}</strong>, {{ trans('entities/volunteers.ratedBy') }} {{
                            $rating->user->name }} {{ $rating->user->last_name }} {{
                            trans('entities/volunteers.ratedWhen') }} {{
                            \Carbon::parse($rating->created_at)->format('d/m/Y') }}
                        </a>
                    </h4>
                </div>
                <div id="collapse-{{ $rating->id }}" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>1. {{ trans('entities/ratings.actionDescription') }}</strong></p>

                                <p>{{ $rating->actionDescription==null || $rating->actionDescription=="" ? '-' : $rating->actionDescription }}</p>

                                <p><strong>2. {{ trans('entities/ratings.problemsOccured') }}</strong></p>

                                <p>{{ $rating->problemsOccured==null || $rating->problemsOccured=="" ? '-' : $rating->problemsOccured }}</p>

                                <p><strong>3. {{ trans('entities/ratings.laborAndInterpersonalSkills') }}</strong></p>

                                <div class="row">
                                    @if(sizeof($rating->laborSkills)>0)
                                    <div class="col-md-6">
                                        <table class="table table-condensed table-bordered">
                                            <thead>
                                            <th>{{ trans('entities/ratings.laborSkills') }}</th>
                                            <th>{{ trans('entities/ratings.strongOrWeak') }}</th>
                                            <th>{{ trans('entities/ratings.commentsEtc') }}</th>
                                            </thead>
                                            <tbody>
                                            @foreach($rating->laborSkills as $skill)
                                            <tr>
                                                <td>{{ $skill->skill->description }}</td>
                                                <td>
                                                    @if($skill->needsImprovement==1)
                                                    {{ trans('entities/ratings.weak') }}
                                                    @elseif($skill->needsImprovement==0)
                                                    {{ trans('entities/ratings.strong') }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>@if($skill->comments==null || $skill->comments=="")
                                                    -
                                                    @else
                                                    {{ $skill->comments }}
                                                    @endif</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    @if(sizeof($rating->interpersonalSkills)>0)
                                    <div class="col-md-6">
                                        <table class="table table-condensed table-bordered">
                                            <thead>
                                            <th>{{ trans('entities/ratings.interpersonalSkills') }}</th>
                                            <th>{{ trans('entities/ratings.strongOrWeak') }}</th>
                                            <th>{{ trans('entities/ratings.commentsEtc') }}</th>
                                            </thead>
                                            <tbody>
                                            @foreach($rating->interpersonalSkills as $skill)
                                            <tr>
                                                <td>{{ $skill->skill->description }}</td>
                                                <td>
                                                    @if($skill->needsImprovement==1)
                                                    {{ trans('entities/ratings.weak') }}
                                                    @elseif($skill->needsImprovement==0)
                                                    {{ trans('entities/ratings.strong') }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($skill->comments==null || $skill->comments=="")
                                                    -
                                                    @else
                                                    {{ $skill->comments }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>

                                <p><strong>4. {{ trans('entities/ratings.nextSteps') }}</strong></p>

                                <p> {{ trans('entities/ratings.fieldsToImprove') }}: {{ $rating->fieldsToImprove==null || $rating->fieldsToImprove=="" ? '-' : $rating->fieldsToImprove }}</p>

                                <p> {{ trans('entities/ratings.training') }}: {{ $rating->training==null || $rating->training=="" ? '-' : $rating->training }}</p>

                                <p> {{ trans('entities/ratings.objectives') }}: {{ $rating->objectives==null || $rating->objectives=="" ? '-' : $rating->objectives }}</p>

                                <p> {{ trans('entities/ratings.support') }}: {{ $rating->support==null || $rating->support=="" ? '-' : $rating->support }}</p>

                                <p><strong>5. {{ trans('entities/ratings.generalComments') }}</strong></p>

                                <p>{{ $rating->generalComments==null || $rating->generalComments=="" ? '-' : $rating->generalComments }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<h3> {{ trans('entities/volunteers.noRatings') }}</h3>
@endif
