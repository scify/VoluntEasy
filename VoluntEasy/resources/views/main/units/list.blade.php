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
                @section('table')
                @include('main.units.partials._table', ['units' => $units])
                @endsection
                <div id="table">
                    @yield('table')
                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    //Submit the form through ajax.
    //The result data is the html of the table.
    $('#searchForm').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            headers: {
                'X-XSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                $("#table").html(data);
                console.log(data);
            }
        });
        return false; // prevent send form
    });
</script>
@stop
