@extends('default')

@section('title')
Προβολή Μονάδων
@stop
@section('pageTitle')
Προβολή Μονάδων
@stop

@section('bodyContent')


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['UnitController@search'], 'id' => 'searchForm']) !!}
                @include('main.units.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Μονάδες</h4>
            </div>
            <div class="panel-body">
                @include('main.units.partials._table')
            </div>
        </div>
    </div>
</div>
@stop

@section('footerScripts')
<script>
    $(".skata").click(function () {
        console.log('click')
        if (confirm("Delete unit?") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/unit/delete/' + $(this).attr('data-id'),
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                }
            });
        }
    });
</script>
@append
