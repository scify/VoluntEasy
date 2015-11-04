@extends('default')

@section('title')
Αξιολογήσεις Δράσης
@stop

@section('pageTitle')
Αξιολογήσεις Δράσης
@stop


@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Συνολικές αξιολογήσεις για τη δράση</h4>

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
                    <th>Σχόλια</th>

                    </thead>
                    <tbody>
                    @foreach($ratings as $rating)
                    <tr>
                        <td>Αξιολόγηση #{{$rating->id}}</td>
                        @if(sizeof($rating->ratings)>0)
                            @foreach($rating->ratings as $score)
                                <td>{{ $score->description }}</td>
                            @endforeach
                            <td>{{ $rating->comments }}</td>
                        @else
                            <td colspan="{{ $sizeof($attributes) }}">dsdfs</td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <p>Δεν υπάρχουν αξιολογήσεις για τη δράση.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
