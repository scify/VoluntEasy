@extends('default')

@section('title')
Προβολή Εθελοντών
@stop
@section('pageTitle')
Προβολή Εθελοντών
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Αναζήτηση</h4>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['VolunteerController@search'], 'class' =>
                'form-inline', 'id' => 'searchForm']) !!}
                @include('main.volunteers.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές</h4>
            </div>
            <div class="panel-body">
                @section('table')
                @include('main.volunteers.partials._table', ['volunteers' => $volunteers])
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
    $(".delete").click(function () {
        if (confirm("Delete user?") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/users/delete/' + $(this).attr('data-id'),
                method: 'POST',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/users";
                }
            });
        }
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
@append
