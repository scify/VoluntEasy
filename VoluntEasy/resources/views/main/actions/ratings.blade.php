@extends('default')

@section('title')
{{ trans('entities/actions.ratings') }}
@stop

@section('pageTitle')
{{ trans('entities/actions.ratings') }}
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">{{ trans('entities/actions.totalRatings') }}</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                @if(sizeof($action->ratings)>0)

                <table class="table table-hover table-striped text-center">
                    <thead class="small middle">
                    <th></th>
                    @foreach($attributes as $attribute)
                    <th>{{ $attribute->description }}</th>
                    @endforeach
                    <th>{{ trans('entities/actions.comments') }}</th>

                    </thead>
                    <tbody>
                    @foreach($ratings as $rating)
                    <tr>
                        <td>{{ trans('entities/ratings.rating') }} #{{$rating->id}}</td>
                        @if(sizeof($rating->ratings)>0)
                            @foreach($rating->ratings as $score)
                                <td>{{ $score->description }}</td>
                            @endforeach
                            <td>{{ $rating->comments }}</td>
                        @else
                            <td colspan="{{ sizeof($attributes) }}"></td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <p>{{ trans('entities/actions.noRatings') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
